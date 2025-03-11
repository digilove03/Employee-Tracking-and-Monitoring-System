<?php 
session_start();
include('db_connect.php');
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

include('include/scripts.php');
include('include/header.php');

// Get total employees
$query_total = "SELECT COUNT(*) AS total_employees FROM employee";
$result_total = mysqli_query($conn, $query_total);
$total_employees = $result_total ? mysqli_fetch_assoc($result_total)['total_employees'] : 0;

// Get employee status counts
$sql_status_count = "SELECT status, COUNT(*) AS count FROM employee GROUP BY status";
$result_status_count = mysqli_query($conn, $sql_status_count);
$status_counts = [];
while ($row = mysqli_fetch_assoc($result_status_count)) {
    $status_counts[$row['status']] = $row['count'];
}

// Get employee details
$sql_employees = "SELECT first_name, middle_name, last_name, suffix, status, position FROM employee";
$result_employees = mysqli_query($conn, $sql_employees);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Employee Monitoring & Tracking</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .dashboard-container { display: flex; flex-wrap: wrap; gap: 15px; justify-content: space-between; }
        .card { flex: 1; padding: 10px; border-radius: 8px; text-align: center; background: #fff; box-shadow: 0px 3px 5px rgba(0,0,0,0.1); }
        h3, h5 { color: #1E3A8A; font-size: 14px; margin: 5px 0; }
        .card.total_employee h3 { font-size: 30px; }
        .status_card { background: #f8f9fa; }
        .table-container, .charts-container { flex: 1; max-width: 48%; }
        .table-container table { font-size: 12px; width: 100%; }
        .dataTables_wrapper { font-size: 12px; }
        .charts-container canvas { max-height: 180px; }
        .container-fluid { margin-top: 20px; }
        
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
                    <div class="dashboard-container">
                        <div class="card total_employee" style="background: #1E3A8A; color: white;">
                            <h3 style= "color:white;"><?php echo $total_employees; ?></h3>
                            <h5 style = "color: white;">TOTAL EMPLOYEES</h5>
                        </div>
                        <?php 
                        $statuses = ['Working', 'On Leave', 'On Break', 'Available'];
                        $colors = ['#2563EB', '#3B82F6', '#60A5FA', '#93C5FD'];
                        foreach ($statuses as $index => $status) { ?>
                            <div class="card status_card" style="background: <?php echo $colors[$index]; ?>; color: white;">
                                <h5 style="color: black;"> <?php echo strtoupper($status); ?> </h5>
                                <h2><b><?php echo $status_counts[$status] ?? 0; ?></b></h2>
                            </div>
                        <?php } ?>
                    </div>
                    <br>
                    <div class="dashboard-container">
                        <div class="table-container">
                            <div class="card">
                                <h5>EMPLOYEE STATUS</h5>
                                <table id="employeeTable" class="display">
                                    <thead>
                                        <tr><th>Name</th><th>Status</th><th>Position</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($employee = mysqli_fetch_assoc($result_employees)) { 
                                            $full_name = trim("{$employee['first_name']} {$employee['middle_name']} {$employee['last_name']} {$employee['suffix']}"); ?>
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
                        <div class="charts-container">
                            <div class="card">
                                <h5>SERVICE STATUS</h5>
                                <canvas id="myBarChart"></canvas>
                            </div>
                            <br>
                            <div class="card">
                                <h5>Employee Status Pie Chart</h5>
                                <canvas id="myPieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#employeeTable').DataTable();
    });

    var ctxBar = document.getElementById("myBarChart").getContext("2d");
    new Chart(ctxBar, {
        type: "bar",
        data: { 
            labels: ["Working", "On Leave", "On Break", "Available"], 
            datasets: [{ 
                label: "Status Count", 
                data: [<?php echo $status_counts['Working'] ?? 0; ?>, <?php echo $status_counts['On Leave'] ?? 0; ?>, <?php echo $status_counts['On Break'] ?? 0; ?>, <?php echo $status_counts['Available'] ?? 0; ?>], 
                backgroundColor: ['#2563EB', '#3B82F6', '#60A5FA', '#93C5FD']
            }] 
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    var ctxPie = document.getElementById("myPieChart").getContext("2d");
    new Chart(ctxPie, {
        type: "pie",
        data: { 
            labels: ["Working", "On Leave", "On Break", "Available"], 
            datasets: [{ 
                data: [<?php echo $status_counts['Working'] ?? 0; ?>, <?php echo $status_counts['On Leave'] ?? 0; ?>, <?php echo $status_counts['On Break'] ?? 0; ?>, <?php echo $status_counts['Available'] ?? 0; ?>], 
                backgroundColor: ['#2563EB', '#3B82F6', '#60A5FA', '#93C5FD']
            }] 
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
</body>
</html>

