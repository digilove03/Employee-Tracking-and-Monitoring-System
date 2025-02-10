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
    </head>
    <body class="sb-nav-fixed">
        
        <div><?php include 'include/header.php';?></div>
        
        <div id="layoutSidenav">
            
            <div id="layoutSidenav_nav">

                <div><?php include 'include/navbar.php';?></div>
                
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
    </body>
</html>
