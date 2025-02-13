<?php
require 'db_connect.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $middleName = htmlspecialchars(trim($_POST['middleName']));
    $sex = htmlspecialchars(trim($_POST['employeeSex']));
    $date_of_birth = htmlspecialchars(trim($_POST['employeeDate_of_Birth']));
    $address = htmlspecialchars(trim($_POST['employeeAddress']));
    $position = htmlspecialchars(trim($_POST['employeePosition']));
    $department = htmlspecialchars(trim($_POST['employeeDepartment']));
    $civil_status = htmlspecialchars(trim($_POST['employeeCivilStatus']));
    $hiring_date = htmlspecialchars(trim($_POST['employeeHiredDate']));
    $contact_number = htmlspecialchars(trim($_POST['employeeContactNum']));
    $emailAdd = htmlspecialchars(trim($_POST['emailAdd']));
    $age = filter_var($_POST['employeeAge'], FILTER_VALIDATE_INT);

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

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO employee (first_name, last_name, middle_name, sex, birthdate, address, position, department, civil_status, hiring_date, contact_number, email_address, age, photo_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssisis", $firstName, $lastName, $middleName, $sex, $date_of_birth, $address, $position, $department, $civil_status, $hiring_date, $contact_number, $emailAdd, $age, $photoPath);

    // Execute and check for success
    if ($stmt->execute()) {
        echo "New employee added successfully!";
        header("Location: employees.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
