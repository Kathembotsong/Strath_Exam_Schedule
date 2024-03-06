<?php
include 'header.php';  
include 'dbcon.php';	     
include 'js_datatable.php';
?> 

<div class="container-fluid">
    <div class="row">  
        <?php include "bcom_facadmin_sidebar.php";?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="wrapper">    
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 style="text-align: center; background-color:rgba(205,102,105)">Number of BCOM Students Taking Exam on Specific Dates</h1>
                            </div>
                            <div class="card">
                                <div class="table-responsive">
                                    <canvas id="dateChart" width="400" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="raw">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 style="text-align: center; background-color:rgba(5,102,205,.2)">Number of BCOM Students in Each Venue at Specific Exam Time</h1>
                            </div>
                            <div class="card">
                                <div class="table-responsive">
                                    <canvas id="venueChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    <?php
    // Fetch data for Number of Students Taking Exam on Specific Dates
    $sql = "SELECT exam_date, COUNT(DISTINCT student_code) AS num_students FROM merged_data WHERE timeslot_group_name LIKE '%BCOM%' GROUP BY exam_date ORDER BY exam_date";
    $stmt = $conn->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for Chart.js
    $labels = [];
    $counts = [];
    $colors = []; // Array to store random colors

    foreach ($data as $row) {
        $labels[] = $row['exam_date'];
        $counts[] = $row['num_students'];
        // Generate random colors
        $colors[] = 'rgba('.rand(0, 255).', '.rand(0, 255).', '.rand(0, 255).', 0.2)';
    }

    // Convert data to JSON format for Chart.js
    $labels_json = json_encode($labels);
    $counts_json = json_encode($counts);
    ?>

    // Create Chart.js area chart for Number of Students Taking Exam on Specific Dates
    var ctxDate = document.getElementById('dateChart').getContext('2d');
    var dateChart = new Chart(ctxDate, {
        type: 'line',
        data: {
            labels: <?php echo $labels_json; ?>,
            datasets: [{
                label: 'Number of Students',
                data: <?php echo $counts_json; ?>,
                fill: true,
                backgroundColor: <?php echo json_encode($colors); ?>,
                borderColor: 'rgba(205,102,105,1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom'
            },
            title: {
                display: true,
                text: 'Number of BBIT Students Taking Exam on Specific Dates'
            }
        }
    });

    <?php
    // Fetch data for Number of Students in Each Venue at Specific Exam Time
    $sqlVenueTime = "SELECT exam_date, exam_time, venue_name, COUNT(DISTINCT student_code) AS num_students FROM merged_data WHERE timeslot_group_name LIKE '%BCOM%' GROUP BY exam_date, exam_time, venue_name ORDER BY exam_date, exam_time";
    $stmtVenueTime = $conn->query($sqlVenueTime);
    $dataVenueTime = $stmtVenueTime->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for Chart.js
    $labelsVenueTime = [];
    $countsVenueTime = [];
    $colorsVenueTime = []; // Array to store random colors

    foreach ($dataVenueTime as $rowVenueTime) {
        $labelsVenueTime[] = $rowVenueTime['exam_date'] . ' - ' . $rowVenueTime['exam_time'] . ' - ' . $rowVenueTime['venue_name'];
        $countsVenueTime[] = $rowVenueTime['num_students'];
        // Generate random colors
        $colorsVenueTime[] = 'rgba('.rand(0, 255).', '.rand(0, 255).', '.rand(0, 255).', 0.6)';
    }

    // Convert data to JSON format for Chart.js
    $labelsVenueTime_json = json_encode($labelsVenueTime);
    $countsVenueTime_json = json_encode($countsVenueTime);
    ?>

    // Create Chart.js bar chart for Number of Students in Each Venue at Specific Exam Time
    var ctxVenueTime = document.getElementById('venueChart').getContext('2d');
    var venueChart = new Chart(ctxVenueTime, {
        type: 'bar',
        data: {
            labels: <?php echo $labelsVenueTime_json; ?>,
            datasets: [{
                label: 'Number of Students',
                data: <?php echo $countsVenueTime_json; ?>,
                backgroundColor: <?php echo json_encode($colorsVenueTime); ?>,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Exam Time - Venue'
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Number of Students'
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Number of Students in Each Venue for Each Exam Time'
            }
        }
    });
</script>

<?php require 'footer.php' ?>
