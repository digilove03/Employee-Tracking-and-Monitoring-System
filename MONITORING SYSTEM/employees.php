<?php include 'include/scripts.php';?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>MONITORING SYSTEM</title>
    </head>
    <body class="sb-nav-fixed">

        <div><?php include 'include/header.php';?></div>
        
        <div id="layoutSidenav">

            <div><?php include 'include/navbar.php';?></div>
            
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="row">
                            <h1 class="mt-4 col">DASMO</h1>
                            <span class="col"></span>
                            <button class="col col-xl-1 btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add new</button>
                        </div>
                        <br>
                        <div class="employee_container">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card total_employee text-white mb-4">
                                        <div class="card-body fas fa-id-badge fa-10x"></div>
                                        <div class="card-footer">
                                            <center><h1><b>Name</b></h1></center>
                                            <div class="row">
                                                <button class="btn btn-success col"><i class="fas fa-pencil"></i></button>
                                                <button class="btn btn-danger col"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

            <form>
                <div class="modal-body">
                    <div class="row">
                        <!-- First Column with Upload Button, Name, Position, Department, Hired Date -->
                        <div class="col-sm-6">
                            <!-- Update Photo Button -->
                              <div class="mb-3 text-center">
                                <div class="profile-picture">
                                    <i class="fa-solid fa-user fa-5x"></i> <!-- User icon -->
                                </div>
                                <button type="button" class="btn btn-light mt-2" id="uploadPhotoBtn" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                                    Upload Picture
                                </button>
                            </div>

                            <input type="text" class="form-control mb-3 mt-2" id="employeeName" placeholder=" Name" required>
                            <input type="text" class="form-control mb-3 mt-2" id="employeePosition" placeholder=" Position" required>
                            <input type="text" class="form-control mb-3 mt-2" id="employeeDepartment" placeholder=" Department" required>
                            <input type="text" class="form-control mb-3 mt-2" id="employeeHiredDate" placeholder=" Hired Date" required>
                        </div>

                        <!-- Second Column with Contact Number, Address, Date of Birth, Sex, Age, and Civil Status -->
                        <div class="col-sm-6">
                            <input type="text" class="form-control mb-3 mt-2" id="employeeContactNum" placeholder=" Contact Number" required>
                            <input type="text" class="form-control mb-3 mt-2" id="employeeAddress" placeholder=" Address" required>
                            <input type="text" class="form-control mb-3 mt-2" id="employeeDate_of_Birth" placeholder=" Date of Birth" required>
                            <input type="text" class="form-control mb-3 mt-2" id="employeeSex" placeholder=" Sex" required>
                            <input type="text" class="form-control mb-3 mt-2" id="employeeAge" placeholder=" Age" required>

                            <!-- Civil Status Dropdown -->
                            <div class="input-group mb-3 mt-2">
                                <input type="text" class="form-control" id="employeeCivilStatus" placeholder=" Civil Status" required readonly>
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    ▼
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="employeeCivilStatus">
                                    <li><a class="dropdown-item" href="#" onclick="setCivilStatus('Single')">Single</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="setCivilStatus('Married')">Married</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="setCivilStatus('Divorced')">Divorced</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="setCivilStatus('Widowed')">Widowed</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Employee</button>
                </div>
            </form>
        </div>
    </div>
</div>

        <script>
            function setCivilStatus(status) {
                document.getElementById('employeeCivilStatus').value = status;
            }
        </script>

    </body>
</html>

