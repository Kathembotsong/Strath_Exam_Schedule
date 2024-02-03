<?php
include 'dbcon.php'; // Assuming dbcon.php includes your PDO connection

try {
    $conn->beginTransaction();

    $updateQuery = "
        UPDATE exams_collision e
        JOIN (
            SELECT id, exam_day, exam_date, exam_time
            FROM (
                SELECT e.id, e.exam_day, e.exam_date, e.exam_time, ROW_NUMBER() OVER (PARTITION BY e.exam_day, e.exam_date, e.exam_time ORDER BY e.id) as row_num
                FROM exams_collision e
                JOIN time_availability t ON e.exam_day = t.exam_day
                                        AND e.exam_date = t.exam_date
                                        AND e.exam_time = t.exam_time
            ) AS subquery
            WHERE subquery.row_num % 2 = 0
        ) AS t ON e.id = t.id
        SET 
            e.exam_day = t.exam_day,
            e.exam_date = t.exam_date,
            e.exam_time = t.exam_time;
    ";

    $conn->exec($updateQuery);

    $conn->commit();
    echo "Update successful!";
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
