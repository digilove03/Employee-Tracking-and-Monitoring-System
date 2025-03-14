<?php
include 'db_connect.php'; 
include 'log_employee_status.php'; // Include logging function

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];

    if (!empty($id) && !empty($status)) {
        // Begin transaction
        mysqli_begin_transaction($conn);

        try {
            // 1. Update status in the employee table
            $updateQuery = "UPDATE employee SET status = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt, "si", $status, $id);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Error updating status: " . mysqli_error($conn));
            }
            mysqli_stmt_close($stmt);

            // 2. Log the status change in employee_status_log
            $logResult = logEmployeeStatus($conn, $id, $status);
            if (strpos($logResult, "Error") !== false) {
                throw new Exception($logResult);
            }

            // Commit transaction
            mysqli_commit($conn);
            echo json_encode(["success" => true, "message" => "Status updated and logged successfully!"]);
        } catch (Exception $e) {
            // Rollback transaction on error
            mysqli_rollback($conn);
            echo json_encode(["error" => $e->getMessage()]);
        }

        mysqli_close($conn);
    } else {
        echo json_encode(["error" => "Invalid request!"]);
    }
}
?>
