<?php 
session_start();
include('db_connect.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

include('include/scripts.php');
include('include/header.php');

$query = "SELECT t.*, 
                 CONCAT(e.first_name, ' ', LEFT(e.middle_name, 1), '. ', e.last_name) AS employee_name
          FROM tasks t
          JOIN employee e ON t.employee_id = e.id
          ORDER BY t.time_started DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>EMPLOYEE TRACKING AND MONITORING SYSTEM</title>
  <!-- Flatpickr CSS for date/time picker -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Flatpickr JS -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <style>
    body {
      background: #f8f9fa;
    }
    .container-fluid {
      padding: 20px;
    }
    .card {
      border-radius: 8px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
      background: rgb(21, 68, 118) !important;
      color: white;
    }
    .table th {
      background: rgb(21, 68, 118);
      color: white;
      text-align: center;
    }
    .btn-delete {
      background: #dc3545;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
    }
    .btn-delete:hover {
      background: #c82333;
    }
#addServiceBtn {
    font-size: 0.8rem; /* Makes the text smaller */
    padding: 4px 8px; /* Reduces button size */
    display: flex;
    justify-content: flex-end;
}
  </style>
</head>
<body class="sb-nav-fixed">

<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
    <?php include 'include/navbar.php'; ?>
  </div>

  <div id="layoutSidenav_content">
    <main class="container-fluid">
      <div class="card">
        <div class="card-header text-white">
          <h4 class="mb-0">Task Monitoring</h4>
        </div>
        <div class="card-body">
          <form id="taskForm" class="row g-3">
            <div class="col-md-3">
              <label for="employeeName" class="form-label">Employee Name</label>
              <select id="employeeName" class="form-select" required>
                <option value="">Select Employee</option>
                <?php
                  $query = "SELECT id, last_name, first_name FROM employee ORDER BY last_name ASC";
                  $employeeResult = mysqli_query($conn, $query);
                  while ($row = mysqli_fetch_assoc($employeeResult)) {
                    echo '<option value="' . $row['id'] . '">' . $row['last_name'] . ', ' . $row['first_name'] . '</option>';
                  }
                ?>
              </select>
            </div>

            <!-- Service Dropdown and Tag Display -->
            <div class="col-md-3">
              <label for="serviceSelect" class="form-label">Service</label>
              <select id="serviceSelect" class="form-select">
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
              <!-- "Others" input (hidden by default) -->
              <input type="text" id="otherService" class="form-control mt-2 d-none" placeholder="Please specify other service">
              <!-- Button to add the selected service -->
              <button type="button" id="addServiceBtn" class="btn btn-info mt-2">Add Service</button>
              <!-- Container for added service tags -->
              <div id="selectedServices" class="mt-2"></div>
            </div>

            <div class="col-md-2">
              <label for="location" class="form-label">Location</label>
              <input type="text" id="location" class="form-control" required>
            </div>
            
            <div class="col-md-2">
              <label for="estimatedTime" class="form-label">Estimated Time</label>
              <input type="datetime-local" id="estimatedTime" class="form-control" required>
            </div>
            
            <!-- Role select field -->
            <div class="col-md-2">
              <label for="role" class="form-label">Role</label>
              <select id="role" class="form-select" required>
                <option value="">Select Role</option>
                <option value="main">Main</option>
                <option value="assistant">Assistant</option>
                <option value="supervisor">Supervisor</option>
                <option value="substitute assistant">Substitute Assistant</option>
                <option value="substitute main">Substitute Main</option>
                <option value="substitute supervisor">Substitute Supervisor</option>
              </select>
            </div>

            <div class="col-md-2 d-grid">
              <button type="submit" class="btn btn-primary mt-4">Assign Task</button>
            </div>
          </form>

          <!-- Task Table -->
          <div class="table-responsive mt-4">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th>Record Number</th>
                  <th>Employee</th>
                  <th>Service</th>
                  <th>Req. Office/ Dept.</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?= htmlspecialchars($row['record_number']) ?></td>
                    <td><?= htmlspecialchars($row['employee_name']) ?></td>
                    <td><?= htmlspecialchars($row['service']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td class="service_status" style="color: 
                        <?php 
                            echo ($row['service_status'] === 'Ongoing') ? 'blue' : 
                                ($row['service_status'] === 'Completed' ? 'green' : 'red'); 
                        ?>
                    ">
                        <?= htmlspecialchars($row['service_status']) ?>
                    </td>
                    <td> 
                      <button class="btn btn-primary btn-view">View</button> 
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<script>
$(document).ready(function() {
  // Initialize Flatpickr for estimated time input
  flatpickr("#estimatedTime", {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    time_24hr: true
  });

  // Show/hide the Others input based on dropdown selection for services.
  $("#serviceSelect").change(function() {
    if ($(this).val() === "Others") {
      $("#otherService").removeClass("d-none").prop("required", true);
    } else {
      $("#otherService").addClass("d-none").val("").prop("required", false);
    }
  });

  // Array to store selected services
  let selectedServices = [];

  // When the Add Service button is clicked
  $("#addServiceBtn").click(function() {
    let serviceVal = $("#serviceSelect").val();
    if (!serviceVal) return; // Do nothing if no service is selected

    let serviceText = "";
    if (serviceVal === "Others") {
      serviceText = $("#otherService").val().trim();
      if (!serviceText) {
        alert("Please specify the other service.");
        return;
      }
    } else {
      serviceText = serviceVal;
    }
    
    // Avoid duplicates
    if (selectedServices.includes(serviceText)) {
      alert("Service already added.");
      return;
    }

    // Add service to the array and display it as a tag
    selectedServices.push(serviceText);
    $("#selectedServices").append(
      `<span class="service-tag" data-service="${serviceText}">
          ${serviceText} <span class="remove-tag">&times;</span>
       </span>`
    );

    // Reset the dropdown and others input
    $("#serviceSelect").val("");
    $("#otherService").addClass("d-none").val("").prop("required", false);
  });

  // Remove a service tag when its remove icon is clicked
  $("#selectedServices").on("click", ".remove-tag", function() {
    let tag = $(this).parent();
    let service = tag.data("service");
    // Remove service from the array
    selectedServices = selectedServices.filter(s => s !== service);
    tag.remove();
  });

  // Handle form submission without a JavaScript confirmation.
  $("#taskForm").submit(function(event) {
    event.preventDefault();

    // Get employee information.
    let employeeId = $("#employeeName").val();
    let employeeText = $("#employeeName option:selected").text();

    // Combine selected services into a comma-separated string.
    let serviceText = selectedServices.join(", ");

    // Get other form values.
    let location = $("#location").val();
    let role = $("#role").val();
    let deadline = $("#estimatedTime").val();

    // Get current time (time_started) in a proper format.
    let timeStarted = new Date().toISOString().slice(0, 19).replace('T', ' ');
    
    
    // Send data via AJAX to save_task.php
    $.ajax({
      url: "save_task.php",
      type: "POST",
      data: {
        employee_id: employeeId,
        service: serviceText,
        location: location,
        role: role,
        deadline: deadline,
        time_started: timeStarted
      },
      success: function(response) {
        // Reset form fields and clear selected services.
        $("#taskForm")[0].reset();
        selectedServices = [];
        $("#selectedServices").empty();
        $("#otherService").addClass("d-none").val("").prop("required", false);
        // Reinitialize Flatpickr after form reset.
        flatpickr("#estimatedTime", {
          enableTime: true,
          dateFormat: "Y-m-d H:i",
          time_24hr: false
        });
      },
      error: function(xhr, status, error) {
        alert("An error occurred while saving the task.");
      }
    });
  });

});
</script>

</body>
</html>
