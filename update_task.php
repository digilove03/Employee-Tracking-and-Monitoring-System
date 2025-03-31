<?php 
include(__DIR__ . '/db_connect.php'); // Ensure correct path
include(__DIR__ . '/log_employee_status.php'); // Include logging function

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $taskId = $_POST['record_number'] ?? null;
    $service_status = $_POST['service_status'] ?? null;
    $remarks = $_POST['remarks'] ?? null;

    if (!$taskId || !$service_status) {
        echo "error: missing required fields";
        exit();
    }

    // Check if the status is "Completed" or "Canceled"
    if ($service_status === "Completed" || $service_status === "Canceled") {
        // Fetch `time_started` and `employee_id`
        $query = "SELECT time_started, employee_id FROM tasks WHERE record_number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $taskId);
        $stmt->execute();
        $result = $stmt->get_result();
        $task = $result->fetch_assoc();
        $stmt->close();

        if (!$task) {
            echo "error: task not found";
            exit();
        }

        $time_started = $task['time_started'];
        $employeeId = $task['employee_id']; 

        if (!$time_started) {
            echo "error: time_started is NULL";
            exit();
        }

        // Start transaction
        mysqli_begin_transaction($conn);

        try {
            // Update task with completion time
            $query = "UPDATE tasks 
            SET service_status = ?, 
                remarks = ?, 
                completion_time = SEC_TO_TIME(TIMESTAMPDIFF(SECOND, time_started, NOW())),
                delay = CASE 
                            WHEN TIMESTAMPDIFF(MINUTE, deadline, NOW()) > 30 THEN 'Yes' 
                            ELSE 'No' 
                        END
            WHERE record_number = ?";        
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("error: " . $conn->error);
            }
            $stmt->bind_param("ssi", $service_status, $remarks, $taskId);
            $stmt->execute();
            $stmt->close();

            // Update the employee status to "Available"
            if ($employeeId) {
                $query = "UPDATE employee SET status = 'Available' WHERE id = ?";
                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    throw new Exception("error: " . $conn->error);
                }
                $stmt->bind_param("i", $employeeId);
                $stmt->execute();
                $stmt->close();

                // Log the status change
                $logResult = logEmployeeStatus($conn, $employeeId, 'Available');
                if (strpos($logResult, "Error") !== false) {
                    throw new Exception($logResult);
                }
            }

            // Commit transaction
            mysqli_commit($conn);
            echo "success";
        } catch (Exception $e) {
            // Rollback transaction on error
            mysqli_rollback($conn);
            echo $e->getMessage();
        }
    } else { 
        // The only valid statuses are "Completed" and "Canceled"
        echo "error: invalid status";
        exit();
    }

    $conn->close();
}
?>
