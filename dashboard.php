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

// Get service status counts
$sql_service_status_count = "SELECT service_status, COUNT(*) AS count FROM tasks GROUP BY service_status";
$result_service_status_count = mysqli_query($conn, $sql_service_status_count);
$service_status_counts = [];
while ($row = mysqli_fetch_assoc($result_service_status_count)) {
    $service_status_counts[$row['service_status']] = $row['count'];
}

$sql_employees = "SELECT id, first_name, middle_name, last_name, suffix, status, position FROM employee";
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
    
    /* Adjusted chart sizes */
    .charts-container { 
        display: flex; 
        flex-direction: column; 
        gap: 15px; 
        max-width: 48%; 
    }

    .charts-container canvas { 
        max-height: 200px; 
        width: 100%; 
    }

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
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Position</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($employee = mysqli_fetch_assoc($result_employees)) { 
                        $full_name = trim("{$employee['first_name']} {$employee['middle_name']} {$employee['last_name']} {$employee['suffix']}");
                    ?>
                        <tr>
                            <td><?php echo $full_name; ?></td>
                            <td>
                                <select class="status-dropdown" data-employee-id="<?php echo $employee['id']; ?>">
                                    <option value="Working" <?php echo ($employee['status'] == 'Working') ? 'selected' : ''; ?>>Working</option>
                                    <option value="On Break" <?php echo ($employee['status'] == 'On Break') ? 'selected' : ''; ?>>On Break</option>
                                    <option value="On Leave" <?php echo ($employee['status'] == 'On Leave') ? 'selected' : ''; ?>>On Leave</option>
                                    <option value="Available" <?php echo ($employee['status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                                </select>
                            </td>
                            <td><?php echo $employee['position']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

                        
                        <div class="charts-container">
                            <div class="card">
                                <h5>Service Status</h5>
                                <canvas id="myDonutChart"></canvas>
                            </div>
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
        $('#employeeTable').DataTable({
             stripeClasses: []
         });    
    });

    var ctxDonut = document.getElementById("myDonutChart").getContext("2d");
    new Chart(ctxDonut, {
        type: "doughnut",
        data: {
            labels: ["Ongoing", "Completed", "Cancelled"],
            datasets: [{
                data: [<?php echo $service_status_counts['Ongoing'] ?? 0; ?>, <?php echo $service_status_counts['Completed'] ?? 0; ?>, <?php echo $service_status_counts['Cancelled'] ?? 0; ?>],
                backgroundColor: ['#2563EB', '#3B82F6', '#93C5FD'],
                hoverBackgroundColor: ['#1E40AF', '#2563EB', '#60A5FA']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'right', // Set legend position to the right
                    labels: {
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
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



    $(".status-dropdown").change(function () {
        var employeeId = $(this).data("employee-id"); // Get employee ID
        var newStatus = $(this).val(); // Get selected status

        console.log("Employee ID:", employeeId);
        console.log("New Status:", newStatus);

        if (!employeeId) {
            alert("Error: Employee ID is missing.");
            return;
        }

        if (confirm("Are you sure you want to update the status?")) {
            $.ajax({
                url: "update_status.php",
                type: "POST",
                data: { id: employeeId, status: newStatus },
                success: function (response) {
                    console.log("Server Response:", response);
                    alert("Status updated succesfully!");
                    location.reload();
                },
                error: function () {
                    alert("Error updating status.");
                }
            });
        } else {
            location.reload();
        }
    });


</script>
</body>
</html>
