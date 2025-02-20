<?php
// Start output buffering to capture any stray output.
ob_start();

session_start();
include('db_connect.php');

// Ensure no output is sent before setting the header.
header('Content-Type: application/json');

$response = array("status" => "error", "message" => "");

// Check if user is logged in and required POST fields are set.
if (!isset($_SESSION['admin_id']) || !isset($_POST['employee_id'])) {
    $response["message"] = "Invalid Request";
    ob_clean();
    echo json_encode($response);
    exit();
}

// Retrieve and sanitize inputs.
$employee_id  = (int) $_POST['employee_id'];
$service      = $_POST['service'];
$location     = $_POST['location'];
$role         = $_POST['role'];
$deadline     = $_POST['deadline'];
$time_started = $_POST['time_started'];

// Generate a unique record number (adjust as needed to meet your 16-character limit).
// uniqid() returns a 13-character unique string by default; you can append or trim as needed.
$record_number = substr(uniqid(), 0, 16);

// Prepare the SQL statement with the record_number included.
$stmt = $conn->prepare("INSERT INTO tasks (record_number, employee_id, service, location, role, deadline, time_started) VALUES (?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    $response["message"] = "Prepare failed: " . $conn->error;
    ob_clean();
    echo json_encode($response);
    exit();
}

// Bind parameters. Here record_number is a string, employee_id is integer, and the rest are strings.
$stmt->bind_param("sisssss", $record_number, $employee_id, $service, $location, $role, $deadline, $time_started);

if ($stmt->execute()) {
    $response["status"] = "success";
} else {
    $response["message"] = "Database Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Clear any accidental output and send JSON.
ob_clean();
echo json_encode($response);
ob_end_flush();
?>
