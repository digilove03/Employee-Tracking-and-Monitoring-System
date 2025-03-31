<?php 
session_start();
include('db_connect.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

include('include/scripts.php');
include('include/header.php');
include('include/navbar.php');

// Function to fetch tasks based on service_status
function fetchTasks($conn, $service_status) {
    $sql = "SELECT 
                t.record_number, 
                t.employee_id, 
                t.service, 
                t.location, 
                t.time_started, 
                CONCAT(e.first_name, ' ', LEFT(e.middle_name, 1), '. ', e.last_name) AS employee_name
            FROM tasks t
            JOIN employee e ON t.employee_id = e.id
            WHERE t.service_status = ?
            ORDER BY t.time_started";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $service_status);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

// Fetch tasks for each status
$ongoingTasks = fetchTasks($conn, 'Ongoing');
$completedTasks = fetchTasks($conn, 'Completed');
$canceledTasks = fetchTasks($conn, 'Canceled');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Employee Monitoring & Tracking System</title>
  <!-- Flatpickr CSS for date/time picker -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Flatpickr JS -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.6">
  <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
  
  <style>
    .dropdown-item:hover {
        cursor: pointer;
    }

    .form-container {
        width: 200px;
        border: 2px solid #ccc;
        padding: 15px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
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
        background-color: #C6E7FF;
        color: #000;
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

    @media (max-width: 576px) {
        .col-sm-6, .col-sm-4, .col-sm-3 {
            width: 100%;
        }
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

    .service-tag {
        display: inline-block;
        background-color: #f0f0f0; /* Light gray */
        border-radius: 20px; /* Makes it oval */
        padding: 5px 15px;
        margin: 5px;
        font-size: 14px;
        font-weight: bold;
        color: #333;
        border: 1px solid #ccc;
    }

    .service-tag .remove-tag {
        margin-left: 8px;
        cursor: pointer;
        font-weight: bold;
        color: red;
    }

    .modal-header {
      background-color: #A1E3F9;
      color: #black;
    }

    .modal-content {
        border-radius: 10px;
        padding: 15px;
    }

    .task-label {
        font-weight: bold;
        color: #333;
    }

    .task-text {
        font-size: 1rem;
        color: #555;
        padding: 5px 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }

    .task-detail {
        margin-bottom: 12px;
    }

    .task-select {
        border-radius: 5px;
        padding: 8px;
    }

    .task-textarea {
        min-height: 80px;
        border-radius: 5px;
    }

    #printTaskDetails,
    #assignTaskBtn {
        background-color: #FFDDAE !important; 
        color: #000 !important; 
        border-color:rgb(230, 173, 92) !important;
        transition: background-color 0.3s ease;
    }

    #printTaskDetails:hover,
    #assignTaskBtn:hover {
        background-color:rgb(204, 125, 15) !important;
        color: white !important;
    }

    #ongoingTaskTable,
    #completedTaskTable,
    #canceledTaskTable {
        border-collapse: collapse !important; /* Ensures borders collapse properly */
        width: 100%;
    }

    #ongoingTaskTable th,
    #completedTaskTable th,
    #canceledTaskTable th {
        border: 1px solid black !important; /* Forces all borders */
    }

    #ongoingTaskTable thead th,
    #completedTaskTable thead th,
    #canceledTaskTable thead th {
        border-bottom: 2px solid black !important; /* Makes header thicker */
        border-top: 2px solid black !important;
    }

    .btn.btn-primary {
        background-color: #C6E7FF; /* Default color */
        color: #000;
        transition: background-color 0.3s ease;
    }

    .btn.btn-primary:hover {
        background-color: #578FCA;
        color: white;
    }

    #addServiceBtn {
        background-color: #D4F6FF !important; 
        color: #000 !important; 
        border-color:rgb(110, 171, 236) !important;
        transition: background-color 0.3s ease;
        width: 150px;
    }

    #addServiceBtn:hover {
        background-color: #578FCA !important;
        color: white !important;
    }
    .nav-tabs .nav-link {
        background-color: lightgray;
        color:rgb(21, 10, 89);
        font-size: 14px;
        transition: all 0.3s;
    }
    .nav-tabs .nav-link.active {
        background-color:rgb(72, 201, 234);
        color: white !important;
        padding: 14px 18px;
        font-size: 16px;
        margin-bottom: -1px;
        border-bottom: 2px solid white;
    }
    .nav-tabs .nav-link.inactive {
        background-color: gray;
        color: white;
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
                    <button id="assignTaskBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignTaskModal">
                    <i class="fas fa-tasks"></i> Assign New Task
                    </button>
                </div>
            </div>

            <!-- Line Break -->
            <br>

            <br>
            <!-- Tablist -->
            <ul class="nav nav-tabs" id="taskTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="ongoing-tab" data-bs-toggle="tab"
                    href="#ongoing" role="tab">
                        Ongoing
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="completed-tab" data-bs-toggle="tab"
                    href="#completed" role="tab">
                        Completed
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="canceled-tab" data-bs-toggle="tab"
                    href="#canceled" role="tab">
                        Canceled
                    </a>
                </li>
            </ul>
            <!-- Tab Content -->
            <div class="tab-content" id="tasksTabsContent">

                <!-- Ongoing TAB -->
                <div class="tab-pane fade show active" id="ongoing" role="tabpanel">
                    <br>
                    <div class="table-responsive">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div id="ongoing-length-container"></div>  <!-- Length menu (records per page) -->
                        <div id="ongoing-buttons-container"></div> <!-- Buttons -->
                    </div>

                    <div id="ongoing-search-container" class="d-flex justify-content-end mb-3"></div> <!-- Space before table -->

                        <table id="ongoingTaskTable" class="display table-bordered">
                            <thead style="background-color: #C6E7FF !important; color: #000 !important; font-weight: bold !important;">
                                <tr>
                                    <th>Record No.</th>
                                    <th>Employee</th>
                                    <th>Service</th>
                                    <th>Location</th>
                                    <th>Time Started</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ongoingTasks as $row) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['record_number']); ?></td>
                                        <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['service']); ?></td>
                                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                                        <td><?php echo date('Y-m-d H:i', strtotime($row['time_started'])); ?></td>
                                        <td style="text-align:center; color: #000;">
                                            <button class="btn btn-primary btn-sm viewTaskBtn" 
                                                style="background-color: #FFDDAE !important; color: #000 !important; border-color:rgb(230, 173, 92) !important;"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewTaskModal" 
                                                data-id="<?php echo $row['record_number']; ?>">
                                                <i class="fas fa-eye" style="color: #000 !important;"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Completed TAB -->
                <div class="tab-pane fade" id="completed" role="tabpanel">
                    <br>
                    <div class="table-responsive">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div id="completed-length-container"></div>  <!-- Length menu (records per page) -->
                        <div id="completed-buttons-container"></div> <!-- Buttons -->
                    </div>

                    <div id="completed-search-container" class="d-flex justify-content-end mb-3"></div> <!-- Space before table -->

                        <table id="completedTaskTable" class="display table-bordered">
                            <thead style="background-color: #C6E7FF !important; color: #000 !important; font-weight: bold !important;">
                                <tr>
                                    <th>Record No.</th>
                                    <th>Employee</th>
                                    <th>Service</th>
                                    <th>Location</th>
                                    <th>Time Started</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($completedTasks as $row) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['record_number']); ?></td>
                                        <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['service']); ?></td>
                                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                                        <td><?php echo date('Y-m-d H:i', strtotime($row['time_started'])); ?></td>
                                        <td style="text-align:center; color: #000;">
                                            <button class="btn btn-primary btn-sm viewTaskBtn" 
                                                style="background-color: #FFDDAE !important; color: #000 !important; border-color:rgb(230, 173, 92) !important;"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewTaskModal" 
                                                data-id="<?php echo $row['record_number']; ?>">
                                                <i class="fas fa-eye" style="color: #000 !important;"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Canceled TAB -->
                <div class="tab-pane fade" id="canceled" role="tabpanel">
                    <br>
                    <div class="table-responsive">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div id="canceled-length-container"></div>  <!-- Length menu (records per page) -->
                        <div id="canceled-buttons-container"></div> <!-- Buttons -->
                    </div>

                    <div id="canceled-search-container" class="d-flex justify-content-end mb-3"></div> <!-- Space before table -->

                        <table id="canceledTaskTable" class="display table-bordered">
                            <thead style="background-color: #C6E7FF !important; color: #000 !important; font-weight: bold !important;">
                                <tr>
                                    <th>Record No.</th>
                                    <th>Employee</th>
                                    <th>Service</th>
                                    <th>Location</th>
                                    <th>Time Started</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($canceledTasks as $row) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['record_number']); ?></td>
                                        <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['service']); ?></td>
                                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                                        <td><?php echo date('Y-m-d H:i', strtotime($row['time_started'])); ?></td>
                                        <td style="text-align:center; color: #000;">
                                            <button class="btn btn-primary btn-sm viewTaskBtn" 
                                                style="background-color: #FFDDAE !important; color: #000 !important; border-color:rgb(230, 173, 92) !important;"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewTaskModal" 
                                                data-id="<?php echo $row['record_number']; ?>">
                                                <i class="fas fa-eye" style="color: #000 !important;"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <br>
            </div>
  </main>

  <!-- Assign Task Modal -->
