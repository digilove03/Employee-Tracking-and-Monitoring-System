<?php
// Start output buffering to capture any stray output.
ob_start();

session_start();
include('db_connect.php');

// Ensure no output is sent before setting the header.
header('Content-Type: application/json');

$response = ["status" => "error", "message" => ""];

if (!isset($_SESSION['admin_id']) || empty($_POST['employee_id']) || empty($_POST['service']) || empty($_POST['location']) || empty($_POST['role']) || empty($_POST['deadline'])) {
    $response["message"] = "Invalid Request: Missing required fields.";
    ob_end_clean();
    echo json_encode($response);
    exit();
}

// Retrieve and sanitize inputs.
$employee_id  = (int) $_POST['employee_id'];
$service      = trim($_POST['service']);
$location     = trim($_POST['location']);
$role         = trim($_POST['role']);
$deadline     = trim($_POST['deadline']);

if (!$conn) {
    $response["message"] = "Database connection error.";
    ob_end_clean();
    echo json_encode($response);
    exit();
}

$stmt = $conn->prepare("INSERT INTO tasks (employee_id, service, location, role, deadline) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    $response["message"] = "Prepare failed: " . $conn->error;
    ob_end_clean();
    echo json_encode($response);
    exit();
}

// Bind parameters and execute query.
if (!$stmt->bind_param("issss", $employee_id, $service, $location, $role, $deadline) || !$stmt->execute()) {
    $response["message"] = "Database Error: " . $stmt->error;
} else {
    // Update the employee's status to "Working"
    if ($updateStmt = $conn->prepare("UPDATE employee SET status = 'Working' WHERE id = ?")) {
        $updateStmt->bind_param("i", $employee_id);
        $updateStmt->execute();
        $updateStmt->close();
    }
    
    $response["status"] = "success";
}

$stmt->close();
$conn->close();

// Clear buffer and send JSON response.
ob_end_clean();
echo json_encode($response);
ob_end_flush();
?>
