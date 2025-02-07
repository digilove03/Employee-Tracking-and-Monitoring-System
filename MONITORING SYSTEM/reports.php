<?php include 'include/scripts.php';?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>MONITORING</title>
        <link href="css/style.css" rel="stylesheet" />

        <style>             
            .buttons {
              font-family: Arial, sans-serif;
              display: flex;
              justify-content: center;
              align-items: center;
              background-color: #f8f9fa;
            }

            .filter-container {
              background-color: #e6f2ec;
              padding: 15px;
              border-radius: 10px;
              width: 100%;
            }
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
                            <label>Categorize by</label>
                            <button class="filter-btn active">All</button>
                            <button class="filter-btn">Employee <i class="fa-solid fa-user-group"></i></button>
                            <button class="filter-btn">Service</button>
                            <button class="filter-btn">Service Status <i class="fa-solid fa-chevron-down"></i></button>
                            <button class="filter-btn">Location</button>
                        </div>
                
                        <div class="filter-group">
                            <label>Date</label>
                            <button class="filter-btn">Weekly</button>
                            <button class="filter-btn active">Monthly</button>
                            <button class="filter-btn">Yearly</button>
                            <button class="filter-btn">Custom <i class="fa-solid fa-calendar"></i></button>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="generate-btn">Generate Report</button>
                        </div>
                  
                    </div>
                </div>
                
                    <div class="container-fluid px-4">
                        <div class="col">
                            <div class="d-grid d-md-flex justify-content-md-end">
                                <button class="btn btn-primary col-xl-2 m-2">Export Report</button>
                            </div>

                            <div>
                                <h2><center>Employee Report for the Month of December 2024</center></h2>
                                <br>
                                <div class="container-fluid px-4">
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6">
                                            <h3>Text here</h3>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure rem magni culpa explicabo? Illum, quibusdam ipsum! Consequatur sint ab architecto. Ipsa animi aliquid laboriosam quis numquam. Eligendi nam magni iusto!</p>
                                        </div>
    
                                        <div class="col-xl-6 col-md-6 card" id="chart_div">
                                            <h5><center>DEPARTMENT PRODUCTIVITY</center></h5>

                                            <!--Charts here -->
                                            <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>                                     
                                        </div>
    
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <br>                        

                     
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script>
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';
                                                    
            // Pie Chart Example
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

