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

// Heuristic Algorithm Implementation
function heuristicAlgorithm(&$conflicts)
{
    $gapDuration = 4 * 3600; // 4 hours in seconds

    // Create a map to track the last exam end time for each student on a given exam day
    $lastEndTimeMap = array();

    foreach ($conflicts as &$conflict) {
        $studentCode = $conflict['student_code'];
        $examDate = $conflict['exam_date'];
        $examTime = strtotime($conflict['exam_time']);

        // Check if there's a previous exam on the same day for the same student
        if (isset($lastEndTimeMap[$studentCode][$examDate])) {
            $lastEndTime = $lastEndTimeMap[$studentCode][$examDate];

            // Ensure a 4-hour gap between exams
            if ($examTime - $lastEndTime < $gapDuration) {
                // Adjust the conflicting exam time
                $newExamTime = date("H:i:s", $lastEndTime + $gapDuration);
                $conflict['exam_time'] = $newExamTime;
            }
        }

        // Update the last end time for the student on the exam day
        $lastEndTimeMap[$studentCode][$examDate] = $examTime;
    }
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
        heuristicAlgorithm($conflicts);

        // Display conflicts or no conflicts message
        if (!empty($conflicts)) {
            $formMessages['warning'] = 'Conflicts identified.';
        } else {
            $formMessages['success'] = 'No conflicts identified.';
        }
    }
}
?>

<?php
if (isset($_GET['update_id'])) {
    $update_id = $_GET['update_id'];

    // Retrieve the student information for the given update_id
    $select_stmt = $conn->prepare('SELECT * FROM exam_venue WHERE venue_id = :id');
    $select_stmt->bindParam(':id', $update_id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the form is submitted for updating
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and validate form data
        $updated_venue_name = htmlspecialchars($_POST['updated_venue_name']);
        $updated_venue_capacity = htmlspecialchars($_POST['updated_venue_capacity']);
        // Update the student details in the database
        $update_stmt = $conn->prepare('UPDATE exam_venue SET venue_name = :venue_name, venue_capacity = :venue_capacity WHERE venue_id = :id');
        $update_stmt->bindParam(':venue_name', $updated_venue_name);
        $update_stmt->bindParam(':venue_capacity', $updated_venue_capacity);
        $update_stmt->bindParam(':id', $update_id);

        if ($update_stmt->execute()) {
            $formMessages['success'] = 'Exam venue details updated successfully.';
            header('Location: read_exam_venue.php'); // Redirect after successful update
            exit();
        } else {
            $formMessages['error'] = 'An error occurred while processing the request.';
        }
    }
}
?>

<!-- Display the form for updating student details -->

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
