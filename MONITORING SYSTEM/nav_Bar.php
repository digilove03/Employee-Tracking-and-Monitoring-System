<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side Nav</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
    </style>
</head>
<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading"><img class="logo" src="pictures/dasmoLogo.png" alt=""></div>
                        <br>
                        <a class="nav-link" href="index.html">
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
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

</body>
</html>