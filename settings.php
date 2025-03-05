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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            overflow: hidden;
         
        }
        .profile-container {
            background: white;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
            margin-top: 3px;
        }
        .profile-header {
            background: rgb(8, 49, 93);
            color: white;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            font-weight: bold;
        }
        .profile-pic-container {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 10px auto;
            border-radius: 10%;
            border: 3px solid #0056b3;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #f1f1f1;
         
        }
        .profile-pic-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .file-input {
            display: none; /* Hide default file input */
        }
        .change-btn {
            background: #ffcc00;
            border: none;
            padding: 6x 6px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
            display: block;
            margin: 10px auto;
        }
        .input-group {
            text-align: left;
            margin: 10px 0;
            font-size: 13px;
        }
        .input-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .input-field {
            width: 100%;
            padding: 4px;
            border: 1px solid #ccc;
            border-radius: 8px;  
            font-size: 14px;
            box-sizing: border-box; 
        }
        .footer {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        .footer button {
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
        }
        .cancel-btn {
            background: #dc3545;
            color: white;
            
        }
        .save-btn {
            background: #28a745;
            color: white;
        }
        .input-field[readonly] {
        background-color:rgb(200, 209, 217); 
        color: white; 
        cursor: not-allowed; 
        font-weight: bold;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <div><?php include 'include/header.php'; ?></div>
    <div id="layoutSidenav">
        <div><?php include 'include/navbar.php'; ?></div>
        <div id="layoutSidenav_content">
            
            <main>
                
                <div class="profile-container">
                    <div class="profile-header">EDIT MY PROFILE</div>
                    
                    <!-- Profile Picture -->
                    <div class="profile-pic-container">
                        <img id="profileImage" src="placeholder.png" alt="Profile Pic">
                    </div>
                    <button class="change-btn" onclick="document.getElementById('fileInput').click();">Change Picture</button>
                    <input type="file" id="fileInput" class="file-input" accept="image/*" onchange="previewImage(event)">

                    <!-- Profile Form -->
                    <form action="save_profile.php" method="POST" enctype="multipart/form-data">
                        <div class="input-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="input-field">
                        </div>
                        <div class="input-group">
                            <label for="department">Department</label>
                            <input type="text" id="department" name="department" class="input-field" readonly>
                        </div>
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="input-field">
                        </div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="input-field">
                        </div>

                        <!-- Buttons -->
                        <div class="footer">
                            <button type="button" class="cancel-btn" onclick="window.location.href='profile.php';">Cancel</button>
                            <button type="submit" class="save-btn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('profileImage');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
