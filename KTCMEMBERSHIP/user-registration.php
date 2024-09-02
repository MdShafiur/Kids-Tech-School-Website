<?php
use ktc\Member;
if (! empty($_POST["signup-btn"])) {
    require_once './Model/Member.php';
    $member = new Member();
    $registrationResponse = $member->registerMember();
}
?>
<HTML>
<HEAD>
<TITLE>User Registration</TITLE><link rel="shortcut icon" href="assets/img/logo.svg" type="image/svg">
<link href="assets/css/phppot-style.css" type="text/css"
	rel="stylesheet" />
<link href="assets/css/user-registration.css" type="text/css"
	rel="stylesheet" />
<script src="vendor/jquery/jquery-3.3.1.js" type="text/javascript"></script>
<style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-image: url("path/to/your/background-image.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
        .phppot-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
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
			margin: auto;
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
		.wide-signup-container{
    		width: 90%;
  		}
  		
  		.row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}


.input-box-330 {
    
    flex: 0 0 calc(33.33% - 10px); 
}
.row.two-input-row .input-box-330 {
    flex: 0 0 calc(50% - 10px); 
}
.row:last-child {
    justify-content: center;
}

.row:last-child .btn {
    flex: 0 0 auto; 
}
    </style>
</HEAD>
<BODY>
	<div class="phppot-container">
		<div class="sign-up-container wide-signup-container">
			<div class="login-signup">
				<a href="index.php">Login</a>
			</div>
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
					<div class="row">
						
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
					<div class="row two-input-row">
						
							<div class="form-label">
								<span class="required error" id="parentname-info"></span>
							</div>
							<input class="input-box-330" type="text" name="parentname" id="parentname" placeholder="Parent Name">
						
					
							<div class="form-label">
								<span class="required error" id="email-info"></span>
							</div>
							<input class="input-box-330" type="email" name="email" id="email" placeholder="Parent Email">
					
					
							
						
					</div>
					<div class="row two-input-row">
						
							<div class="form-label">
								<span class="required error" id="schoolname-info"></span>
							</div>
							<input class="input-box-330" type="text" name="schoolname" id="schoolname" placeholder="School Name">
							
							<div class="form-label">
								<span class="required error" id="address-info"></span>
							</div>
							<input class="input-box-330" type="text" name="address" id="address" placeholder="Address">
						
					</div>
					<center><div class="row">
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
					<div class="row">
						<input class="btn" type="submit" name="signup-btn"
							id="signup-btn" value="Sign up">
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
function signupValidation() {
	var valid = true;

	$("#username").removeClass("error-field");
	$("#email").removeClass("error-field");
	$("#emailstudent").removeClass("error-field");
	$("#parentname").removeClass("error-field");
	$("#studentname").removeClass("error-field");
	$("#address").removeClass("error-field");
	$("#schoolname").removeClass("error-field");
	$("#birthdate").removeClass("error-field");   // Add this line
	$("#password").removeClass("error-field");
	$("#confirm-password").removeClass("error-field");
	

	var UserName = $("#username").val();
	var email = $("#email").val();
	var EmailStudent = $("#emailstudent").val();
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
   
    

	$("#username-info").html("").hide();
	$("#email-info").html("").hide();
	$("#emailstudent-info").html("").hide();
	$("#parentname-info").html("").hide();
	$("#studentname-info").html("").hide();
	$("#address-info").html("").hide();
	$("#schoolname-info").html("").hide();
	$("#age-info").html("").hide();
	$("#birthdate-info").html("").hide();

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
	if (EmailStudent == "") {
		$("#emailstudent-info").html("required").css("color", "#ee0000").show();
		$("#emailstudent").addClass("error-field");
		valid = false;
	} else if (EmailStudent.trim() == "") {
		$("#emailstudent-info").html("Invalid email address.").css("color", "#ee0000").show();
		$("#emailstudent").addClass("error-field");
		valid = false;
	} else if (!emailRegex1.test(EmailStudent)) {
		$("#emailstudent-info").html("Invalid email address.").css("color", "#ee0000")
				.show();
		$("#emailstudent").addClass("error-field");
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
</BODY>
</HTML>
