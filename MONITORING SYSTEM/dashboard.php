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
            <!-- Navbar Search-->
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
                            <div class="sb-sidenav-menu-heading"><img class="logo" src="img/dasmoLogo.png" alt=""></div>
                            <br>
                            <a class="nav-link" id="linkBG" href="index.html">
                                <div class="sb-nav-link"><i class="fas fa-box"></i></div>
                                Dashboard
                            </a>

                            <a class="nav-link" href="employees.html">
                                <div class="sb-nav-link"><i class="fas fa-person"></i></div>
                                Employees
                            </a>

                            <a class="nav-link" href="reports.html">
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
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <br>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card total_employee text-white mb-4">
                                    <div class="card-body"><center><h2>TOTAL EMPLOYEES</h2></center></div>
                                    <div class="card-footer">
                                        <center><h1><b>34</b></h1></center>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-9">
                                <div class="card text-white mb-4 status_card">
                                    <div class="card-body"><center><h1>Status</h1></center></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">

                                        <div class="container-fluid px-4">
                                            <div class="row">
                                                <div class="col-xl-3 col-md-6">
                                                    <div class="card text-white mb-4">
                                                        <div class="card-body"><center><h4>WORKING</h4></center></div>
                                                        <div class="card-footer">
                                                            <center><h2><b>1</b></h2></center>
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="col-xl-3 col-md-6">
                                                    <div class="card text-white mb-4">
                                                        <div class="card-body"><center><h4>ON LEAVE</h4></center></div>
                                                        <div class="card-footer">
                                                            <center><h2><b>2</b></h2></center>
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="col-xl-3 col-md-6">
                                                    <div class="card text-white mb-4">
                                                        <div class="card-body"><center><h4>ON BREAK</h4></center></div>
                                                        <div class="card-footer">
                                                            <center><h2><b>3</b></h2></center>
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="col-xl-3 col-md-6">
                                                    <div class="card text-white mb-4">
                                                        <div class="card-body"><center><h4>AVAILABLE</h4></center></div>
                                                        <div class="card-footer">
                                                            <center><h2><b>3</b></h2></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Area Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    </body>
</html>
