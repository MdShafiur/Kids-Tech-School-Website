<?php
	if (session_start())
	{require_once "db_conn.php";}
	
	
	if (isset($_POST['adminlogin'])) {
		if (!empty($_POST['adminemail']) && !empty($_POST['password'])) {
			$adminemail = $_POST['adminemail'];
			$password = $_POST['password'];
			
			// Use prepared statements to prevent SQL injection
			$sql = "SELECT * FROM `adminlogin` WHERE `adminemail`=? AND `password`=? ";
			$query = $conn->prepare($sql);
			$query->execute(array($adminemail, $password));
			
			if ($query->rowCount() > 0) {
				$fetch = $query->fetch();
				$_SESSION['adminemail'] = $fetch['adminemail']; // Store the adminemail in the session, not 'id'
				header("location: adminhome.php");
				exit; // Ensure no further code execution after redirection
			} else {
				echo "<script>alert('Invalid username or password')</script>";
			}
		} else {
			echo "<script>alert('Please complete the required field!')</script>";
		}
	}
	?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
    <link href="assets/css/phppot-style.css" type="text/css" rel="stylesheet" />
    <link href="assets/css/user-registration.css" type="text/css" rel="stylesheet" />
    <script src="vendor/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <style>
        body {
            background-image: url('assets/img/DSC04733.jpg'); /* Replace 'path/to/your/image.jpg' with the actual path to your image */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .phppot-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .sign-up-container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .signup-heading {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
        }

        .input-box-330 {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .row {
            margin-bottom: 15px;
        }

        .btn {
            width: 100%;
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .previous {
            background-color: #f1f1f1;
            color: black;
            text-decoration: none;
            display: inline-block;
            padding: 8px 16px;
            border-radius: 4px;
        }

        .previous:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>

<body>
    <div class="phppot-container">
        <div class="sign-up-container">
            <div class="signup-align">
                <form action="adminlogin.php" method="POST">
                    <div class="signup-heading">Admin Login</div>
                    <div class="row">
                        <div class="inline-block">
                            <div class="form-label">
                                Admin Email<span class="required error" id="email-info"></span>
                            </div>
                            <input class="input-box-330" type="text" name="adminemail" id="email" placeholder="Email Address">
                        </div>
                    </div>
                    <div class="row">
                        <div class="inline-block">
                            <div class="form-label">
                                Password<span class="required error" id="login-password-info"></span>
                            </div>
                            <input class="input-box-330" type="password" name="password" id="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="row">
                        <input class="btn" type="submit" name="adminlogin" id="login-btn" value="Login">
                    </div>
                    <div class="row">
                        <a href="../index.php" class="previous">&laquo; Back to Homepage</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

