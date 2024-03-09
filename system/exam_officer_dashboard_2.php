<?php
include 'header.php';
include 'dbcon.php';

try {
    // Fetch distinct student codes for BBT groups with enrollment status as "special"
    $sqlBBT = "SELECT group_name, COUNT(DISTINCT student_code) AS num_students FROM enrollments_bbt WHERE enrol_status = 'special' GROUP BY group_name";
    $stmtBBT = $conn->query($sqlBBT);
    $dataBBT = $stmtBBT->fetchAll(PDO::FETCH_ASSOC);

    // Fetch distinct student codes for BCOM groups with enrollment status as "special"
    $sqlBCOM = "SELECT group_name, COUNT(DISTINCT student_code) AS num_students FROM enrollments_bcom WHERE enrol_status = 'special' GROUP BY group_name";
    $stmtBCOM = $conn->query($sqlBCOM);
    $dataBCOM = $stmtBCOM->fetchAll(PDO::FETCH_ASSOC);

    // Fetch distinct student codes for SCS groups with enrollment status as "special"
    $sqlSCS = "SELECT group_name, COUNT(DISTINCT student_code) AS num_students FROM enrollments_scs WHERE enrol_status = 'special' GROUP BY group_name";
    $stmtSCS = $conn->query($sqlSCS);
    $dataSCS = $stmtSCS->fetchAll(PDO::FETCH_ASSOC);

    // Fetch distinct student codes for SLS groups with enrollment status as "special"
    $sqlSLS = "SELECT group_name, COUNT(DISTINCT student_code) AS num_students FROM enrollments_sls WHERE enrol_status = 'special' GROUP BY group_name";
    $stmtSLS = $conn->query($sqlSLS);
    $dataSLS = $stmtSLS->fetchAll(PDO::FETCH_ASSOC);

    // Fetch distinct student codes for TOURISM groups with enrollment status as "special"
    $sqlTOURISM = "SELECT group_name, COUNT(DISTINCT student_code) AS num_students FROM enrollments_tourism WHERE enrol_status = 'special' GROUP BY group_name";
    $stmtTOURISM = $conn->query($sqlTOURISM);
    $dataTOURISM = $stmtTOURISM->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for BBT
    $labelsBBT = [];
    $countsBBT = [];

    foreach ($dataBBT as $rowBBT) {
        $labelsBBT[] = $rowBBT['group_name'];
        $countsBBT[] = $rowBBT['num_students'];
    }

    // Prepare data for BCOM
    $labelsBCOM = [];
    $countsBCOM = [];

    foreach ($dataBCOM as $rowBCOM) {
        $labelsBCOM[] = $rowBCOM['group_name'];
        $countsBCOM[] = $rowBCOM['num_students'];
    }


    // Prepare data for SCS
    $labelsSCS = [];
    $countsSCS = [];

    foreach ($dataSCS as $rowSCS) {
        $labelsSCS[] = $rowSCS['group_name'];
        $countsSCS[] = $rowSCS['num_students'];
    }

    // Prepare data for SLS
    $labelsSLS = [];
    $countsSLS = [];

    foreach ($dataSLS as $rowSLS) {
        $labelsSLS[] = $rowSLS['group_name'];
        $countsSLS[] = $rowSLS['num_students'];
    }

    // Prepare data for TOURISM
    $labelsTOURISM = [];
    $countsTOURISM = [];

    foreach ($dataTOURISM as $rowTOURISM) {
        $labelsTOURISM[] = $rowTOURISM['group_name'];
        $countsTOURISM[] = $rowTOURISM['num_students'];
    }

    // Calculate total number of enrolled students
    $totalStudentsBBT = array_sum($countsBBT);
    $totalStudentsBCOM = array_sum($countsBCOM);
    $totalStudentsSCS = array_sum($countsSCS);
    $totalStudentsSLS = array_sum($countsSLS);
    $totalStudentsTOURISM = array_sum($countsTOURISM);

    // Calculate the sum of all students in different departments
    $sumBBTGroups = array_sum($countsBBT);
    $sumBCOMGroups = array_sum($countsBCOM);
    $sumSCSGroups = array_sum($countsSCS);
    $sumSLSGroups = array_sum($countsSLS);
    $sumTOURISMGroups = array_sum($countsTOURISM);

    // Convert data to JSON format for Chart.js
    $labelsBBT_json = json_encode($labelsBBT);
    $countsBBT_json = json_encode($countsBBT);

    $labelsBCOM_json = json_encode($labelsBCOM);
    $countsBCOM_json = json_encode($countsBCOM);

    $labelsSCS_json = json_encode($labelsSCS);
    $countsSCS_json = json_encode($countsSCS);

    $labelsSLS_json = json_encode($labelsSLS);
    $countsSLS_json = json_encode($countsSLS);

    $labelsTOURISM_json = json_encode($labelsTOURISM);
    $countsTOURISM_json = json_encode($countsTOURISM);
} catch (PDOException $e) {
    // Handle database connection or query errors
    echo "Error: " . $e->getMessage();
}
?>


