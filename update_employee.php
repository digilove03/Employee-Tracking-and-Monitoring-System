<?php
require_once 'db_connect.php';
require_once 'log_employee_status.php'; // Include the logging function

$response = ["success" => false, "message" => ""];

if (!isset($_POST['id']) || empty($_POST['id'])) {
    $response["message"] = "Invalid employee ID.";
    echo json_encode($response);
    exit();
}

$id = intval($_POST['id']);
$address = $_POST['editAddress'] ?? '';
$position = $_POST['editPosition'] ?? '';
$civilStatus = $_POST['editCivilStatus'] ?? '';
$contact = $_POST['editContactNumber'] ?? '';
$contactTwo = $_POST['editContactNumberTWO'] ?? '';
$landline = $_POST['editLandline'] ?? '';
$status = $_POST['editStatus'] ?? '';

// Check if a new photo is uploaded
$photoPath = null;
if (isset($_FILES['editEmployeePhoto']) && $_FILES['editEmployeePhoto']['error'] === 0) {
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = strtolower(pathinfo($_FILES['editEmployeePhoto']['name'], PATHINFO_EXTENSION));

    if (in_array($fileExtension, $allowedTypes)) {
        $stmt = $conn->prepare("SELECT first_name, last_name FROM employee WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $folderPath = 'emp_profile/' . $row['first_name'] . '_' . $row['last_name'] . '/';

            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $fileName = basename($_FILES['editEmployeePhoto']['name']);
            $targetPath = $folderPath . $fileName;

            if (move_uploaded_file($_FILES['editEmployeePhoto']['tmp_name'], $targetPath)) {
                $photoPath = $targetPath;
            } else {
                $response["message"] = "Failed to move uploaded file.";
                echo json_encode($response);
                exit();
            }
        } else {
            $response["message"] = "Employee not found.";
            echo json_encode($response);
            exit();
        }
    } else {
        $response["message"] = "Invalid file type.";
        echo json_encode($response);
        exit();
    }
}

// Get the old status before updating
$oldStatus = null;
$statusQuery = $conn->prepare("SELECT status FROM employee WHERE id = ?");
$statusQuery->bind_param("i", $id);
$statusQuery->execute();
$statusQuery->bind_result($oldStatus);
$statusQuery->fetch();
$statusQuery->close();

// Prepare the update query
$query = "UPDATE employee SET address = ?, position = ?, civil_status = ?, contact_number = ?, contact_number2 = ?, landline = ?, status = ?" .
    ($photoPath ? ", photo_path = ?" : "") . " WHERE id = ?";

$stmt = $conn->prepare($query);
if ($photoPath) {
    $stmt->bind_param("ssssssssi", $address, $position, $civilStatus, $contact, $contactTwo, $landline, $status, $photoPath, $id);
} else {
    $stmt->bind_param("sssssssi", $address, $position, $civilStatus, $contact, $contactTwo, $landline, $status, $id);
}

// Execute the update
if ($stmt->execute()) {
    // Log the status change if it was modified
    if ($oldStatus !== $status) {
        logEmployeeStatus($conn, $id, $status);
    }

    $response["success"] = true;
    $response["message"] = "Employee updated successfully!";
} else {
    $response["message"] = "Failed to update employee.";
}

echo json_encode($response);
?>
