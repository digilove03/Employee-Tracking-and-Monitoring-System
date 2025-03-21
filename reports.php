<?php 
include 'include/scripts.php';
include 'include/header.php';
include 'include/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Employee Monitoring & Tracking System</title>
        <style>             
            .buttons {
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #f8f9fa;
            }

            .filter-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                align-items: center;
                background: #f8f9fa;
                padding: 15px;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                width: 100%;
            }

            .filter-group {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 10px;
            }

            .filter-group label {
                font-weight: bold;
                color: #333; 
                margin-right: 5px;
            }

            .filter-btn {
                background: #007bff;
                color: white;
                border: none;
                padding: 8px 15px;
                border-radius: 5px;
                cursor: pointer;
                transition: 0.3s;
                font-size: 14px;
                display: flex;
                align-items: center;
                gap: 5px;
            }

            .filter-btn:hover {
                background: #0056b3;
            }

            .button-container {
                display: flex;
                justify-content: flex-end; 
                width: 100%;
                margin: 15px 0;
                padding: 0 15px;
            }

            .generate-btn, .export-btn {
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
                font-weight: bold;
                transition: 0.3s;
                margin-left: 10px;
            }

            .generate-btn { background: #28a745; }
            .generate-btn:hover { background: #218838; }
            .export-btn { background: #e0a800; }
            .export-btn:hover { background: #d39e00; }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="buttons m-3">
                        <div class="filter-container">
                            <div class="filter-group">
                                <label>Categorize by:</label>
                                <button class="filter-btn" data-filter="all">All</button>

                                <select class="filter-btn" name="select_employee" id="select_employee" data-filter="employee">
                                    <option value="" disabled selected>Select Employee</option>
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
                                <select class="filter-btn" name="service" id="service" data-filter="service">
                                    <option value="" disabled selected>Service</option>
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
                            </div>
                            
                            <div class="filter-group">
                                <label>Date:</label>
                                <button class="filter-btn" data-range="weekly">Weekly</button>
                                <button class="filter-btn" data-range="monthly">Monthly</button>
                                <button class="filter-btn" data-range="yearly">Yearly</button>
                                <button class="filter-btn" data-range="custom">
                                    Custom <i class="fa-solid fa-calendar"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="button-container">
                        <button class="generate-btn" id="generateReportBtn">Generate Report</button>
                        <button class="export-btn">Export Report <i class="fa-solid fa-file-export"></i></button>
                    </div>
                    <div>
                        <h2 style="text-align: center;">Employee Report for the Month of December 2024</h2>
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-xl-6 col-md-6">
                                    <div>
                                        <p>Total Tasks:<span id="total-tasks">0</span></p>
                                        <p>Completed:<span id="completed-tasks">0</span></p>
                                        <p>Ongoing:<span id="ongoing-tasks">0</span></p>
                                        <p>Cancelled:<span id="cancelled-tasks">0</span></p>
                                    </div>
                                    <table id="report-container"></table>
                                </div>
                                <div class="col-xl-6 col-md-6 card" id="chart_div">
                                    <h5 style="text-align: center;">DEPARTMENT PRODUCTIVITY</h5>
                                    <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
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
                                <a href="#">Privacy Policy</a> &middot; <a href="#">Terms & Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script>
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';
            var ctx = document.getElementById("myPieChart");
            var myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ["Blue", "Red", "Yellow", "Green"],
                    datasets: [{
                        data: [12.21, 15.58, 11.25, 8.32],
                        backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
                    }],
                },
            });



            document.addEventListener("DOMContentLoaded", function () {
                let currentFilter = "all";
                let currentDateRange = "all";

                function updateActiveButton(groupSelector, activeButton) {
                    document.querySelectorAll(groupSelector).forEach(button => {
                        button.classList.remove("active-filter");
                    });
                    activeButton.classList.add("active-filter");
                }
                document.querySelectorAll(".filter-btn[data-filter]").forEach(button => {
                    button.addEventListener("click", function () {
                        currentFilter = this.dataset.filter;
                        updateActiveButton(".filter-btn[data-filter]", this);
                    });
                });
          
                document.querySelectorAll(".filter-btn[data-range]").forEach(button => {
                    button.addEventListener("click", function () {
                        currentDateRange = this.dataset.range;
                        updateActiveButton(".filter-btn[data-range]", this);
                    });
                });
            
                document.getElementById("service").addEventListener("change", function () {
                    currentFilter = this.value;
                    updateActiveButton(".filter-btn[data-filter]", this);
                });    
                document.querySelector(".filter-btn[data-filter='all']").classList.add("active-filter");
                document.querySelector(".filter-btn[data-range='weekly']").classList.add("active-filter");
            });

            document.addEventListener("DOMContentLoaded", function () {
                document.getElementById("generateReportBtn").addEventListener("click", function () {
                    let formData = new FormData();
                    formData.append("employee_id", document.getElementById("select_employee").value);
                    formData.append("service", document.getElementById("service").value);
                    formData.append("date_range", document.querySelector(".filter-btn[data-range].active")?.getAttribute("data-range") || "yearly");
                
                    fetch("get_reports.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("report-container").innerHTML = data.report;
                        document.getElementById("total-tasks").innerText = data.total_tasks;
                        document.getElementById("completed-tasks").innerText = data.completed_tasks;
                        document.getElementById("ongoing-tasks").innerText = data.ongoing_tasks;
                        document.getElementById("cancelled-tasks").innerText = data.cancelled_tasks;
                    })
                    .catch(error => console.error("Error:", error));
                });
            });

        </script>   
    </body>
</html>

