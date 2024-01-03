<?php
// Include the database connection file
include 'dbcon.php';

// Function to rearrange data based on conditions
function rearrangeData($con)
{
    $sql = "
    SELECT *
    FROM merged_data_bbt
    WHERE exam_date IN (
        SELECT exam_date
        FROM merged_data_bbt
        GROUP BY exam_date
        HAVING COUNT(DISTINCT exam_time) > 1
    )
    ORDER BY student_code, exam_date, exam_time;
    ";

    try {
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
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

    return $rearrangedData;
}

// Function to fetch data from the database
function fetchDataFromDatabase($con)
{
    // Modify this SQL query to fetch your data from the database
    $sql = "SELECT * FROM merged_data_bbt";

    try {
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null; // Handle the error as needed
    }
}

// Function to insert rearranged data into the conflict_resolution table
function insertIntoConflictResolution($con, $rearrangedData)
{
    try {
        $con->beginTransaction();

        foreach ($rearrangedData as $row) {
            $sql = "INSERT INTO conflict_resolution (student_code, exam_day, exam_date, exam_time, venue_name, timeslot_group_name, group_capacity, timeslot_subject_code, timeslot_subject_name, timeslot_lect_name, invigilator_name) VALUES (:student_code, :exam_day, :exam_date, :exam_time, :venue_name, :timeslot_group_name, :group_capacity, :timeslot_subject_code, :timeslot_subject_name, :timeslot_lect_name, :invigilator_name)";

            $stmt = $con->prepare($sql);

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
                // Data inserted successfully
            } else {
                echo "Error inserting data: " . $stmt->errorInfo()[2];
                $con->rollBack();
                return;
            }
        }

        $con->commit();
        echo "Data inserted into conflict_resolution table successfully.";
    } catch (PDOException $e) {
        $con->rollBack();
        echo "Error: " . $e->getMessage();
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["rearrange"])) {
        // Call the rearrangeData function
        $rearrangedData = rearrangeData($con);

        // Check if there is data to insert
        if (!empty($rearrangedData)) {
            // Insert data into the conflict_resolution table
            insertIntoConflictResolution($con, $rearrangedData);
        } else {
            echo "No data to insert.";
        }
    } elseif (isset($_POST["identifyConflicts"])) {
        // Call the identifyConflicts function
        $data = fetchDataFromDatabase($con);
        $conflicts = identifyConflicts($data);
        heuristicAlgorithm($conflicts);
        // Further actions for resolved conflicts
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Rearrangement</title>
</head>

<body>
    <h1>Data Rearrangement</h1>

    <form method="POST">
        <input type="submit" name="rearrange" value="Rearrange Data">
        <input type="submit" name "insertDataIntoConflictResolution" value="Insert Data into Conflict Resolution">
        <input type="submit" name="identifyConflicts" value="Identify Conflicts">
    </form>

</body>

</html>
