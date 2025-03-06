<?php 
include(__DIR__ . '/db_connect.php'); // Ensure correct path

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $taskId = $_POST['record_number'] ?? null;
    $service_status = $_POST['service_status'] ?? null;
    $remarks = $_POST['remarks'] ?? null;

    if (!$taskId || !$service_status) {
        echo "error: missing required fields";
        exit();
    }

    // Check if the status is "Completed" or "Cancelled"
    if ($service_status === "Completed" || $service_status === "Cancelled") {
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

        // Update task with completion time
        $query = "UPDATE tasks SET service_status = ?, remarks = ?, completion_time = TIMESTAMPDIFF(MINUTE, time_started, NOW()) WHERE record_number = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo "error: " . $conn->error;
            exit();
        }
        $stmt->bind_param("ssi", $service_status, $remarks, $taskId);
        $stmt->execute();
        $stmt->close();

        // Update the employee status to "Available"
        if ($employeeId) {
            $query = "UPDATE employee SET status = 'Available' WHERE id = ?";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                echo "error: " . $conn->error;
                exit();
            }
            $stmt->bind_param("i", $employeeId);
            $stmt->execute();
            $stmt->close();
        }

        echo "success";
    } else { 
        // The only valid statuses are "Completed" and "Canceled"
        echo "error: invalid status";
        exit();
    }

    $conn->close();
}
?>
