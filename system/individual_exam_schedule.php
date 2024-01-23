<?php
include 'dbcon.php';
include 'header.php';
include 'js_datatable.php';

    // Function to fetch and display the exam timetable for a specific student
    function getStudentTimetable($conn, $studentCode) {
        $sql = "SELECT * FROM conflict_resolution WHERE student_code = :student_code";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':student_code', $studentCode, PDO::PARAM_INT);
        $stmt->execute();
        $timetable = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($timetable) > 0) {
            echo "<h2>Exam Timetable for Student Code: $studentCode</h2>";
            echo "<table border='1'>";
            echo "<tr>
            <th>Exam Day</th>
            <th>Exam Date</th>
            <th>Exam Time</th>
            <th>Subject Code</th>
            <th>Subject Name </th>
            <th>Group Name</th>
            <th>Group Capacity</th>
            <th>Exam Venue</th>
            <th>Chief Invigilator</th>
            <th>Assistant Invigilator</th>
            </tr>";

            foreach ($timetable as $record) {
                echo "<tr>";
                echo "<td>{$record['exam_day']}</td>";
                echo "<td>{$record['exam_date']}</td>";
                echo "<td>{$record['exam_time']}</td>";
                echo "<td>{$record['timeslot_subject_code']}</td>";
                echo "<td>{$record['timeslot_subject_name']}</td>";
                echo "<td>{$record['timeslot_group_name']}</td>";               
                echo "<td>{$record['group_capacity']}</td>";
                echo "<td>{$record['venue_name']}</td>";
                echo "<td>{$record['timeslot_lect_name']}</td>";
                echo "<td>{$record['invigilator_name']}</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No exams found for Student Code: $studentCode";
        }
    }

    // Check if the form is submitted
    if (isset($_POST['check_timetable']) && isset($_POST['student_code'])) {
        $studentCode = $_POST['student_code'];
        getStudentTimetable($conn, $studentCode);
    }
    ?>
<!-- Display the form for updating student details -->
<div class="container-fluid">
    <div class="row">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left:35%; width:35%">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 style="text-align: center;">MY EXAM SCHEDULE</h1>
                        </div>
                        <div class="panel-body">
                            <form method="post">
                            <label for="student_code">Enter Student Code:</label>
                            <input type="text" name="student_code" id="student_code">
                            <input type="submit" name="check_timetable" value="Check Timetable">
                                <a href="read_exam_venue.php" style="text-decoration:none;"><span class="fas fa-times btn btn-danger"></span></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>
