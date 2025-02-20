<?php
require 'db_connect.php';

// Combine your queries into one query that computes the age dynamically.
$query = "SELECT *, TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age FROM employee ORDER BY id ASC";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()):
    // Check if photo exists; otherwise, use a default image.
    $photoPath = !empty($row['photo_path']) ? htmlspecialchars($row['photo_path']) : 'emp_profile/default.png';
?>
    <div class="col-xl-3 col-md-6 employee-card">
        <div class="card total_employee text-white bg-primary mb-4">
            <div class="card-body">
                <center>
                    <!-- Use $photoPath here -->
                    <img src="<?php echo $photoPath; ?>" 
                         alt="Profile Picture" 
                         class="img-fluid rounded-circle" 
                         style="width: 80px; height: 80px; object-fit: cover;">
                </center>
            </div>
            <div class="card-footer">
                <center>
                    <h4><b><?php echo htmlspecialchars(explode(' ', $row['first_name'])[0]); ?></b></h4>
                </center>
                <div class="row mt-2">
                    <a href="edit_employee.php?id=<?php echo $row['id']; ?>" class="btn btn-success col">
                        <i class="fas fa-pencil"></i>
                    </a>
                    <a href="delete_employee.php?id=<?php echo $row['id']; ?>" class="btn btn-danger col" onclick="return confirm('Are you sure?');">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>

<?php $conn->close(); ?>
