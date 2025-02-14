<?php 
require('db_connect.php');
include 'include/scripts.php';
// Fetch employee data
$query = "SELECT * FROM employee ORDER BY id ASC";
$result = $conn->query($query);
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
             cursor: 
             pointer; 
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
            gap: 3px; width: 100%; 
        }
        .input-container input { 
            width: 95%; 
            padding: 5px; 
        }
        .full-width { 
            grid-column: span 2; 
        }
        .buttons { 
            display: flex; 
            justify-content: space-between; 
            width: 100%; margin-top: 10px; 
        }
        .buttons button { 
            padding: 5px 10px; 
            border: none; 
            cursor: pointer; 
        }
        .close-btn { 
            background-color: gray;
            color: white; }
        .save-btn { 
            background-color: blue; 
            color: white; 
        }

        .profile-container {
             display: flex;
             flex-direction: column;
       }

        #profilePreview {
             width: 145px; /* Adjust size as needed */
             height: 145px;
             object-fit: cover;
             border: 1px solid #ccc;
             display: block;
             gap: 5px;
        }

        #profilePicture {
            width: 150px; /* Match profilePreview width */
            margin-top: 5px; /* Reduce gap */
        }
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
             align-items:center 70vh; 
             overflow-y: auto; }
            @media (max-width: 576px) { .col-sm-6, .col-sm-4, .col-sm-3 { width: 100%; } }
            

</style>


        </style>
    </head>
    <body class="sb-nav-fixed">

        <div><?php include 'include/header.php';?></div>
        
        <div id="layoutSidenav">

            <div><?php include 'include/navbar.php';?></div>
            
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="row">
                            
                            <span class="col"></span>
                            <button class="col col-xl-1 btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add new</button>
                        </div>
                        <br>
                        <div class="employee_container">
                            <div class="row">
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <div class="col-xl-3 col-md-6">
                                        <div class="card total_employee text-white mb-4">
                                            <div class="card-body fas fa-id-badge fa-10x"></div>
                                            <div class="card-footer">
                                                <center><h1><b><?php echo explode(' ', htmlspecialchars($row['first_name']))[0]; ?></b></h1></center>
                                                <div class="row">
                                                    <button class="btn btn-success col"><i class="fas fa-pencil"></i></button>
                                                    <button class="btn btn-danger col"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; DASMO 2025</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

         <!-- Modal -->
        
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Add New Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
         
            <form action="save_employees.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <!-- Photo Upload -->
                        <div class="col-sm-3 text-center">
                            <img id="profilePreview" src="emp_profile/default.png" class="img-thumbnail" alt="Profile Picture">
                            <input type="file" class="form-control" name="profilePicture" id="profilePicture" onchange="previewImage(event)">
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
                                    <input type="text" class="form-control" id="middleName" name="middleName">
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
                                    <input type="number" class="form-control" id="age" name="age" readonly style="color: blue; background-color: lightgray;">
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
                            <input type="text" class="form-control" id="religion" name="religion">
                        </div>
                        <div class="col-sm-4">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-sm-3">
                            <label for="contactNumber">Contact Number</label>
                            <input type="number" class="form-control" id="contactNumber" name="contactNumber" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <label for="department">Department</label>
                            <input type="text" class="form-control" id="department" name="department" required>
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

        <script>

        function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            document.getElementById('profilePreview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
            function setCivilStatus(status) {
                document.getElementById('employeeCivilStatus').value = status;
            }

            // Auto-refresh page every 5 seconds to load new employees
            //optional?
            setInterval(() => {
            fetch('fetch_employees.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('employeeContainer').innerHTML = data;
                });
            }, 5000);
        </script>

    </body>
</html>
<?php $conn->close(); ?>
