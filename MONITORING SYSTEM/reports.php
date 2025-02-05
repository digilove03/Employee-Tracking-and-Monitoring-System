<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>MONITORING</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/style.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark" id="topNavBG">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Employee Monitoring</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <span class="top_nav_space"></span>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading"><img class="logo" src="pictures/dasmoLogo.png" alt=""></div>
                            <br>
                            <a class="nav-link" id="homeLink" href="index.html">
                                <div class="sb-nav-link"><i class="fas fa-box"></i></div>
                                Dashboard
                            </a>

                            <a class="nav-link" href="employees.html">
                                <div class="sb-nav-link"><i class="fas fa-person"></i></div>
                                Employees
                            </a>

                            <a class="nav-link" id="linkBG" href="reports.html">
                                <div class="sb-nav-link"><i class="fas fa-chart-line"></i></div>
                                Reports and Analytics
                            </a>
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Admin
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="buttons">
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
                
                        <button class="generate-btn">Generate Report</button>
                    </div>
                </div>
                
                    <div class="container-fluid px-4">
                        <div class="col">
                            <div class="card mt-3">
                                dfdfgdfg
                            </div>

                            <div class="row d-flex justify-content-end">
                                <button class="btn btn-primary col-xl-1 col-sm-2">Export Report</button>
                            </div>

                            <div>
                                <h2><center>Employee Report for the Month of December 2024</center></h2>
                                <br>
                                <div class="container-fluid px-4">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <h1>dsfdsfsdf</h1>
                                        </div>
    
                                        <div class="col-xl-6 card" id="chart_div">
                                            <h5 class="vertical_text"><center>DEPARTMENT PRODUCTIVITY</center></h5>
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

