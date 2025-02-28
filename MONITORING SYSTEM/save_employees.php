<?php 
require 'db_connect.php'; // Include database connection

header('Content-Type: application/json');

$response = array('success' => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $firstName     = htmlspecialchars(trim($_POST['firstName']));
    $lastName      = htmlspecialchars(trim($_POST['lastName']));
    $middleName    = htmlspecialchars(trim($_POST['middleName'])); 
    $suffix        = htmlspecialchars(trim($_POST['suffix'])); 
    $sex           = htmlspecialchars(trim($_POST['sex']));
    $birthdate     = htmlspecialchars(trim($_POST['birthdate']));
    $address       = htmlspecialchars(trim($_POST['address']));
    $position      = htmlspecialchars(trim($_POST['position']));
    $department    = htmlspecialchars(trim($_POST['department']));
    $civilStatus   = htmlspecialchars(trim($_POST['civilStatus']));
    $hiredDate     = htmlspecialchars(trim($_POST['hiredDate']));
    $contactNumber = htmlspecialchars(trim($_POST['contactNumber']));
    $email         = htmlspecialchars(trim($_POST['email']));
    $religion      = htmlspecialchars(trim($_POST['religion'])); 

    $status = "Available";

    // Check if the employee already exists based on name and birthdate
    $checkEmployeeQuery = "SELECT id FROM employee WHERE last_name = ? AND first_name = ? AND middle_name = ? AND suffix = ? AND birthdate =?";
    $checkEmployeeStmt = $conn->prepare($checkEmployeeQuery);
    $checkEmployeeStmt->bind_param("sssss", $lastName, $firstName, $middleName, $suffix, $birthdate);
    $checkEmployeeStmt->execute();
    $checkEmployeeStmt->store_result();

    if ($checkEmployeeStmt->num_rows > 0) {
        $response['error'] = "An employee with the same name and birthdate already exists.";
        echo json_encode($response);
        exit;
    }
    $checkEmployeeStmt->close();
    
    // Check if the email already exists
    $checkQuery = "SELECT id FROM employee WHERE email_address = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $response['error'] = "This email address is already registered.";
        echo json_encode($response);
        exit;
    }
    $checkStmt->close();

    // Handle Image Upload
    $uploadDir = 'emp_profile/' . $firstName . '_' . $lastName . '/'; // Employee-specific folder
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create folder if it doesn’t exist
    }

    $photoPath = null;
    if (isset($_FILES['employeePhoto']) && $_FILES['employeePhoto']['error'] == 0) {
        $fileName = basename($_FILES['employeePhoto']['name']);
        $targetPath = $uploadDir . $fileName;

        // Move uploaded file
        if (move_uploaded_file($_FILES['employeePhoto']['tmp_name'], $targetPath)) {
            $photoPath = $targetPath;
        }
    }
    
    // Set a default photo path if no image is uploaded
    if ($photoPath === null) {
        $photoPath = 'emp_profile/default.png';
    }

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO employee (first_name, last_name, middle_name, suffix, sex, birthdate, address, position, department, civil_status, hiring_date, contact_number, email_address, photo_path, religion, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        $response['error'] = "Prepare failed: " . $conn->error;
        echo json_encode($response);
        exit;
    }
    
    $stmt->bind_param("sssssssssssissss", 
        $firstName, 
        $lastName, 
        $middleName, 
        $suffix, 
        $sex, 
        $birthdate, 
        $address, 
        $position, 
        $department, 
        $civilStatus, 
        $hiredDate, 
        $contactNumber, 
        $email, 
        $photoPath, 
        $religion,
        $status
    );

    // Execute and check for success
    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['error'] = "Database Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
}
?>
