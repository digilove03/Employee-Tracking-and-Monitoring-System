<?php
include 'db_connect.php'; // Ensure database connection

function logEmployeeStatus($conn, $employee_id, $status) {
    if (empty($employee_id) || empty($status)) {
        return "Invalid input: Employee ID or status is empty.";
    }

    // Check if there's an active status that needs an end time
    $checkQuery = "SELECT id, start_time FROM employee_status_log 
                   WHERE employee_id = ? AND status_end IS NULL 
                   ORDER BY start_time DESC LIMIT 1";
    $checkStmt = mysqli_prepare($conn, $checkQuery);
    
    if (!$checkStmt) {
        return "Error preparing check query: " . mysqli_error($conn);
    }

    mysqli_stmt_bind_param($checkStmt, "i", $employee_id);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_store_result($checkStmt);

    if (mysqli_stmt_num_rows($checkStmt) > 0) {
        mysqli_stmt_bind_result($checkStmt, $logId, $startTime);
        mysqli_stmt_fetch($checkStmt);
        mysqli_stmt_close($checkStmt);

        // Update status_end and calculate duration using MySQL's NOW()
        $updateQuery = "UPDATE employee_status_log 
                        SET status_end = NOW(), duration = TIMEDIFF(NOW(), start_time) 
                        WHERE id = ?";
        $updateStmt = mysqli_prepare($conn, $updateQuery);
        
        if ($updateStmt) {
            mysqli_stmt_bind_param($updateStmt, "i", $logId);
            mysqli_stmt_execute($updateStmt);
            mysqli_stmt_close($updateStmt);
        } else {
            return "Error preparing update query: " . mysqli_error($conn);
        }
    } else {
        mysqli_stmt_close($checkStmt);
    }

    // Insert new status log
    $insertQuery = "INSERT INTO employee_status_log (employee_id, status, start_time) VALUES (?, ?, NOW())";
    $insertStmt = mysqli_prepare($conn, $insertQuery);

    if (!$insertStmt) {
        return "Error preparing insert query: " . mysqli_error($conn);
    }

    mysqli_stmt_bind_param($insertStmt, "is", $employee_id, $status);

    if (!mysqli_stmt_execute($insertStmt)) {
        return "Error inserting new status log: " . mysqli_error($conn);
    }

    mysqli_stmt_close($insertStmt);
    return "Status change logged successfully.";
}
?>