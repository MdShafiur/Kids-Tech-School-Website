<?php
session_start();
if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
} else {
    session_unset();
    session_write_close();
    $url = "./index.php";
    header("Location: $url");
}
?>

<!DOCTYPE html>
<HTML>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<HEAD>
<TITLE>Student Enrollment</TITLE>
<link href="assets/css/phppot-style.css" type="text/css"
	rel="stylesheet" />
<link href="assets/css/user-registration.css" type="text/css"
	rel="stylesheet" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</HEAD>
<BODY>


<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand ms-auto" href="logout.php">
      <img src="https://www.w3schools.com/bootstrap5/img_avatar1.png" alt="Logo" style="width:40px;" class="rounded-pill">
      <?php echo $email; ?>
    </a>
  </div>
</nav>
	<!--<div class="phppot-container">-->
   <!-- <div class="page-header">
        <nav class="w3-bar w3-red">
			<span class="login-signup">--><!--<a href="logout.php" class="w3-button w3-bar-item">Logout</a></span>
		</div>-->
		<!--<div class="page-content">
            <h2>Welcome to our awesome website!</h2>
            <h3>Hello <?php echo $email; ?>! We're so glad you're here!</h3>
        </div>-->
        <!-- Navbar -->
<!--<div class="w3-top">-->
  <div class="w3-bar w3-black w3-card">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="home.php" class="w3-bar-item w3-button w3-padding-large">HOME</a>
    <a href="personalinfo.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Personal Info</a>
    <a href="redeempoint.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Redeem Point</a>
    <div class="w3-dropdown-hover w3-hide-small">
      <button class="w3-padding-large w3-button" title="PersonalInfo">Activities Enrollment<i class="fa fa-caret-down"></i></button>     
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="exhibition.php" class="w3-bar-item w3-button">Exhibition</a>
        <a href="class.php" class="w3-bar-item w3-button">Class</a>
        <a href="steamprogram.php" class="w3-bar-item w3-button">Steam Program</a>
        <a href="product.php" class="w3-bar-item w3-button">Product</a>
      </div>
    </div>
    <a href="history.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">History</a>
    <!--<a href="javascript:void(0)" class="w3-padding-large w3-hover-red w3-hide-small w3-right"><i class="fa fa-search"></i></a>-->
  </div>
<!--</div>-->
    <!--<nav class="w3-bar w3-green">
        <a href="home.php" class="w3-button w3-bar-item">Home</a>
        <a href="enrollment.php" class="w3-button w3-bar-item">Personal Info</a>
        <a href="enrollment.php" class="w3-button w3-bar-item">Enrollment</a>
        <a href="redeempoint.php" class="w3-button w3-bar-item">Redeem Points</a>
    </nav>-->
</BODY>
</HTML>