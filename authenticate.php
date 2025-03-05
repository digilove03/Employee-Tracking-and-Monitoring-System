<?php
session_start();
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // Plain text password

    // Prevent SQL injection
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $admin_row = $result->fetch_assoc();
        if ($password == $admin_row['password']) { 
            $_SESSION['admin_id'] = $admin_row['id']; 

            echo json_encode(["status" => "success"]);
            exit();
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid password."]);
            exit();
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found."]);
        exit();
    }
}

echo json_encode(["status" => "error", "message" => "Invalid request."]);
exit();
?>
