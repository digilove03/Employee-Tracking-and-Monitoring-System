<?php include 'include/scripts.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>MONITORING</title>
    <style>
        body {
            font-family: Arial, sans-serif;
           
            color: white;
        }
        .container {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 50px;
        }
        .card {
            background-color: white;
            color: black;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .profile-card {
            width: 450px; /* Adjusted */
        }
        .account-card {
            width: 450px; /* Adjusted */
        }
        .card-header {
            background-color:rgb(10, 105, 139);
            padding: 10px;
            font-weight: bold;
            border-radius: 5px 5px 0 0;
        }
        .profile-picture img {
            width: 120px; /* Adjusted */
            height: 120px;
            border-radius: 50%;
            display: block;
            margin: 15px auto;
        }
        .profile-picture input {
            display: block;
            margin: 10px auto;
            width: 80%;
        }
        .profile-picture button {
            display: block;
            background-color: #f4c542;
            border: none;
            padding: 7px 12px;
            margin: 10px auto;
            cursor: pointer;
            border-radius: 5px;
        }
        .account-form label {
            display: block;
            margin-top: 10px;
        }
        .account-form input {
            width: 100%;
            padding: 7px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .update-btn {
            background-color: #4da8da;
            border: none;
            padding: 7px 12px;
            cursor: pointer;
            color: white;
            border-radius: 5px;
        }
        .password-btn {
            background-color: #d9534f;
            border: none;
            padding: 7px 12px;
            cursor: pointer;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <div><?php include 'include/header.php'; ?></div>
    <div id="layoutSidenav">
        <div><?php include 'include/navbar.php'; ?></div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container">
                    <!-- Change Profile Picture -->
                    <div class="card profile-card">
                        <div class="card-header">&#128247; CHANGE PROFILE PICTURE</div>
                        <div class="profile-picture">
                            <img src="https://via.placeholder.com/120" alt="Profile Picture">
                            <input type="file">
                            <button>Change</button>
                        </div>
                    </div>
                    <!-- Edit My Account -->
                    <div class="card account-card">
                        <div class="card-header">&#9998; EDIT MY ACCOUNT</div>
                        <div class="account-form">
                            <label>Name</label>
                            <input type="text" value="">
                            <label>Username</label>
                            <input type="text" value="">
                            <div class="buttons">
                                <button class="update-btn">Update</button>
                                <button class="password-btn">Change Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
