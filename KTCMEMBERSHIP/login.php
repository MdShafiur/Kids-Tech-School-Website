<?php
use ktc\Member;

// Registration Form Submission
if (!empty($_POST["signup-btn"])) {
    require_once './Model/Member.php';
    $member = new Member();
    $registrationResponse = $member->registerMember();
}

// Login Form Submission
if (!empty($_POST["login-btn"])) {
    require_once __DIR__ . '/Model/Member.php';
    $member = new Member();
    $loginResult = $member->loginMember();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title><link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
	<link href="assets/css/phppot-style.css" type="text/css" rel="stylesheet"/>
	<link href="assets/css/user-registration.css" type="text/css" rel="stylesheet"/>
	<script src="vendor/jquery/jquery-3.3.1.js" type="text/javascript"></script>
	<script>
        // JavaScript code for handling the popup behavior
        document.getElementById("open-registration-popup").addEventListener("click", function() {
            document.getElementById("registration-popup-overlay").style.display = "block";

            // Clear any previous error messages
            document.getElementById("error-msg").innerHTML = "";
        });

        // Function to close the registration popup
        function closePopup() {
            document.getElementById("registration-popup-overlay").style.display = "none";
        }

        // Function to close the popup when the close button is clicked
        document.querySelector(".close-btn").addEventListener("click", function() {
            closePopup();
        });

        // Function to display the error message in the popup
        function displayErrorMessage(message) {
            document.getElementById("error-msg").innerHTML = message;
        }

        // Check if registration was successful before closing the popup
        <?php if(!empty($registrationResponse) && $registrationResponse["status"] === "success") { ?>
            closePopup();
        <?php } ?>
    </script>
	<style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-image: url("assets/img/1-04.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
        .phppot-container {
            position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            text-align:center;
        }
        .signup-align {
            display: flex;
            justify-content: center;
        }
        .error-msg {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .form-label {
            margin-bottom: 5px;
        }
        .input-box-330 {
            width: 330px;
            height: 40px;
            padding: 5px;
            border-radius: 5px;
            border: none;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #3e8e41;
        }
        .error-field {
            border: 1px solid red;
        }
        .required {
            font-size: 14px;
        }
        .user-registration{
	        margin: 10px;
	        text-decoration: none;
	        float: right;
        }
        .user-registration a {
	        text-decoration: none;
	        font-weight: 700;
        }
        .registration-heading {
	        font-size: 2em;
	        font-weight: bold;
	        padding-top: 60px;
	        text-align: center;
        }
    </style>
    <style>
        .popup-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    z-index: 9999;
}

.popup-container {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    border-radius: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    padding: 20px;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    width: 30px; /* Adjust the width as per your preference */
    height: 30px; /* Adjust the height as per your preference */
    font-size: 24px; /* Adjust the font size to control the size of the 'x' symbol */
    display: flex;
    align-items: center;
    justify-content: center;
}

    </style>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-image: url("assets/img/1-04.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
        .phppot-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
			margin: auto;
        }
        .signup-align {
            display: flex;
            justify-content: center;
        }
        .error-msg {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .form-label {
            margin-bottom: 5px;
        }
        .input-box-330 {
            width: 330px;
            height: 40px;
            padding: 5px;
            border-radius: 5px;
            border: none;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);
			
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #3e8e41;
        }
        .btn1 {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn1:hover {
            background-color: #3e8e41;
        }
        .error-field {
            border: 1px solid red;
        }
        .required {
            font-size: 14px;
        }
		.wide-signup-container{
    		width: 90%;
			margin: auto;
  		}
  		
  		.row-signup {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}


.input-box-330 {
    
    flex: 0 0 calc(33.33% - 10px); 
}
.row-signup.two-input-row .input-box-330 {
    flex: 0 0 calc(50% - 10px); 
}
.row-signup:last-child {
    justify-content: center;
}

.row-signup:last-child .btn {
    flex: 0 0 auto; 
}

</style>
</head>
<body>
	<div class="phppot-container">
		<div class="sign-up-container">
            <div class="user-registration">
				
			</div>
            <div class="">
				<form name="login" action="" method="post" onsubmit="return loginValidation()">
					<div class="signup-heading">Login</div>
					<?php if(!empty($loginResult)){ ?>
					<div class="error-msg"><?php echo $loginResult; ?></div>
					<?php } ?>
					<div class="row">
						<div class="inline-block">
						<div class="form-label">Username<span class="required error" id="rec_id-info"></span></div>
							<input class="input-box-330" type="text" name="username" id="rec_id">
						</div>
					</div>
					<div class="row">
						<div class="inline-block">
							<div class="form-label">Password<span class="required error" id="login-password-info"></span></div>
							<input class="input-box-330" type="password" name="login-password" id="login-password"><br><br>
							<a href="forgot-password.php">Forgot password?</a>
							<input type="checkbox" onclick="showPassword()">Show Password
						</div>
					</div>
					<div class="row">
						<input class="btn" type="submit" name="login-btn" id="login-btn" value="Login">
					</div>
				</form>
				<div class="row1">
						<input class="btn1" type="button" button id="open-registration-popup" value="Sign Up">
					</div>
					<div class="row2">
						<a href="../index.php" class="previous" style="text-decoration: none; display: inline-block; padding: 8px 16px; background-color: #f1f1f1; color: black; ">&laquo; Back to Homepage</a>
</div>
			</div>
		</div>
	</div>
<div id="registration-popup-overlay" class="popup-overlay">
    <div class="phppot-container">
        	<span class="close-btn" onclick="closePaymentForm()">&times;</span>
		<div class="sign-up-container wide-signup-container">
        <div class="">
				<form name="sign-up" action="" method="post"
					onsubmit="return signupValidation()">
					<div class="signup-heading">Registration</div>
				<?php
    if (! empty($registrationResponse["status"])) {
        ?>
                    <?php
        if ($registrationResponse["status"] == "error") {
            ?>
				    <div class="server-response error-msg"><?php echo $registrationResponse["message"]; ?></div>
                    <?php
        } else if ($registrationResponse["status"] == "success") {
            ?>
                    <div class="server-response success-msg"><?php echo $registrationResponse["message"]; ?></div>
                    <?php
        }
        ?>
				<?php
    }
    ?>
	
				<div class="error-msg" id="error-msg"></div>
					<div class="row-signup">
						
							<div class="form-label">
								<span class="required error" id="username-info"></span>
							</div>
							<input class="input-box-330" type="text" name="username"
								id="username" placeholder="Username">
						
						    
						    <div class="form-label">
								<span class="required error" id="studentname-info"></span>
							</div>
							<input class="input-box-330" type="text" name="studentname" id="studentname" placeholder="Student Name">
					
							<div class="form-label">
								
							</div>
							<input class="input-box-330" type="email" name="emailstudent" id="emailstudent" placeholder="Student Email (Optional)">
					</div>
					<div class="row-signup">
						
							<div class="form-label">
								<span class="required error" id="parentname-info"></span>
							</div>
							<input class="input-box-330" type="text" name="parentname" id="parentname" placeholder="Parent Name">
						
					
							<div class="form-label">
								<span class="required error" id="email-info"></span>
							</div>
							<input class="input-box-330" type="email" name="email" id="email" placeholder="Parent Email">
					
					        <div class="form-label">
								<span class="required error" id="telephone-info"></span>
							</div>
							<input class="input-box-330" type="tel" name="telephone" id="telephone" placeholder="Phone Number">
							
						
					</div>
					<div class="row-signup two-input-row">
						
							<div class="form-label">
								<span class="required error" id="schoolname-info"></span>
							</div>
							<input class="input-box-330" type="text" name="schoolname" id="schoolname" placeholder="School Name">
							
							<div class="form-label">
								<span class="required error" id="address-info"></span>
							</div>
							<input class="input-box-330" type="text" name="address" id="address" placeholder="Address">
						
					</div>
					<center><div class="row-signup">
					<div class="form-label">
                        <span class="required error" id="birthdate-info"></span>
                    </div>
                    <input class="input-box-330" type="text" name="birthdate" id="birthdate" placeholder="Date of Birth" onfocus="(this.type='date')">	
					
							<div class="form-label">
								<span class="required error" id="signup-password-info"></span>
							</div>
							<input class="input-box-330" type="password"
								name="signup-password" id="signup-password" placeholder="Password">
						
					
						
							<div class="form-label">
								<span class="required error"
									id="confirm-password-info"></span>
							</div>
							<input class="input-box-330" type="password"
								name="confirm-password" id="confirm-password" placeholder="Confirm Password">
						
					</div> </center>
					<div class="row-signup">
						<input class="btn" type="submit" name="signup-btn"
							id="signup-btn" value="Sign up">
					</div>

				</form>
			</div>
    </div>
</div>
<script>
    // JavaScript code for handling the popup behavior
    document.getElementById("open-registration-popup").addEventListener("click", function() {
        document.getElementById("registration-popup-overlay").style.display = "block";
    });

    // Function to close the registration popup
    function closePopup() {
        document.getElementById("registration-popup-overlay").style.display = "none";
    }

    // Function to close the popup when the close button is clicked
    document.querySelector(".close-btn").addEventListener("click", function() {
        closePopup();
    });
</script>
<script>
function showPassword() {
  var x = document.getElementById("login-password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
<script>
function signupValidation() {
	var valid = true;

	$("#username").removeClass("error-field");
	$("#email").removeClass("error-field");
	$("#parentname").removeClass("error-field");
	$("#studentname").removeClass("error-field");
	$("#address").removeClass("error-field");
	$("#schoolname").removeClass("error-field");
	$("#birthdate").removeClass("error-field");   // Add this line
    $("#telephone").removeClass("error-field");// Add this line
	$("#password").removeClass("error-field");
	$("#confirm-password").removeClass("error-field");
	

	var UserName = $("#username").val();
	var email = $("#email").val();
	var ParentName = $("#parentname").val();
	var StudentName = $("#studentname").val();
	var Address = $("#address").val();
	var SchoolName = $("#schoolname").val();
	var Age = $("#age").val();
	var Password = $('#signup-password').val();
    var ConfirmPassword = $('#confirm-password').val();
	var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
	var emailRegex1 = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
	var Birthdate = $("#birthdate").val();
    var Telephone = $("#telephone").val();
    

	$("#username-info").html("").hide();
	$("#email-info").html("").hide();
	$("#parentname-info").html("").hide();
	$("#studentname-info").html("").hide();
	$("#address-info").html("").hide();
	$("#schoolname-info").html("").hide();
	$("#age-info").html("").hide();
	$("#birthdate-info").html("").hide();
    $("#telephone-info").html("").hide();

	if (UserName.trim() == "") {
		$("#username-info").html("required.").css("color", "#ee0000").show();
		$("#username").addClass("error-field");
		valid = false;
	}
	if (email == "") {
		$("#email-info").html("required").css("color", "#ee0000").show();
		$("#email").addClass("error-field");
		valid = false;
	} else if (email.trim() == "") {
		$("#email-info").html("Invalid email address.").css("color", "#ee0000").show();
		$("#email").addClass("error-field");
		valid = false;
	} else if (!emailRegex.test(email)) {
		$("#email-info").html("Invalid email address.").css("color", "#ee0000")
				.show();
		$("#email").addClass("error-field");
		valid = false;
	}
	if (Password.trim() == "") {
		$("#signup-password-info").html("required.").css("color", "#ee0000").show();
		$("#signup-password").addClass("error-field");
		valid = false;
	}
	if (ConfirmPassword.trim() == "") {
		$("#confirm-password-info").html("required.").css("color", "#ee0000").show();
		$("#confirm-password").addClass("error-field");
		valid = false;
	}
	if(Password != ConfirmPassword){
        $("#error-msg").html("Both passwords must be same.").show();
        valid=false;
    }
	if (valid == false) {
		$('.error-field').first().focus();
		valid = false;
	}
	if (ParentName == "") {
		$("#parentname-info").html("required").css("color", "#ee0000").show();
		$("#parentname").addClass("error-field");
		valid = false;
	}
	if (StudentName == "") {
		$("#studentname-info").html("required").css("color", "#ee0000").show();
		$("#studentname").addClass("error-field");
		valid = false;
	}
	if (Address == "") {
		$("#address-info").html("required").css("color", "#ee0000").show();
		$("#address").addClass("error-field");
		valid = false;
	}
	if (SchoolName == "") {
		$("#schoolname-info").html("required").css("color", "#ee0000").show();
		$("#schoolname").addClass("error-field");
		valid = false;
	}
	if (Birthdate == "") {
        $("#birthdate-info").html("required").css("color", "#ee0000").show();
        valid = false;
    }
    if (Telephone.trim() == "") {
    $("#telephone-info").html("required").css("color", "#ee0000").show();
    $("#telephone").addClass("error-field");
    valid = false;
}
	
	return valid;
}
</script>

<script>
document.getElementById("open-registration-popup").addEventListener("click", function() {
    document.getElementById("registration-popup-overlay").style.display = "block";
});

function closePopup() {
    document.getElementById("registration-popup-overlay").style.display = "none";
}
</script>

	<script>
		function loginValidation() {
			var valid = true;
			$("#rec_id").removeClass("error-field");
			$("#password").removeClass("error-field");

			var recID = $("#rec_id").val();
			var Password = $('#login-password').val();

			$("#username-info").html("").hide();

			if (recID.trim() == "") {
				$("#rec_id-info").html("required.").css("color", "#ee0000").show();
				$("#rec_id").addClass("error-field");
				valid = false;
			}
			if (Password.trim() == "") {
				$("#login-password-info").html("required.").css("color", "#ee0000").show();
				$("#login-password").addClass("error-field");
				valid = false;
			}
			if (valid == false) {
				$('.error-field').first().focus();
				valid = false;
			}
			return valid;
		}

		var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();

if (dd < 10) {
   dd = '0' + dd;
}

if (mm < 10) {
   mm = '0' + mm;
} 
    
today = yyyy + '-' + mm + '-' + dd;
document.getElementById("birthdate").setAttribute("max", today);
	</script>
</body>
</html>
