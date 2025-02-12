<?php include 'include/scripts.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Task Monitoring</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        background: rgb(21, 68, 118) !important; /* Updated Color */
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
</style>
</head>
<body class="sb-nav-fixed">

<?php include 'include/header.php'; ?>

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
                            <div class="col-md-4">
                                <label for="employeeName" class="form-label">Employee Name</label>
                                <input type="text" id="employeeName" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="taskDescription" class="form-label">Task Description</label>
                                <input type="text" id="taskDescription" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label for="estimatedTime" class="form-label">Estimated Time (hrs)</label>
                                <input type="number" id="estimatedTime" class="form-control" required>
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
                                        <th>Employee</th>
                                        <th>Task</th>
                                        <th>Estimated Time</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                           
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#taskForm").submit(function(event) {
                event.preventDefault();

                let employeeName = $("#employeeName").val();
                let taskDescription = $("#taskDescription").val();
                let estimatedTime = $("#estimatedTime").val();

                let newRow = `
                    <tr>
                        <td>${employeeName}</td>
                        <td>${taskDescription}</td>
                        <td>${estimatedTime} hrs</td>
                        <td>
                            <select class="task-status form-select">
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn-delete">Delete</button>
                        </td>
                    </tr>`;

                $("#taskList").append(newRow);
                $("#taskForm")[0].reset();
            });

            $(document).on("click", ".btn-delete", function() {
                $(this).closest("tr").remove();
            });

            $(document).on("change", ".task-status", function() {
                let status = $(this).val();
                $(this).css("color", status === "Pending" ? "orange" : status === "In Progress" ? "blue" : "green");
            });
        });
    </script>

</body>
</html>
