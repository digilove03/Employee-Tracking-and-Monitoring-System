<?php
include('db_connect.php');
session_start();

// Validate Input
$employee_id = isset($_POST['employee_id']) ? (int) $_POST['employee_id'] : null;
$service = isset($_POST['service']) ? mysqli_real_escape_string($conn, $_POST['service']) : null;
$date_range = isset($_POST['date_range']) ? $_POST['date_range'] : 'yearly';

$query = "SELECT * FROM tasks WHERE 1";

if (!empty($employee_id)) {
    $query .= " AND employee_id = ?";
}
if (!empty($service)) {
    $query .= " AND service = ?";
}

// Prepare the SQL query
$stmt = mysqli_prepare($conn, $query);
if (!empty($employee_id) && !empty($service)) {
    mysqli_stmt_bind_param($stmt, "is", $employee_id, $service);
} elseif (!empty($employee_id)) {
    mysqli_stmt_bind_param($stmt, "i", $employee_id);
} elseif (!empty($service)) {
    mysqli_stmt_bind_param($stmt, "s", $service);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Generate report data
$data = ["total_tasks" => 0, "completed_tasks" => 0, "ongoing_tasks" => 0, "cancelled_tasks" => 0, "report" => ""];

while ($row = mysqli_fetch_assoc($result)) {
    $data["total_tasks"]++;
    if ($row["service_status"] == "Completed") {
        $data["completed_tasks"]++;
    } elseif ($row["service_status"] == "Ongoing") {
        $data["ongoing_tasks"]++;
    } elseif ($row["service_status"] == "Cancelled") {
        $data["cancelled_tasks"]++;
    }
    $data["report"] .= "<tr><td>{$row['record_number']}</td><td>{$row['service']}</td><td>{$row['service_status']}</td></tr>";
}

echo json_encode($data);
?>