<div class="container-fluid">
    <div class="row">  
        <?php include "exam_officer_sidebar.php";?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="wrapper">    
                <div class="row" style="padding:5px;">
                    <h1 style="text-align: center; background-color:rgba(255,12,105,.2)">Number of Students seating for exams</h1>
                    <div class="card col-6">                            
                        <canvas id="bbtEnrollmentChart" height="250"></canvas>
                    </div> 
                    <div class="card col-6">
                        <canvas id="bcomEnrollmentChart" height="250"></canvas>
                    </div>
                    <div class="card col-6">                            
                        <canvas id="scsEnrollmentChart" height="250"></canvas>
                    </div> 
                    <div class="card col-6">
                        <canvas id="slsEnrollmentChart" height="250"></canvas>
                    </div>
                    <div class="card col-6">
                        <canvas id="tourismEnrollmentChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Create Chart.js area graph for Number of Students Enrolled from BBT and BCOM
    var ctx1 = document.getElementById('bbtEnrollmentChart').getContext('2d');
    var ctx2 = document.getElementById('bcomEnrollmentChart').getContext('2d');
    var ctx3 = document.getElementById('scsEnrollmentChart').getContext('2d');
    var ctx4 = document.getElementById('slsEnrollmentChart').getContext('2d');
    var ctx5 = document.getElementById('tourismEnrollmentChart').getContext('2d');

    var bbtEnrollmentChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: <?php echo $labelsBBT_json; ?>,
            datasets: [{
                label: 'Number of Students (BBT)',
                data: <?php echo $countsBBT_json; ?>,
                fill: false,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Group Name'
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
            title: {
                display: true,
                text: 'Number of Students Enrolled from BBT (Total: <?php echo $totalStudentsBBT; ?>)'
            }
        }
    });

    var bcomEnrollmentChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: <?php echo $labelsBCOM_json; ?>,
            datasets: [{
                label: 'Number of Students (BCOM)',
                data: <?php echo $countsBCOM_json; ?>,
                fill: false,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Group Name'
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
            title: {
                display: true,
                text: 'Number of Students Enrolled from BCOM (Total: <?php echo $totalStudentsBCOM; ?>)'
            }
        }
    });

    var scsEnrollmentChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: <?php echo $labelsSCS_json; ?>,
            datasets: [{
                label: 'Number of Students (SCS)',
                data: <?php echo $countsSCS_json; ?>,
                fill: false,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Group Name'
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
            title: {
                display: true,
                text: 'Number of Students Enrolled from SCS (Total: <?php echo $totalStudentsSCS; ?>)'
            }
        }
    });

    var slsEnrollmentChart = new Chart(ctx4, {
        type: 'line',
        data: {
            labels: <?php echo $labelsSLS_json; ?>,
            datasets: [{
                label: 'Number of Students (SLS)',
                data: <?php echo $countsSLS_json; ?>,
                fill: false,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Group Name'
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
            title: {
                display: true,
                text: 'Number of Students Enrolled from SLS (Total: <?php echo $totalStudentsSLS; ?>)'
            }
        }
    });

    var tourismEnrollmentChart = new Chart(ctx5, {
        type: 'line',
        data: {
            labels: <?php echo $labelsTOURISM_json; ?>,
            datasets: [{
                label: 'Number of Students (Tourism)',
                data: <?php echo $countsTOURISM_json; ?>,
                fill: false,
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Group Name'
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
            title: {
                display: true,
                text: 'Number of Students Enrolled in Tourism (Total: <?php echo $totalStudentsTOURISM; ?>)'
            }
        }
    });
</script>
