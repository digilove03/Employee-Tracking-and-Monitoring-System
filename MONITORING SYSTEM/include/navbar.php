<nav class="sb-topnav navbar navbar-expand navbar-dark" id="topNavBG">
    <a class="navbar-brand ps-3" href="index.php">Employee Monitoring</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    <span class="top_nav_space"></span>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Activity Log</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="#">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"><img class="logo" src="img/dasmoLogo.png" alt=""></div>
                    <br>
                    <a class="nav-link" id="linkBG" href="dashboard.php"><i class="fas fa-box"></i> Dashboard</a>
                    <a class="nav-link" href="employees.php"><i class="fas fa-person"></i> Employees</a>
                    <a class="nav-link" href="tasks.php"><i class="fas fa-clip"></i> Tasks</a>
                    <a class="nav-link" href="reports.php"><i class="fas fa-chart-line"></i> Reports and Analytics</a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Admin
            </div>
        </nav>
    </div>
</div>