<div class="modal fade" id="assignTaskModal" tabindex="-1" aria-labelledby="assignTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignTaskModalLabel"><i class="fas fa-tasks"></i>
                Assign New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="taskForm" action="save_task.php" method="POST">
                <div class="modal-body">
                    <!-- Error message container -->
                    <div id="errorMessage" style="color: red; font-style: italic; margin-bottom: 10px;"></div>

                    <!-- Employee Selection -->
                    <div class="col-md-12">
                        <label for="employeeName" class="form-label">Employee Name</label>
                        <select id="employeeName" name="employee_id" class="form-select" required>
                            <option value="">Select Employee</option>
                            <?php
                            include('db_connect.php');
                            $query = "SELECT id, last_name, first_name FROM employee WHERE status = 'Available' ORDER BY last_name ASC";
                            $employeeResult = mysqli_query($conn, $query);

                            if (mysqli_num_rows($employeeResult) > 0) {
                                while ($row = mysqli_fetch_assoc($employeeResult)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['last_name'] . ', ' . $row['first_name'] . '</option>';
                                }
                            } else {
                                echo '<option value="" disabled>No available employees</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Service Selection (Aligned with Add Button) -->
                    <div class="col-md-12 mt-3">
                        <label for="serviceSelect" class="form-label">Service</label>
                        <div class="d-flex">
                            <select id="serviceSelect" class="form-select me-2" style="width: 70%;">
                                <option value="">Select Service</option>
                                <option value="Diagnostic">Diagnostic</option>
                                <option value="Computer Format">Computer Format</option>
                                <option value="Data Recovery">Data Recovery</option>
                                <option value="Virus/Malware Removal">Virus/Malware Removal</option>
                                <option value="Computer Repair">Computer Repair</option>
                                <option value="Change Hardware">Change Hardware</option>
                                <option value="Computer Upgrade">Computer Upgrade</option>
                                <option value="Printer Repair">Printer Repair</option>
                                <option value="Printer Setup">Printer Setup</option>
                                <option value="Printer Reset">Printer Reset</option>
                                <option value="Router Setup">Router Setup</option>
                                <option value="Router Reset">Router Reset</option>
                                <option value="Others">Others</option>
                            </select>
                            <button type="button" id="addServiceBtn" class="btn btn-secondary">Add Service</button>
                        </div>

                        <!-- Custom input for 'Others' -->
                        <input type="text" id="otherService" class="form-control mt-2 d-none" placeholder="Please specify other service">

                        <div id="selectedServices" class="mt-2"></div>
                    </div>

                    <input type="hidden" id="selectedServicesInput" name="service">

                    <!-- Location Input -->
                    <div class="col-md-12 mt-3">
                        <label for="location" class="form-label">Req. Office/ Dept.</label>
                        <input type="text" id="location" name="location" class="form-control" required>
                    </div>

                    <!-- Estimated Time -->
                    <div class="col-md-12 mt-3">
                        <label for="estimatedTime" class="form-label">Estimated Time</label>
                        <input type="datetime-local" id="estimatedTime" name="deadline" class="form-control" required>
                    </div>

                    <!-- Role Selection -->
                    <div class="col-md-12 mt-3">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="">Select Role</option>
                            <option value="Main">Main</option>
                            <option value="Assistant">Assistant</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Substitute Assistant">Substitute Assistant</option>
                            <option value="Substitute Main">Substitute Main</option>
                            <option value="Substitute Supervisor">Substitute Supervisor</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Assign Task</button>
                </div>
            </form>
        </div>
    </div>
</div>


  <!-- View Task Modal -->
<div class="modal fade task-modal" id="viewTaskModal" tabindex="-1" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTaskModalLabel"><i class="fas fa-clipboard-list"></i>
                View Task Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="viewUpdateForm" action="update_task.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="record_number" name="record_number">

                    <!-- Error message container -->
                    <div id="errorMessage" class="text-danger mb-2"></div>

                    <div class="task-detail">
                        <label class="task-label">Record Number</label>
                        <p class="task-text" id="taskRecordNumber"></p>
                    </div>

                    <div class="task-detail">
                        <label class="task-label">Employee Name</label>
                        <p class="task-text" id="taskEmployeeName"></p>
                    </div>

                    <div class="task-detail">
                        <label class="task-label">Service</label>
                        <p class="task-text" id="taskService"></p>
                    </div>

                    <div class="task-detail">
                        <label class="task-label">Req. Office/Dept.</label>
                        <p class="task-text" id="taskLocation"></p>
                    </div>

                    <div class="task-detail">
                        <label class="task-label">Estimated Time Deadline</label>
                        <p class="task-text" id="taskDeadline"></p>
                    </div>

                    <div class="task-detail">
                        <label class="task-label">Role</label>
                        <p class="task-text" id="taskRole"></p>
                    </div>

                    <div class="task-detail">
                        <label class="task-label">Time Started</label>
                        <p class="task-text" id="taskTimeStarted"></p>
                    </div>
                    
                    <div class="task-detail">
                        <label class="task-label">Time Ended</label>
                        <p class="task-text" id="taskTimeEnded"></p>
                    </div>

                    <div class="task-detail">
                        <label class="task-label">Completion Time</label>
                        <p class="task-text" id="taskCompletionTime"></p>
                    </div>

                    <hr style="width: 100%; height: 2px; background-color: black; border: none;">
                    <div class="task-detail">
                        <label class="task-label">Status</label>
                        <select id="service_status" name="service_status" class="form-select task-select">
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>
                            <option value="Canceled">Canceled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="task-label">Remarks</label>
                        <textarea id="remarks" name="remarks" class="form-control task-textarea" autocomplete="off">No Remarks.</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                <button type="button" id="printTaskDetails" class="btn btn-secondary">Print</button>
                <button type="submit" id="saveTaskChanges" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    flatpickr("#estimatedTime", {
        enableTime: true,
        dateFormat: "Y-m-d H:i"
    });

    $(document).ready(function() {
        // Initialize each DataTable separately with the correct options
        let ongoingTable = $('#ongoingTaskTable').DataTable({
            stripeClasses: [],
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
            "pageLength": 10,
            "dom": '<"top"lBf>rtip',
            "buttons": [
                'copy', 'csv', 'print'
            ],
            "language": {
                "search": "Search Task: ",
                "lengthMenu": "Show _MENU_ records per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ tasks"
            }
        });

        let completedTable = $('#completedTaskTable').DataTable({
            stripeClasses: [],
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
            "pageLength": 10,
            "dom": '<"top"lBf>rtip',
            "buttons": [
                'copy', 'csv', 'print'
            ],
            "language": {
                "search": "Search Task: ",
                "lengthMenu": "Show _MENU_ records per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ tasks"
            }
        });

        let canceledTable = $('#canceledTaskTable').DataTable({
            stripeClasses: [],
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
            "pageLength": 10,
            "dom": '<"top"lBf>rtip',
            "buttons": [
                'copy', 'csv', 'print'
            ],
            "language": {
                "search": "Search Task: ",
                "lengthMenu": "Show _MENU_ records per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ tasks"
            }
        });

        // Move the length menu (records per page) to its own div
        $('#ongoing-length-container').html($('#ongoingTaskTable_length'));
        $('#completed-length-container').html($('#completedTaskTable_length'));
        $('#canceled-length-container').html($('#canceledTaskTable_length'));

        // Move the buttons to their own div
        $('#ongoing-buttons-container').html(ongoingTable.buttons().container());
        $('#completed-buttons-container').html(completedTable.buttons().container());
        $('#canceled-buttons-container').html(canceledTable.buttons().container());

        // Move the search to their own div
        $('#ongoing-search-container').html($('#ongoingTaskTable_filter'));
        $('#completed-search-container').html($('#completedTaskTable_filter'));
        $('#canceled-search-container').html($('#canceledTaskTable_filter'));

        $("#serviceSelect").change(function() {
            if ($(this).val() === "Others") {
            $("#otherService").removeClass("d-none").prop("required", true);
            } else {
            $("#otherService").addClass("d-none").val("").prop("required", false);
            }
        });

  // Array to store selected services
  let selectedServices = [];

    $("#addServiceBtn").click(function() {
        let serviceVal = $("#serviceSelect").val();
        let serviceText = serviceVal === "Others" ? $("#otherService").val().trim() : serviceVal;

        if (!serviceText) {
            alert("Please specify the service.");
            return;
        }

        if (selectedServices.includes(serviceText)) {
            alert("Service already added.");
            return;
        }

        selectedServices.push(serviceText);
        $("#selectedServices").append(
            `<span class="service-tag" data-service="${serviceText}">
                ${serviceText} <span class="remove-tag">&times;</span>
            </span>`
        );

        $("#selectedServicesInput").val(selectedServices.join(", "));
        $("#serviceSelect").val("");
        $("#otherService").addClass("d-none").val("").prop("required", false);
    });

    $("#selectedServices").on("click", ".remove-tag", function() {
        let tag = $(this).parent();
        let service = tag.data("service");
        selectedServices = selectedServices.filter(s => s !== service);
        tag.remove();
        $("#selectedServicesInput").val(selectedServices.join(", "));
    });

    $("#taskForm").submit(function(event) {
        event.preventDefault();

        if (!confirm("Are you sure you want to assign this task?")) {return false;}

        let formData = new FormData(this);
        $.ajax({
            url: "save_task.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.message);
                if (response.status === "success") {
                    location.reload();
                }
            },
            error: function() {
                alert("Error assigning task.");
            }
        });
    });

    $(document).on("click", ".viewTaskBtn", function () {
        let taskId = $(this).data("id");

        $.ajax({
            url: "get_task.php",
            method: "POST",
            data: { id: taskId },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#record_number").val(response.data.record_number);
                    $("#taskRecordNumber").text(response.data.record_number);
                    $("#taskEmployeeName").text(response.data.employee_name);
                    $("#taskService").text(response.data.service);
                    $("#taskLocation").text(response.data.location);
                    $("#taskDeadline").text(response.data.deadline);
                    $("#taskRole").text(response.data.role);
                    $("#taskTimeStarted").text(response.data.time_started);
                    $("#taskTimeEnded").text(response.data.time_ended);
                    $("#taskCompletionTime").text(response.data.completion_time);
                    $("#service_status").val(response.data.service_status);
                    $("#remarks").val(response.data.remarks ? response.data.remarks : "No Remarks.");

                    if (response.data.service_status === "Ongoing") {
                        $("#taskTimeEnded").closest(".task-detail").hide();
                        $("#taskCompletionTime").closest(".task-detail").hide();
                    } else {
                        $("#taskTimeEnded").closest(".task-detail").show();
                        $("#taskCompletionTime").closest(".task-detail").show();
                    }

                    if (response.data.service_status !== "Ongoing") {
                        $("#service_status, #remarks").prop("disabled", true);
                        $("#saveTaskChanges").hide();
                    } else {
                        $("#service_status, #remarks").prop("disabled", false);
                        $("#saveTaskChanges").show();
                    }

                    $("#viewTaskModal").modal("show");
                } else {
                    alert("Error fetching task details.");
                }
            },
            error: function () {
                alert("Failed to fetch task details.");
            }
        });
    });

    $(document).on("submit", "#viewUpdateForm", function (e) {
    e.preventDefault(); // Prevent default form submission

    let service_status = $("#service_status").val();
    let remarks = $("#remarks").val().trim();

    if (!confirm("Are you sure you want to update this task?")) {
        return false;
    }

    if (!service_status || remarks === "") {
        alert("Status and remarks cannot be empty.");
        return false;
    }

        // Perform AJAX request
        $.ajax({
            type: "POST",
            url: "update_task.php", // Ensure this points to the correct PHP script
            data: $(this).serialize(),
            success: function (response) {
                if (response.trim() === "success") {
                    alert("Task updated successfully!");
                    location.reload(); // Reload the page
                } else {
                    alert("Error updating task: " + response);
                }
            },
            error: function () {
                alert("An error occurred while updating the task.");
            }
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("printTaskDetails").addEventListener("click", function () {
        let printContent = document.querySelector("#viewTaskModal .modal-body").innerHTML;
        let originalContent = document.body.innerHTML;

        document.body.innerHTML = `
            <html>
            <head>
                <title>Task Details</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    .task-label { font-weight: bold; }
                    .task-text { margin-bottom: 10px; }
                </style>
            </head>
            <body>
                ${printContent}
            </body>
            </html>
        `;

        window.print();
        document.body.innerHTML = originalContent;
        location.reload(); // Reload the page to restore the modal
    });
});

</script>
</body>
</html>
