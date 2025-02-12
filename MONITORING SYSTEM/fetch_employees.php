<?php
require 'db_connect.php';

$query = "SELECT * FROM employee ORDER BY id ASC";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()): ?>
    <div class="col-xl-3 col-md-6 employee-card">
        <div class="card total_employee text-white bg-primary mb-4">
            <div class="card-body">
                <i class="fas fa-id-badge"></i>
            </div>
            <div class="card-footer">
                <center><h4><b><?php echo explode(' ', htmlspecialchars($row['first_name']))[0]; ?></b></h4></center>
                <div class="row mt-2">
                    <a href="#?id=<?php echo $row['id']; ?>" class="btn btn-success col"><i class="fas fa-pencil"></i></a>
                    <a href="#?id=<?php echo $row['id']; ?>" class="btn btn-danger col" onclick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>

<?php $conn->close(); ?>
