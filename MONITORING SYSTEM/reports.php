<?php include 'include/scripts.php';?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>MONITORING</title>
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
        <div><?php include 'include/header.php';?></div>
        <div id="layoutSidenav">
            <div><?php include 'include/navbar.php';?></div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="buttons m-3">
                        <div class="filter-container">
                            <div class="filter-group">
                                <label>Categorize by:</label>
                                <button class="filter-btn active">All</button>
                                <button class="filter-btn">Employee <i class="fa-solid fa-user-group"></i></button>
                                <button class="filter-btn">Service</button>
                                <button class="filter-btn">Service Status <i class="fa-solid fa-chevron-down"></i></button>
                                <button class="filter-btn">Location</button>
                            </div>
                            <div class="filter-group">
                                <label>Date:</label>
                                <button class="filter-btn">Weekly</button>
                                <button class="filter-btn active">Monthly</button>
                                <button class="filter-btn">Yearly</button>
                                <button class="filter-btn">Custom <i class="fa-solid fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="button-container">
                        <button class="generate-btn">Generate Report</button>
                        <button class="export-btn">Export Report <i class="fa-solid fa-file-export"></i></button>
                    </div>
                    <div>
                        <h2 style="text-align: center;">Employee Report for the Month of December 2024</h2>
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-xl-6 col-md-6">
                                    <h3>Text here</h3>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
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
        </script>   
    </body>
</html>

