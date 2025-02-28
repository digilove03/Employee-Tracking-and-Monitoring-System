<?php 
session_start();
include('db_connect.php');
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

include ('include/scripts.php');
include ('include/header.php');

$query_total = "SELECT COUNT(*) AS total_employees FROM employee";
$result_total = mysqli_query($conn, $query_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_employees = $row_total['total_employees'];

// Query to count employees by status
$sql_status_count = "SELECT status, COUNT(*) AS count FROM employee GROUP BY status";
$result_status_count = mysqli_query($conn, $sql_status_count);

$status_counts = [];
while ($row = mysqli_fetch_assoc($result_status_count)) {
    $status_counts[$row['status']] = $row['count'];
}

// Query to fetch employee details
$sql_employees = "SELECT first_name, middle_name, last_name, suffix, status, position 
                  FROM employee";
$result_employees = mysqli_query($conn, $sql_employees);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>EMPLOYEE MONITORING AND TRACKING SYSTEM</title>
    <style>
    /* Ensure the table and charts are aligned properly */
    .table-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        width: 100%;
    }

    .table-wrapper {
        width: 50%;
    }

    .charts-wrapper {
        width: 48%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 18px;
        text-align: left;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    th {
        background-color: #f4f4f4;
        text-align: center;
    }
</style>
</head>
<body class="sb-nav-fixed">

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include 'include/navbar.php'; ?>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h4 class="mt-4">Dashboard</h4>
                    <br>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card total_employee text-white mb-4">
                                <div class="card-body text-center"><h2>TOTAL EMPLOYEES</h2></div>
                                <div class="card-footer text-center">
                                    <h1><b><?php echo $total_employees; ?></b></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">
                            <div class="card text-white mb-4 status_card">
                                <div class="card-body text-center"><h1>Status</h1></div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="card text-white mb-4">
                                                <div class="card-body text-center"><h4>WORKING</h4></div>
                                                <div class="card-footer text-center"><h2><b><?php echo isset($status_counts['Working']) ? $status_counts['Working'] : 0; ?></b></h2></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card text-white mb-4">
                                                <div class="card-body text-center"><h4>ON LEAVE</h4></div>
                                                <div class="card-footer text-center"><h2><b><?php echo isset($status_counts['On Leave']) ? $status_counts['On Leave'] : 0; ?></b></h2></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card text-white mb-4">
                                                <div class="card-body text-center"><h4>ON BREAK</h4></div>
                                                <div class="card-footer text-center"><h2><b><?php echo isset($status_counts['On Break']) ? $status_counts['On Break'] : 0; ?></b></h2></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card text-white mb-4">
                                                <div class="card-body text-center"><h4>AVAILABLE</h4></div>
                                                <div class="card-footer text-center"><h2><b><?php echo isset($status_counts['Available']) ? $status_counts['Available'] : 0; ?></b></h2></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        </div>

                    </div> 

                    <div class="row">
                        
                        <!-- Employee Status Table -->
                   <div class="row">
                    <div class="col-xl-8 mx-auto">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Employee Status Table
                            </div>
                            <div class="card-body">
                                <div class="table-container">
                                    <div class="table-wrapper">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Position</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                while ($employee = mysqli_fetch_assoc($result_employees)) {
                                                    // Concatenate name
                                                    $full_name = $employee['first_name'] . ' ' . $employee['middle_name'] . ' ' . $employee['last_name'] . ' ' . $employee['suffix'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $full_name; ?></td>
                                                    <td><?php echo $employee['status']; ?></td>
                                                    <td><?php echo $employee['position']; ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Area Chart Example
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Bar Chart Example
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div> 

                </div>
            </main> 

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; DASMO 2025</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div> 
    </div> 

</body>
</html>
