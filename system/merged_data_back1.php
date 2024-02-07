<?php
        include 'dbcon.php';
        include 'header.php';
        include 'js_datatable.php'; ?>
<body>
    <h1>Move Rows from exams_collision back to merged_data</h1>
    <?php include "sidebar.php"; ?>
    <div>
        <?php
         try {
            // Retrieve all rows from the exams_collision table
            $selectStmt = $conn->query("SELECT * FROM exams_collision");
            $rows = $selectStmt->fetchAll(PDO::FETCH_ASSOC);

            // Start a transaction
            $conn->beginTransaction();

            // Insert each row into the merged_data table
            foreach ($rows as $row) {
                $insertStmt = $conn->prepare("
                    INSERT INTO merged_data 
                    (student_code, exam_day, exam_date, exam_time, venue_name, timeslot_group_name, group_capacity, timeslot_subject_code, timeslot_subject_name, timeslot_lect_name, invigilator_name, id) 
                    VALUES 
                    (:student_code, :exam_day, :exam_date, :exam_time, :venue_name, :timeslot_group_name, :group_capacity, :timeslot_subject_code, :timeslot_subject_name, :timeslot_lect_name, :invigilator_name, :id)
                ");

                $insertStmt->execute([
                    ':student_code' => $row['student_code'],
                    ':exam_day' => $row['exam_day'],
                    ':exam_date' => $row['exam_date'],
                    ':exam_time' => $row['exam_time'],
                    ':venue_name' => $row['venue_name'],
                    ':timeslot_group_name' => $row['timeslot_group_name'],
                    ':group_capacity' => $row['group_capacity'],
                    ':timeslot_subject_code' => $row['timeslot_subject_code'],
                    ':timeslot_subject_name' => $row['timeslot_subject_name'],
                    ':timeslot_lect_name' => $row['timeslot_lect_name'],
                    ':invigilator_name' => $row['invigilator_name'],
                    ':id' => $row['id']
                ]);
            }

            // Optionally, delete rows from the exams_collision table
            $deleteStmt = $conn->exec("DELETE FROM exams_collision");

            // Commit the transaction
            $conn->commit();

            echo "<p>Rows moved successfully!</p>";
        } catch (PDOException $e) {
            // Rollback the transaction in case of an error
            $conn->rollBack();
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
</body>
</html>
