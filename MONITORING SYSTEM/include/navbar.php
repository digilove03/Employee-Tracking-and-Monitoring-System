
    <style>
        .nav-link {
            border-radius: 10px;
            margin:10px;
        }
        .nav-link:hover {
            background-color: #0a53be;
        }
        .sb-nav-link {
            margin-right: 10px;
        }

        .logo {
            overflow: hidden;
            width: 60%;
        }
        .sb-sidenav-menu-heading {
            display: flex;
            justify-content: center;
        }

        .nav-link.active {
            background-color: white;
            color: #002233 !important;
        }
    </style>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading"><img class="logo" src="img/dasmoLogo.png" alt=""></div>
                        <br>
                        <a class="nav-link" href="dashboard.php">
                            <div class="sb-nav-link"><i class="fas fa-box"></i></div>
                            Dashboard
                        </a>
    
                        <a class="nav-link" href="employees.php">
                            <div class="sb-nav-link"><i class="fas fa-person"></i></div>
                            Employees
                        </a>
    
                        <a class="nav-link" href="reports.php">
                            <div class="sb-nav-link"><i class="fas fa-chart-line"></i></div>
                            Reports and Analytics
                        </a>

                        <a class="nav-link" href="tasks.php">
                            <div class="sb-nav-link"><i class="fas fa-tasks"></i></div>
                            Tasks
                        </a>
                        
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Admin
                </div>
            </nav>
        </div>
    </div>
