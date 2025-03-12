<?php
include 'db_connect.php'; // Ensure this file exists

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];

    if (!empty($id) && !empty($status)) {
        $query = "UPDATE employee SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $status, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Status updated successfully!";
        } else {
            echo "Error updating status: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Invalid request!";
    }
}
?>
