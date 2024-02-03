<?php
include 'dbcon.php';
include 'header.php';
include 'js_datatable.php';

// Function to rearrange data based on conditions
function rearrangeData($conn)
{
    $sql = "
    SELECT *
    FROM merged_data
    WHERE exam_date IN (
        SELECT exam_date
        FROM merged_data
        GROUP BY exam_date
        HAVING COUNT(DISTINCT exam_time) > 1
    )
    ORDER BY student_code, exam_date, exam_time;
    ";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return array('error' => 'An error occurred while processing the request.');
    }

    $rearrangedData = array();
    $lastExamTime = array();

    foreach ($result as $row) {
        $studentCode = $row['student_code'];
        $examDate = $row['exam_date'];
        $examTime = strtotime($row['exam_time']);

        if (!isset($lastExamTime[$studentCode][$examDate]) || $examTime - $lastExamTime[$studentCode][$examDate] >= 4 * 3600) {
            $rearrangedData[] = $row;
            $lastExamTime[$studentCode][$examDate] = $examTime;
        }
    }

    // Call the heuristicAlgorithm function to further process the conflicts
    $availableSlots = fetchAvailableSlots($conn);
    heuristicAlgorithm($rearrangedData, $availableSlots, $conn);

    return array('data' => $rearrangedData);
}
// Function to fetch data from the database
function fetchDataFromDatabase($conn)
{
    // Modify this SQL query to fetch your data from the database
    $sql = "SELECT * FROM merged_data";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array('data' => $result);
    } catch (PDOException $e) {
        return array('error' => 'An error occurred while processing the request.');
    }
}

// Function to fetch available time slots from merged_data table within two weeks (Monday to Friday)
function fetchAvailableSlots($conn)
{
    // Calculate the end date as two weeks from the current date
    $endDate = date('Y-m-d', strtotime('+2 weeks'));

    $sql = "
        SELECT DISTINCT exam_time
        FROM merged_data
        WHERE exam_date BETWEEN CURDATE() AND :end_date
          AND DAYOFWEEK(exam_date) BETWEEN 2 AND 6
    ";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    } catch (PDOException $e) {
        return array();
    }
}

// Function to insert rearranged data into the conflict_resolution table
function insertIntoConflictResolution($conn, $rearrangedData)
{
    try {
        $conn->beginTransaction();

        foreach ($rearrangedData as $row) {
            $sql = "INSERT INTO conflict_resolution (student_code, exam_day, exam_date, exam_time, venue_name, timeslot_group_name, group_capacity, timeslot_subject_code, timeslot_subject_name, timeslot_lect_name, invigilator_name) VALUES (:student_code, :exam_day, :exam_date, :exam_time, :venue_name, :timeslot_group_name, :group_capacity, :timeslot_subject_code, :timeslot_subject_name, :timeslot_lect_name, :invigilator_name)";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':student_code', $row['student_code']);
            $stmt->bindParam(':exam_day', $row['exam_day']);
            $stmt->bindParam(':exam_date', $row['exam_date']);
            $stmt->bindParam(':exam_time', $row['exam_time']);
            $stmt->bindParam(':venue_name', $row['venue_name']);
            $stmt->bindParam(':timeslot_group_name', $row['timeslot_group_name']);
            $stmt->bindParam(':group_capacity', $row['group_capacity']);
            $stmt->bindParam(':timeslot_subject_code', $row['timeslot_subject_code']);
            $stmt->bindParam(':timeslot_subject_name', $row['timeslot_subject_name']);
            $stmt->bindParam(':timeslot_lect_name', $row['timeslot_lect_name']);
            $stmt->bindParam(':invigilator_name', $row['invigilator_name']);

            if ($stmt->execute()) {
                header('Location:check_with_special_cases.php');
            } else {
                return array('error' => 'An error occurred while processing the request.');
            }
        }

        $conn->commit();
        return array('success' => 'Data processed successfully.');
    } catch (PDOException $e) {
        $conn->rollBack();
        return array('error' => 'An error occurred while processing the request.');
    }
}

// Function to identify conflicts
function identifyConflicts($data)
{
    // Initialize an empty array to store conflicts
    $conflicts = array();

    // Iterate through the data to identify conflicts
    for ($i = 0; $i < count($data); $i++) {
        $studentCode1 = $data[$i]['student_code'];
        $examDate1 = $data[$i]['exam_date'];

        for ($j = $i + 1; $j < count($data); $j++) {
            $studentCode2 = $data[$j]['student_code'];
            $examDate2 = $data[$j]['exam_date'];

            // Check if the same student has multiple exams on the same date
            if ($studentCode1 == $studentCode2 && $examDate1 == $examDate2) {
                $conflicts[] = array(
                    'student_code' => $studentCode1,
                    'exam_date' => $examDate1,
                    'exam_time' => $data[$i]['exam_time'], // Store the conflicting exam times
                );
                $conflicts[] = array(
                    'student_code' => $studentCode2,
                    'exam_date' => $examDate2,
                    'exam_time' => $data[$j]['exam_time'],
                );
            }
        }
    }

    return $conflicts;
}

