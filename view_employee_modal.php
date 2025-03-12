<?php
require_once 'db_connect.php'; // Ensure this file contains your DB connection

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $query = "SELECT *, TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age FROM employee WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo json_encode([
            "success" => true,
            "id" => $row['id'],
            "photo" => $row['photo_path'],
            "name" => htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . ' ' . $row['suffix']),
            "sex" => htmlspecialchars($row['sex']),
            "birthdate" => htmlspecialchars($row['birthdate']),
            "address" => htmlspecialchars($row['address']),
            "religion" => htmlspecialchars($row['religion']),
            "position" => htmlspecialchars($row['position'] ?? "N/A"),
            "department" => htmlspecialchars($row['department']),
            "civilStatus" => htmlspecialchars($row['civil_status']),
            "hireDate" => htmlspecialchars($row['hiring_date']),
            "contactNum" => htmlspecialchars($row['contact_number']),
            "email" => htmlspecialchars($row['email_address']),
            "status" => htmlspecialchars($row['status'] ?? "N/A"),
            "age" => $row['age'],
            "firstName" => htmlspecialchars($row['first_name']),
            "lastName" => htmlspecialchars($row['last_name']),
            "middleName" => htmlspecialchars($row['middle_name']),
            "suffix" => htmlspecialchars($row['suffix']),
        ]);
    } else {
        echo json_encode(["success" => false]);
    }

    $stmt->close();
}
?>
