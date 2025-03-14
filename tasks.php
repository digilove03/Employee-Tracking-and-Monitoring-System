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

function fetchTasks($conn) {
    $sql = "SELECT 
                t.record_number, 
                t.employee_id, 
                t.service, 
                t.location, 
                t.role, 
                t.time_started, 
                t.completion_time, 
                t.remarks, 
                t.service_status, 
                CONCAT(e.first_name, ' ', LEFT(e.middle_name, 1), '. ', e.last_name) AS employee_name
            FROM tasks t
            JOIN employee e ON t.employee_id = e.id
            ORDER BY t.time_started";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}
$tasks = fetchTasks($conn);
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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.6">
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
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
        background-color: blue;
        color: white;
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
      
    #assignTaskModal .modal-dialog {
        max-width: 40%; /* Reduce the width */
    }

    #assignTaskModal .modal-body {
        padding: 10px; /* Reduce padding */
        max-height: 60vh; /* Reduce height if necessary */
        overflow-y: auto;
    }

    #assignTaskModal .modal-header, 
    #assignTaskModal .modal-footer {
        padding: 8px; /* Reduce space on top and bottom */
    }

    #assignTaskModal label {
        font-size: 12px; /* Make labels slightly smaller */
    }

    #assignTaskModal .form-select,
    #assignTaskModal .form-control {
        font-size: 14px; /* Keep input readability but slightly smaller */
        padding: 6px; /* Reduce padding */
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
      background-color: #007bff;
      color: #fff;
    }

    .task-modal .modal-content {
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

    #printTaskDetails {
        background-color: rgb(5, 72, 175);
        color: white;
        transition: background-color 0.3s ease;
    }

    #printTaskDetails:hover {
        background-color: #007bff;
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
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignTaskModal">
                    <i class="fas fa-tasks"></i> Assign New Task
                    </button>
                </div>
            </div>

            <!-- Line Break -->
            <br>

            <br>

            <!-- Task Records Table -->
            <div class="table-responsive">
                        <table id="taskTable" class="display nowrap table table-striped table-bordered">
                            <thead>
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
                                <?php foreach ($tasks as $row) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['record_number']); ?></td>
                                        <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['service']); ?></td>
                                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                                        <td><?php echo date('Y-m-d H:i', strtotime($row['time_started'])); ?></td>
                                        <td style="text-align:center">
                                            <button class="btn btn-primary btn-sm viewTaskBtn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewTaskModal" 
                                                data-id="<?php echo $row['record_number']; ?>">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
            </div>
        </div>
  </main>

  <!-- Assign Task Modal -->
<div class="modal fade" id="assignTaskModal" tabindex="-1" aria-labelledby="assignTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignTaskModalLabel">Assign New Task</h5>
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
                            <button type="button" id="addServiceBtn" class="btn btn-secondary" style="background-color: rgb(22, 125, 235); color: white; width: 150px;">Add Service</button>
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
                <h5 class="modal-title" id="viewTaskModalLabel"><i class="fas fa-clipboard-list"></i> View Task Details</h5>
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
                        <label class="task-label">Estimated Time</label>
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

                    <hr style="width: 100%; height: 2px; background-color: black; border: none;">
                    <div class="task-detail">
                        <label class="task-label">Status</label>
                        <select id="service_status" name="service_status" class="form-select task-select">
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
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
        $('#taskTable').DataTable({
            "paging": true,  // Enable pagination
            "searching": true,  // Enable search bar
            "ordering": true,  // Enable column sorting
            "info": true,  // Show table info
            "lengthMenu": [10],  // Set number of records per page
            "dom": 'Bfrtip',
            "buttons": [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "language": {
                "search": "Search Task: ",
                "lengthMenu": "Show _MENU_ records per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ tasks"
            }
        });

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
                    $("#taskCompletionTime").text(response.completion_time);
                    $("#service_status").val(response.data.service_status);
                    $("#remarks").val(response.data.remarks ? response.data.remarks : "No Remarks.");

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
