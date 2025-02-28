<?php 
session_start();
require('db_connect.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$department = '';

// Fetch admin's department
$query = "SELECT department FROM admin WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($department);
$stmt->fetch();
$stmt->close();

include('include/scripts.php');
include('include/header.php');
include('include/navbar.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>EMPLOYEE TRACKING AND MONITORING SYSTEM</title>
    <style>
        .dropdown-item:hover {
            cursor: pointer;
        }

        .form-container {
            width: 400px;
            border: 2px solid #ccc;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .photo-section {
            text-align: center;
        }

        .photo-preview {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 5px;
        }


        .input-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            width: 100%;
        }

        .input-container input {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }


        .full-width {
            grid-column: span 2;
        }


        .buttons {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 10px;
        }

        .buttons button {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }


        .close-btn {
            background-color: gray;
            color: white;
        }

        .save-btn {
            background-color: blue;
            color: white;
        }

        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #profilePreview {
            width: 145px;
            height: 145px;
            object-fit: cover;
            border: 1px solid #ccc;
            display: block;
        }

        #profilePicture {
            width: 150px;
            margin-top: 5px;
        }

        /* Form Controls */
        .form-control {
            border-radius: 5px;
        }

        .modal-footer button {
            min-width: 100px;
        }

        label {
            font-size: 13px;
            margin-bottom: 0;
            padding-top: 5px;
            font-style: italic;
        }


        #addEmployeeModal .modal-dialog {
            max-width: 60%;
        }

        #addEmployeeModal .modal-body {
            align-items: center;
            max-height: 70vh;
            overflow-y: auto;
        }

        @media (max-width: 576px) {
            .col-sm-6, .col-sm-4, .col-sm-3 {
                width: 100%;
            }
        }

        .search-container {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .search-container input {
            width: 250px;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search-container button {
            padding: 8px 12px;
            border-radius: 5px;
        }

        .card-body {
            display: flex;
            align-items: center; 
            gap: 15px; 
            font-size: 14px;
        }

        .card-body i {
            font-size: 50px; 
            color: #fff; 
            flex-shrink: 0; 
        }

        .card-body .placeholder {
            color: #ccc; 
            font-style: italic;
        }

        .info-text p {
            margin: 3px 0; 
            font-size: 14px; 
        }

        .searchBTN {
            border: 0;
        }
    </style>

</head>
<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        
        <div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <!-- Row for Add New Button (Aligned Right) -->
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                        <i class="fas fa-user-plus"></i> Add New
                    </button>
                </div>
            </div>

            <!-- Line Break -->
            <br>

            <!-- Row for Search Bar (Aligned Left) -->
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group d-flex align-items-center">
                        <input type="text" id="searchBox" class="h-100 form-control" placeholder="Search employee...">
                        <button class="btn btn-primary searchBTN" onclick="searchEmployee()">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </div>

            <!-- Line Break -->
            <br>

            <!-- Employee Cards -->
            <div class="employee_container">
                <div class="row">
                    <?php 
                    // Fetch employee data
                    $query = "SELECT *, TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age FROM employee ORDER BY id ASC";
                    $result = $conn->query($query); 

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
                                <!-- Employee Photo -->
                                <img src="<?php echo $photoPath; ?>" 
                                    alt="Profile Picture"
                                    style="width: 50px; height: 50px; object-fit: cover;">

                                <!-- Employee Info -->
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-1"><strong>Name:</strong> <?php echo $name; ?></p>
                                    <p class="mb-1"><strong>Position:</strong> <?php echo $position; ?></p>
                                    <p class="mb-1"><strong>Status:</strong> <?php echo $status; ?></p>
                                </div>
                            </div>
                            
                            <!-- Card Footer with Buttons -->
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
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; DASMO 2025</div>
                <div>
                    <a href="#">Privacy Policy</a> &middot; <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>
</div>

    <!-- Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLabel">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form id="employeeForm" action="save_employees.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <!-- Error message container -->
                        <div id="errorMessage" style="color: red; font-style: italic; margin-bottom: 10px;"></div>
                        
                        <div class="row">
                            <!-- Photo Upload -->
                            <div class="col-sm-3 text-center">
                                <img id="profilePreview" src="emp_profile/default.png" class="img-thumbnail" alt="Profile Picture">
                                <input type="file" class="form-control" name="employeePhoto" id="employeePhoto" onchange="previewImage(event)">
                            </div>
                            <!-- Personal Information -->
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="firstName">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="middleName">Middle Name</label>
                                        <input type="text" class="form-control" id="middleName" name="middleName" required>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="suffix">Suffix</label>
                                        <input type="text" class="form-control" id="suffix" name="suffix">
                                    </div>
                                </div>
                                
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="birthdate">Birthdate</label>
                                        <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="age">Age</label>
                                        <input type="number" class="form-control" id="age" readonly style="color: black; background-color: lightgray;">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="sex">Sex</label>
                                        <select class="form-control" id="sex" name="sex" required>
                                            <option value="" disabled selected>Select</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="civilStatus">Civil Status</label>
                                        <select class="form-control" id="civilStatus" name="civilStatus" required>
                                            <option value="" disabled selected>Select</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="religion">Religion</label>
                                <select class="form-control" id="religion" name="religion" required>
                                    <option value="" disabled selected>Select</option>
                                    <option value="Christianity">Christianity</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Hinduism">Hinduism</option>
                                    <option value="Buddhism">Buddhism</option>
                                    <option value="Judaism">Judaism</option>
                                    <option value="Sikhism">Sikhism</option>
                                    <option value="Atheism">Atheism</option>
                                    <option value="Agnosticism">Agnosticism</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="contactNumber">Contact Number</label>
                                <input type="int" class="form-control" id="contactNumber" name="contactNumber" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" id="department" name="department" value="<?php echo htmlspecialchars($department); ?>" readonly style="color: black; background-color: lightgray;">
                            </div>
                            <div class="col-sm-4">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="position" name="position" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="hiredDate">Hired Date</label>
                                <input type="date" class="form-control" id="hiredDate" name="hiredDate" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn close-btn" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn save-btn">Save</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>


    
        <!-- View Employee Modal -->
    <div class="modal fade" id="viewEmployeeModal" tabindex="-1" aria-labelledby="viewEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewEmployeeModalLabel">Employee Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Profile Picture -->
                    <img src="emp_profile/default.png" class="employee-photo img-fluid rounded-circle mb-3" 
                         style="width: 100px; height: 100px; object-fit: cover;">
                    
                    <p><strong>Name:</strong> <span id="employeeName"></span></p>
                    <p><strong>Sex:</strong> <span id="employeeSex"></span></p>
                    <p><strong>Date of Birth:</strong> <span id="employeeDOB"></span></p>
                    <p><strong>Address:</strong> <span id="employeeAddress"></span></p>
                    <p><strong>Religion:</strong> <span id="employeeReligion"></span></p>
                    <p><strong>Position:</strong> <span id="employeePosition"></span></p>
                    <p><strong>Department:</strong> <span id="employeeDepartment"></span></p>
                    <p><strong>Civil Status:</strong> <span id="employeeCivilStatus"></span></p>
                    <p><strong>Hired Date:</strong> <span id="employeeHiredDate"></span></p>
                    <p><strong>Contact Number:</strong> <span id="employeeContact"></span></p>
                    <p><strong>Email Addres:</strong> <span id="employeeEmail"></span></p>
                    <p><strong>Status:</strong> <span id="employeeStatus"></span></p>

                    <p><strong>Age:</strong> <span id="employeeAge"></span></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                document.getElementById('profilePreview').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // Calculate age when birthdate changes
        document.getElementById("birthdate").addEventListener("change", function() {
            const birthDate = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            document.getElementById("age").value = age;
        });

        // AJAX form submission with confirmation and inline error message
        $("#employeeForm").submit(function(e) {
            e.preventDefault(); // Prevent default submission

            // Confirm before saving
            if (!confirm("Are you sure you want to save this new employee?")) {
                return false;
            }

            // Clear any previous error messages
            $("#errorMessage").html("");

            // Create FormData to capture form data including file uploads
            var formData = new FormData(this);

            $.ajax({
                url: 'save_employees.php', // PHP script that processes the form
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json', // Expect JSON response from PHP
                success: function(response) {
                    if (response.success) {
                        alert("Employee added successfully!");
                        window.location.href = 'employees.php';
                    } else {
                        // Display the error inline in the modal
                        $("#errorMessage").html(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    $("#errorMessage").html("An unexpected error occurred: " + error);
                }
            });
        });
        function searchEmployee() {
        let searchValue = document.getElementById('searchBox').value.trim();

        // Send AJAX request
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "search_employee.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.querySelector(".employee_container .row").innerHTML = xhr.responseText;
            }
        };
        xhr.send("search=" + encodeURIComponent(searchValue));
        }

        // Trigger search on input change
        document.getElementById('searchBox').addEventListener("keyup", function () {
            searchEmployee();
        });


        //viewEmployee modal
        $(document).ready(function() {
            $(".viewEmployeeBtn").click(function() {
            let employeeId = $(this).data("id");

            // Make AJAX request to fetch employee details
            $.ajax({
                url: "view_modal.php",  // Backend PHP file
                type: "POST",
                data: { id: employeeId },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $(".employee-photo").attr("src", response.photo);
                        $("#employeeName").text(response.name);
                        $("#employeeSex").text(response.sex);
                        $("#employeeDOB").text(response.birthdate);
                        $("#employeeAddress").text(response.address);
                        $("#employeeReligion").text(response.religion);
                        $("#employeePosition").text(response.position);
                        $("#employeeDepartment").text(response.department);
                        $("#employeeCivilStatus").text(response.civilStatus);
                        $("#employeeHiredDate").text(response.hireDate);
                        $("#employeeContact").text(response.contactNum);
                        $("#employeeEmail").text(response.email);
                        $("#employeeStatus").text(response.status);
                        $("#employeeAge").text(response.age);
                    } else {
                        alert("Failed to fetch employee details.");
                    }
                }, 
                error: function() {
                    alert("Error connecting to server.");
                }
            });
            });
        });

        </script>
</body>
</html>
<?php $conn->close(); ?>
