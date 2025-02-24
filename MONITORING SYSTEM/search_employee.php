<?php
require('db_connect.php');

$search = isset($_POST['search']) ? trim($_POST['search']) : '';

// Fetch employees matching the search query
$query = "SELECT *, TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age 
          FROM employee 
          WHERE first_name LIKE ? OR last_name LIKE ?
          ORDER BY id ASC";

$stmt = $conn->prepare($query);
$searchParam = "%$search%";
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $photoPath = !empty($row['photo_path']) ? htmlspecialchars($row['photo_path']) : 'emp_profile/default.png';
        $name = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
        $position = !empty($row['position']) ? htmlspecialchars($row['position']) : 'N/A';
        $status = !empty($row['status']) ? htmlspecialchars($row['status']) : 'N/A';
?>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card total_employee text-white mb-4">
                <div class="card-body d-flex align-items-center">
                    <img src="<?php echo $photoPath; ?>" 
                        alt="Profile Picture"
                        style="width: 50px; height: 50px; object-fit: cover;">
                    <div class="flex-grow-1 ms-3">
                        <p class="mb-1"><strong>Name:</strong> <?php echo $name; ?></p>
                        <p class="mb-1"><strong>Position:</strong> <?php echo $position; ?></p>
                        <p class="mb-1"><strong>Status:</strong> <?php echo $status; ?></p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row g-1">
                        <button class="btn btn-info col viewEmployeeBtn" data-id="<?php echo $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#viewEmployeeModal"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-warning col editEmployeeBtn" data-id="<?php echo $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="fas fa-pencil-alt"></i></button>
                    </div>
                </div>
            </div>
        </div>

<?php 
    }
} else {
    echo "<p class='text-center text-muted'>No employees found!</p>";
}
?>
