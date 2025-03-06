<?php
require_once 'db_connect.php';

$response = ["success" => false, "message" => ""];

if (!isset($_POST['id']) || empty($_POST['id'])) {
    $response["message"] = "Invalid employee ID.";
    echo json_encode($response);
    exit();
}

$id = intval($_POST['id']);
$address = $_POST['editEmployeeAddress'] ?? '';
$position = $_POST['editEmployeePosition'] ?? '';
$civilStatus = $_POST['editEmployeeCivilStatus'] ?? '';
$contact = $_POST['editEmployeeContact'] ?? '';
$empStatus = $_POST['editEmployeeStatus'] ?? '';

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

$query = "UPDATE employee SET address = ?, position = ?, civil_status = ?, contact_number = ?, status = ?" .
    ($photoPath ? ", photo_path = ?" : "") . " WHERE id = ?";

$stmt = $conn->prepare($query);
if ($photoPath) {
    $stmt->bind_param("ssssssi", $address, $position, $civilStatus, $contact, $empStatus, $photoPath, $id);
} else {
    $stmt->bind_param("sssssi", $address, $position, $civilStatus, $contact, $empStatus, $id);
}

if ($stmt->execute()) {
    $response["success"] = true;
    $response["message"] = "Employee updated successfully!";
} else {
    $response["message"] = "Failed to update employee.";
}

echo json_encode($response);
?>