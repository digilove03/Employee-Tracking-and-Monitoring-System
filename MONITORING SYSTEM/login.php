<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #1d3557, #457b9d); /* Modern gradient */
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 30px;
            max-width: 400px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
        }
        .form-floating label {
            color: #ccc;
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .btn-primary {
            background: #f4a261;
            border: none;
        }
        .btn-primary:hover {
            background: #e76f51;
        }
        .logo-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        .logo-container img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            border-radius: 5px;
        }
        #loginMessage {
            color: #ff6b6b;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="img/cityLogo.png" alt="City Logo">
            <img src="img/dasmoLogo.png" alt="Dasmo Logo">
        </div>
        <h2 class="text-center mb-3">Login to Admin Panel</h2>
        <form id="loginForm">
            <div class="form-floating mb-3">
                <input class="form-control" id="username" name="username" type="text" placeholder="Username" required>
                <label for="username">USERNAME</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="password" name="password" type="password" placeholder="Password" required>
                <label for="password">PASSWORD</label>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">LOGIN</button>
            </div>
            <p id="loginMessage"></p>
        </form>
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
                    success: function(response) {
                        if (response.status === "success") {
                            window.location.href = "dashboard.php"; // Redirect
                        } else {
                            $("#loginMessage").text(response.message);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
