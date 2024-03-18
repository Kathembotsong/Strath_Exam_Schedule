
<?php
include 'header.php'; 
include 'dbcon.php';
include 'js_datatable.php';
?>

<div class="container-fluid">
    <div class="row">
        <main class="col-md-9" style="margin-left:13%;">
            <div class="card">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #007bff; color: white; border-radius:5%;">
                        <h1 class="text-center" style="margin-top: 20px;">MY TIMETABLE</h1>
                    </div>
                    <div class="panel-body" style="padding: 20px;">
                        <?php
                        if (isset($_POST['check_timetable']) && isset($_POST['student_code'])) {
                            $student_code = $_POST['student_code'];
                            // Function to fetch and display the exam timetable for a specific student
                            function getStudentTimetable($conn, $student_code) {
                                // Prepare the SQL query to retrieve exams associated with the student's code
                                $sql = "SELECT * FROM merged_data WHERE student_code = :student_code order by exam_date";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':student_code', $student_code, PDO::PARAM_STR);
                                $stmt->execute();
                                $timetable = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Initialize an array to keep track of displayed rows
                                $displayedRows = [];

                                if (count($timetable) > 0) {
                                    echo "<h2 style='color:red;'>Exam Timetable for student: $student_code</h2>";
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
                                        // Generate a unique key based on the data fields you want to consider
                                        $key = $record['exam_day'] . '|' . $record['exam_date'] . '|' . $record['exam_time'];

                                        // Check if the row has already been displayed
                                        if (!isset($displayedRows[$key])) {
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

                                            // Mark the row as displayed
                                            $displayedRows[$key] = true;
                                        }
                                    }

                                    echo "</table>";

                                    // Add a button for downloading the PDF
                                    echo '<form method="post" action="individual_schedule_student_pdf.php">
                                            <input type="hidden" name="student_code" value="' . $student_code . '">
                                            <button type="submit" name="download_pdf" class="btn btn-success">Download PDF</button>
                                            <a href="../authentifications/login.php" style="text-decoration:none; margin-left: 10px;" class="btn btn-danger">
                                    <span class="fas fa-times"></span>
                                </a>
                                          </form>';
                                } else {
                                    echo "No exams found for the student: $student_code";
                                }
                            }

                            // Call the function to display the exam timetable
                            getStudentTimetable($conn, $student_code);
                        } else {
                            // Display form to enter student code
                            ?>
                            <form method="post">
                                <div class="form-group">
                                    <label for="student_code">Enter Student Code:</label>
                                    <input type="text" class="form-control" name="student_code" id="student_code" placeholder="Enter the student code">
                                </div>
                                <button type="submit" name="check_timetable" class="btn btn-primary">View & Download</button>
                                <a href="student_dashboard.php" style="text-decoration:none; margin-left: 10px;" class="btn btn-danger">
                                    <span class="fas fa-times"></span>
                                </a>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>
