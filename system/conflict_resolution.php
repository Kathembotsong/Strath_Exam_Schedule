<?php
// Include the database connection file
include 'dbcon.php';

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

            $stmt->execute();
        }

        $conn->commit();
        echo "Data inserted into conflict_resolution table successfully.";
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Call the rearrangeData function
    $rearrangedData = rearrangeData($conn);

    // Call the insertIntoConflictResolution function to insert data into the conflict_resolution table
    insertIntoConflictResolution($conn, $rearrangedData);
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
    </form>

</body>

</html>
