<?php
include 'dbcon.php'; 
include 'header.php';     
include 'js_datatable.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    try {
        // Get the time availability from the user input
        $exam_day = $_POST['exam_day'];
        $exam_date = $_POST['exam_date'];
        $exam_time = $_POST['exam_time'];

        // Prepare the SQL statement for inserting time availability
        $sql = "INSERT INTO time_availability (exam_day, exam_date, exam_time) VALUES (:exam_day, :exam_date, :exam_time)";

        // Use PDO to prepare the statement and execute it
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':exam_day', $exam_day);
        $stmt->bindParam(':exam_date', $exam_date);
        $stmt->bindParam(':exam_time', $exam_time);
        $stmt->execute();

        $message = "Time availability inserted successfully!";
        $messageClass = "alert-success";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $messageClass = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Time Availability</title>
    <script>
        // Function to update the day field based on the selected date
        function updateDayField() {
            // Get the selected date from the date input
            var selectedDate = document.getElementById('exam_date').value;

            // Create a Date object from the selected date
            var dateObj = new Date(selectedDate);

            // Get the day of the week (0-6, where 0 is Sunday and 6 is Saturday)
            var dayOfWeek = dateObj.getDay();

            // Define an array of days
            var daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

            // Update the day field with the corresponding day
            document.getElementById('exam_day').value = daysOfWeek[dayOfWeek];
        }
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <!-- main page -->
        <main class="col-md-9 px-md-4" style="background-color: rgba(0,0,255,.2); width:30%; margin-left:30%; padding:2%;border-radius:5%">
            <h2 class="text-center mb-4">INSERT AVAILABLE SLOT</h2>

            <form method="post">
                <?php
                if (isset($message)) {
                    echo "<p class='$messageClass' style='text-align:center; background-color:yellow'>$message</p>";
                }
                ?>
                <label for="exam_date">Exam Date:</label>
                <input type="date" name="exam_date" id="exam_date" required onchange="updateDayField()">

                <label for="exam_day">Exam Day:</label>
                <input type="text" name="exam_day" id="exam_day" readonly>

                <label for="exam_time">Exam Time:</label>
                <input type="time" name="exam_time" id="time_slot" required>

                <input type="submit" name="submit" value="Insert">
            </form>
        </main>
    </div>
</div>
<?php require 'footer.php' ?>
</body>
</html>
