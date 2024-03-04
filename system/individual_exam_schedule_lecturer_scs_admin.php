<?php
include 'dbcon.php';
include 'header.php';
include 'js_datatable.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include "scs_facadmin_sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left: 10%; width: 80%;">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #007bff; color: white; border-radius:5%;">
                        <h1 class="text-center" style="margin-top: 20px;">EXAM SCHEDULE AS LECTURER</h1>
                    </div>
                    <div class="panel-body" style="padding: 20px;">
                        <?php
                        if (isset($_POST['check_timetable']) && isset($_POST['lecturer_name'])) {
                            $lecturer_name = $_POST['lecturer_name'];
                            // Function to fetch and display the exam timetable for a specific Lecturer
                            function getLecturerTimetable($conn, $lecturer_name) {
                                // Prepare the SQL query to retrieve exams associated with the lecturer's name
                                $sql = "SELECT * FROM merged_data WHERE timeslot_lect_name = :lecturer_name order by exam_date";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':lecturer_name', $lecturer_name, PDO::PARAM_STR);
                                $stmt->execute();
                                $timetable = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Initialize an array to keep track of displayed rows
                                $displayedRows = [];

                                if (count($timetable) > 0) {
                                    echo "<h2 style='color:red;'>Exam Timetable for lecturer: $lecturer_name</h2>";
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
                                    echo '<form method="post" action="individual_schedule_lecturer_pdf.php">
                                            <input type="hidden" name="lecturer_name" value="' . $lecturer_name . '">
                                            <button type="submit" name="download_pdf" class="btn btn-success">Download PDF</button>
                                          </form>';
                                } else {
                                    echo "No exams found for the invigilator: $lecturer_name";
                                }
                            }

                            // Call the function to display the exam timetable
                            getLecturerTimetable($conn, $lecturer_name);
                        } else {
                            // Display form to enter lecturer name
                            ?>
                            <form method="post">
                                <div class="form-group">
                                    <label for="lecturer_name">Enter Invigilator Name:</label>
                                    <input type="text" class="form-control" name="lecturer_name" id="lecturer_name" placeholder="Enter the lecturer name">
                                </div>
                                <button type="submit" name="check_timetable" class="btn btn-primary">View & Download</button>
                                <a href="#" style="text-decoration:none; margin-left: 10px;" class="btn btn-danger">
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
