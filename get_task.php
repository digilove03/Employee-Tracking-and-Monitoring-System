<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $taskId = $_POST['id'];
    
    $sql = "SELECT t.*, 
                     CONCAT(e.first_name, ' ', LEFT(e.middle_name, 1), '. ', e.last_name) AS employee_name
              FROM tasks t
              JOIN employee e ON t.employee_id = e.id
              WHERE t.record_number = ?";
              
     $stmt = $conn->prepare($sql);
     if (!$stmt) {
         echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
         exit();
     }
 
     $stmt->bind_param("s", $taskId);
     $stmt->execute();
     $result = $stmt->get_result();
     
     if ($result->num_rows > 0) {
         $task = $result->fetch_assoc();
         echo json_encode(["status" => "success", "data" => $task]);
     } else {
         echo json_encode(["status" => "error", "message" => "Task not found"]);
     }
 
     $stmt->close();
     $conn->close();
 }
?>
