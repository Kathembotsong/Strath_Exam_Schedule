<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Time Slot</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function updateDay() {
            var examDate = new Date(document.getElementById("exam_date").value);
            var days = ['Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var day = days[examDate.getDay()];
            document.getElementById("exam_day").value = day;
        }

        function populateFields(select) {
            var selectedSubjectName = select.value;
            var groupInput = document.getElementById("selected_groups");
            var lectNameInput = document.getElementById("lect_name");

            var subjectData = <?php echo json_encode($subjects); ?>;
            var subjectInfo = subjectData[selectedSubjectName];

            if (subjectInfo) {
                var groups = subjectInfo.groups;
                var lectName = subjectInfo.lect_name;

                groupInput.innerHTML = '';
                for (var i = 0; i < groups.length; i++) {
                    var option = document.createElement("option");
                    option.text = groups[i];
                    option.value = groups[i];
                    groupInput.add(option);
                }

                lectNameInput.value = lectName;
            } else {
                // Handle the case where the selected subject name is not found
                groupInput.innerHTML = '';
                lectNameInput.value = '';
                alert("Selected subject_name not found in the database.");
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Add Time Slot</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="subject_name">Select Subject Name:</label>
                <select class="form-control" name="subject_name" id="subject_name" required onchange="populateFields(this)">
                    <?php
                    foreach ($subjects as $subjectName => $subjectInfo) {
                        echo '<option value="' . $subjectName . '">' . $subjectName . '</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="exam_date">Select Exam Date:</label>
                <input type="date" class="form-control" name="exam_date" id="exam_date" onchange="updateDay()" required>
            </div>
            
            <div class="form-group">
                <label for="exam_day">Exam Day:</label>
                <input type="text" class="form-control" name="exam_day" id="exam_day" readonly>
            </div>
            
            <div class="form-group">
                <label for="exam_time">Set Exam Time:</label>
                <input type="time" class="form-control" name="exam_time" id="exam_time" required>
            </div>

            <div class="form-group">
                <label for="lect_name">Chief Invigilator:</label>
                <input type="text" class="form-control" name="lect_name" id="lect_name">
            </div>

            <div class="form-group">
                <label>Select Groups:</label>
                <select class="form-control" name="selected_groups[]" id="selected_groups"></select>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Add Time Slot</button>
        </form>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
