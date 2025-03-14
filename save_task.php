<?php
// Start output buffering to capture any stray output.
ob_start();

session_start();
include('db_connect.php');
include('log_employee_status.php'); // Include the logging function

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

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Insert new task
    $stmt = $conn->prepare("INSERT INTO tasks (employee_id, service, location, role, deadline) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    if (!$stmt->bind_param("issss", $employee_id, $service, $location, $role, $deadline) || !$stmt->execute()) {
        throw new Exception("Database Error: " . $stmt->error);
    }
    $stmt->close();

    // Update the employee's status to "Working"
    $updateStmt = $conn->prepare("UPDATE employee SET status = 'Working' WHERE id = ?");
    if (!$updateStmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $updateStmt->bind_param("i", $employee_id);
    $updateStmt->execute();
    $updateStmt->close();

    // Log the employee status change
    $logResult = logEmployeeStatus($conn, $employee_id, 'Working');
    if (strpos($logResult, "Error") !== false) {
        throw new Exception($logResult);
    }

    // Commit transaction
    mysqli_commit($conn);

    $response["status"] = "success";
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);
    $response["message"] = $e->getMessage();
}

$conn->close();

// Clear buffer and send JSON response.
ob_end_clean();
echo json_encode($response);
ob_end_flush();
?>
