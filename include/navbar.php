<style>
    .nav-link {
        border-radius: 10px;
        margin: 10px;
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
    .sb-sidenav {
    background-color: #4682B4 !important; /* Steel Blue */
}

.sb-sidenav .nav-link {
    color: white;
}

.sb-sidenav .nav-link:hover {
    background-color: #5A9BD3; /* Lighter Steel Blue */
    color: white;
}
.sb-sidenav-footer {
    background-color: #36648B !important; /* Dark Steel Blue */
    color: white;
}
</style>

<?php 
    $current_page = basename($_SERVER['PHP_SELF']); 
?>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"><img class="logo" src="img/dasmoLogo.png" alt=""></div>
                    <br>
                    <a class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php">
                        <div class="sb-nav-link"><i class="fas fa-box"></i></div>
                        Dashboard
                    </a>

                    <a class="nav-link <?= ($current_page == 'employees.php') ? 'active' : '' ?>" href="employees.php">
                        <div class="sb-nav-link"><i class="fas fa-person"></i></div>
                        Employees
                    </a>

                    <a class="nav-link <?= ($current_page == 'tasks.php') ? 'active' : '' ?>" href="tasks.php">
                        <div class="sb-nav-link"><i class="fas fa-tasks"></i></div>
                        Tasks
                    </a>

                    <a class="nav-link <?= ($current_page == 'reports.php') ? 'active' : '' ?>" href="reports.php">
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
</div>