function heuristicAlgorithm(&$conflicts, $availableSlots, $conn)
{
    $gapDuration = 4 * 3600; // 4 hours in seconds

    // Create a map to track the last exam end time and group names for each student on a given exam day
    $lastEndTimeMap = array();

    foreach ($conflicts as &$conflict) {
        $studentCode = $conflict['student_code'];
        $examDate = $conflict['exam_date'];

        // Check if the student has multiple exams in different group names on the same date
        if (isset($conflict['group_names']) && is_array($conflict['group_names'])) {
            $groupNames = $conflict['group_names'];

            if (count(array_unique($groupNames)) < count($groupNames)) {
                // Rearrange exams with a 4-hour gap
                $examTime = strtotime($conflict['exam_time']);

                // Check if there's a previous exam on the same day for the same student
                if (isset($lastEndTimeMap[$studentCode][$examDate])) {
                    $lastEndTime = $lastEndTimeMap[$studentCode][$examDate];

                    // Ensure a 4-hour gap between exams
                    if ($examTime - $lastEndTime < $gapDuration) {
                        // Adjust the conflicting exam time
                        $newExamTime = date("H:i:s", $lastEndTime + $gapDuration);

                        // Check if the adjusted time is within the available slots
                        if (in_array($newExamTime, $availableSlots)) {
                            $conflict['exam_time'] = $newExamTime;
                            // Update the last end time for the student on the exam day
                            $lastEndTimeMap[$studentCode][$examDate] = strtotime($newExamTime);
                            continue; // Move to the next conflict
                        }
                    }
                }

                // If a 4-hour gap cannot be achieved on the same day, find another available slot on subsequent days
                $newExamTime = findAvailableSlotOnSubsequentDays($conn, $studentCode, $examDate, $availableSlots);
                if ($newExamTime !== false) {
                    $conflict['exam_date'] = $examDate; // Update the exam date
                    $conflict['exam_time'] = $newExamTime;
                    // Update the last end time for the student on the exam day
                    $lastEndTimeMap[$studentCode][$examDate] = strtotime($newExamTime);
                } else {
                    // If no available slots are found, log or handle accordingly
                    $conflict['error'] = 'Unable to find available slots after multiple attempts.';
                }
            }
        }
    }
}


// Function to find an available slot from the given time slots and existing exams
function findAvailableSlot($availableSlots, $existingExams)
{
    foreach ($availableSlots as $slot) {
        if (!in_array($slot, $existingExams)) {
            return $slot;
        }
    }

    return false; // Unable to find an available slot
}
// Process form submission
$formMessages = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["rearrange"])) {
        // Call the rearrangeData function
        $result = rearrangeData($conn);

        if (isset($result['data'])) {
            $rearrangedData = $result['data'];

            // Check if there is data to insert
            if (!empty($rearrangedData)) {
                // Insert data into the conflict_resolution table
                $result = insertIntoConflictResolution($conn, $rearrangedData);

                if (isset($result['success'])) {
                    $formMessages['success'] = $result['success'];
                } elseif (isset($result['error'])) {
                    $formMessages['error'] = 'An error occurred while processing the request.';
                }
            } else {
                $formMessages['error'] = 'No data to insert.';
            }
        } elseif (isset($result['error'])) {
            $formMessages['error'] = 'An error occurred while processing the request.';
        }
    } elseif (isset($_POST["identifyConflicts"])) {
        // Call the identifyConflicts function
        $data = fetchDataFromDatabase($conn);
        $conflicts = identifyConflicts($data);

        // Call the heuristicAlgorithm function with available slots
        $availableSlots = fetchAvailableSlots($conn);
        heuristicAlgorithm($conflicts, $availableSlots);

        // Display conflicts or no conflicts message
        if (!empty($conflicts)) {
            $formMessages['warning'] = 'Conflicts identified.';
        } else {
            $formMessages['success'] = 'No conflicts identified.';
        }
    }
}
?>




<div class="container-fluid">
    <div class="row">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left: 35%; width: 35%; background-color: rgba(0, 15, 180, .2); padding: 3%; border-radius: 5%;">
                <div class="panel panel-default">
                    <center>
                        <div class="panel-heading">
                            <h1 style="text-align: center;">PROCESS FINAL COPY FOR THE EXAM SCHEDULE</h1>
                        </div>
                        <div class="panel-body">
                            <?php
                            if (isset($formMessages['success'])) {
                                echo '<div class="alert alert-success" role="alert">' . $formMessages['success'] . '</div>';
                            } elseif (isset($formMessages['error'])) {
                                echo '<div class="alert alert-danger" role="alert">An error occurred while processing the request.</div>';
                            } elseif (isset($formMessages['warning'])) {
                                echo '<div class="alert alert-warning" role="alert">' . $formMessages['warning'] . '</div>';
                            }
                            ?>
                            <form method="POST">
                                <input type="submit" name="rearrange" class="btn btn-primary" value="Process">
                                <a href="individual_exam_schedule.php" style="text-decoration:none;"><span class="fas fa-times btn btn-danger"></span></a>
                            </form>
                        </div>
                    </center>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>
