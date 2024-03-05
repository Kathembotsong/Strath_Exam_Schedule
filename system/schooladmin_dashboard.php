<?php 
    include 'header.php';
    include 'dbcon.php'; 
    include 'js_datatable.php';
 ?>
<div class="container-fluid">
    <div class="row">  
        <?php include "schooladmin_sidebar.php";?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="wrapper">    
                <div class="row">            
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 style="text-align: center;">Number of Students Taking Exam on Specific Dates</h1>
                            </div>
                            <div class="card">
                                <div class="table-responsive">
                                    <canvas id="dateChart" width="400" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 style="text-align: center;">Number of Students in Each Venue on Specific Dates</h1>
                            </div>
                            <div class="card">
                                <div class="table-responsive">
                                    <canvas id="venueChart" width="400" height="400"></canvas>
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
    $sql = "SELECT exam_date, COUNT(DISTINCT student_code) AS num_students FROM merged_data GROUP BY exam_date ORDER BY exam_date";
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
        $colors[] = 'rgba('.rand(0, 255).', '.rand(0, 255).', '.rand(0, 255).', 0.6)';
    }

    // Convert data to JSON format for Chart.js
    $labels_json = json_encode($labels);
    $counts_json = json_encode($counts);
    ?>

    // Create Chart.js pie chart for Number of Students Taking Exam on Specific Dates
    var ctxDate = document.getElementById('dateChart').getContext('2d');
    var dateChart = new Chart(ctxDate, {
        type: 'pie',
        data: {
            labels: <?php echo $labels_json; ?>,
            datasets: [{
                data: <?php echo $counts_json; ?>,
                backgroundColor: <?php echo json_encode($colors); ?>,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'right'
            },
            title: {
                display: true,
                text: 'Number of Students Taking Exam on Specific Dates'
            }
        }
    });

    <?php
    // Fetch data for Number of Students in Each Venue on Specific Dates
    $sqlVenue = "SELECT exam_date, venue_name, COUNT(DISTINCT student_code) AS num_students FROM merged_data GROUP BY exam_date, venue_name ORDER BY exam_date";
    $stmtVenue = $conn->query($sqlVenue);
    $dataVenue = $stmtVenue->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for Chart.js
    $labelsVenue = [];
    $countsVenue = [];
    $colorsVenue = []; // Array to store random colors

    foreach ($dataVenue as $rowVenue) {
        $labelsVenue[] = $rowVenue['venue_name'] . ' (' . $rowVenue['exam_date'] . ')';
        $countsVenue[] = $rowVenue['num_students'];
        // Generate random colors
        $colorsVenue[] = 'rgba('.rand(0, 255).', '.rand(0, 255).', '.rand(0, 255).', 0.6)';
    }

    // Convert data to JSON format for Chart.js
    $labelsVenue_json = json_encode($labelsVenue);
    $countsVenue_json = json_encode($countsVenue);
    ?>

    // Create Chart.js bar chart for Number of Students in Each Venue on Specific Dates
    var ctxVenue = document.getElementById('venueChart').getContext('2d');
    var venueChart = new Chart(ctxVenue, {
        type: 'bar',
        data: {
            labels: <?php echo $labelsVenue_json; ?>,
            datasets: [{
                label: 'Number of Students',
                data: <?php echo $countsVenue_json; ?>,
                backgroundColor: <?php echo json_encode($colorsVenue); ?>,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Venues and Dates'
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
                text: 'Number of Students in Each Venue on Specific Dates'
            }
        }
    });
</script>
