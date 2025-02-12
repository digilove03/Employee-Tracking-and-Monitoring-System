<?php
require 'db_connect.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    // Validate and sanitize inputs
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


    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO employee (first_name, last_name, middle_name, sex, birthdate, address, position, department, civil_status, hiring_date, contact_number, email_address, age) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssisi", $firstName, $lastName, $middleName, $sex, $date_of_birth, $address, $position, $department, $civil_status, $hiring_date, $contact_number, $emailAdd, $age);

    // Execute and check for success
    if ($stmt->execute()) {
        echo "New employee added successfully!";
        header("Location: employees.php"); // Redirect back to main page
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
