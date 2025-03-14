<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Monitoring & Tracking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background: url('img/cityHall.png') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(8px); 
            background-color: rgba(255, 255, 255, 0.2); 
            z-index: -1;
        }
        .container-wrapper {
            display: flex;
            align-items: center;
            gap: 150px; 
        }
        .login-container {
            background: #1d3557;
            padding: 30px;
            border-radius: 10px;
            color: white;
        }
        .form-floating label {
            color: #333;
        }
        .form-control {
            background-color: white;
            color: black;
            border: 1px solid #1d3557;
            padding-right: 40px; 
        }
        .form-control::placeholder {
            color: rgba(79, 114, 228, 0.7);
        }
        .btn-primary {
            background:rgb(98, 177, 246);
            border: none;
        }
        .btn-primary:hover {
            background:rgb(81, 96, 231);
        }
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .logos {
            display: flex;
            justify-content: center;
            gap: 25px; 
            margin-bottom: 10px;
        }
        .logos img {
            width: 180px;
            height: 180px;
            object-fit: contain;
            border-radius: 5px;
        }
        .system-title {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }
        #loginMessage {
            color: #ff6b6b;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container-wrapper">
        <!-- Login Form -->
        <div class="login-container">
            <h2 class="text-center mb-3">Login to Admin Panel</h2> <br>
            <form id="loginForm">
                <div class="form-floating mb-3">
                    <input class="form-control" id="username" name="username" type="text" placeholder="Username" required>
                    <label for="username">USERNAME</label>
                </div> <br>
                <div class="form-floating mb-3 position-relative">
                    <input class="form-control" id="password" name="password" type="password" placeholder="Password" required>
                    <label for="password">PASSWORD</label>
                </div> <br>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">LOGIN</button>
                </div>
                <p id="loginMessage"></p>
            </form>
        </div>

        <!-- Logo Section -->
        <div class="logo-container">
            <div class="logos">
                <img src="img/cityLogo.png" alt="City Logo">
                <img src="img/dasmoLogo.png" alt="Dasmo Logo">
            </div> <br>
            <p class="system-title">EMPLOYEES MONITORING AND TRACKING SYSTEM</p>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#loginForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "authenticate.php",
                    data: $(this).serialize(),
                    dataType: "json",
                    contentType: "application/x-www-form-urlencoded",
                    success: function(response) {
                        if (response.status === "success") {
                            window.location.href = "dashboard.php"; 
                        } else {
                            $("#loginMessage").text(response.message).fadeIn();
                        }
                    },
                    error: function() {
                        $("#loginMessage").text("Error processing request.").fadeIn();
                    }
                });
            });
        });
    </script>
</body>
</html>
