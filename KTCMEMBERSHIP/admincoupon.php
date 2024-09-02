<?php
session_start();

if (isset($_SESSION["adminemail"])) {
    $email = $_SESSION["adminemail"];
} else {
    session_unset();
    session_write_close();
    $url = "./validateadmin.php";
    header("Location: $url");
}

require 'db_conn.php';
?>

<!DOCTYPE html>
<html>
<HEAD>
<TITLE>Coupon</TITLE>
<link href="assets/css/phppot-style.css" type="text/css"
	rel="stylesheet" />
<link href="assets/css/user-registration.css" type="text/css"
	rel="stylesheet" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
}

.container {
  max-width: 1500px;
  margin: 0 auto;
  background-color: white;
  border-radius: 5px;
  box-shadow: 0px 0px 5px #888888;
  padding: 20px;
  text-align: center;
}

.page-header {
  margin-bottom: 20px;
}

.w3-bar {
  background-color: #4CAF50;
}

.w3-bar-item {
  padding: 12px;
  color: white;
  font-size: 16px;
}

.admin-welcome {
  font-size: 24px;
  margin-bottom: 10px;
}

.admin-name {
  font-weight: bold;
  font-size: 18px;
}
</style>

</HEAD>
<BODY>
  <div class="container">
    <div class="page-header">
        <nav class="w3-bar">
			<!--<a href="logout.php" class="w3-bar-item w3-button w3-right">Logout</a>-->
		</div>

    <div class="w3-bar w3-light-grey w3-border w3-large">
      <a href="adminhome.php" class="w3-bar-item w3-button w3-button w3-left">Home</i></a>
      <a href="adminpaymenthistory.php" class="w3-bar-item w3-button w3-left">Payment Info</i></a>
      <a href="customerinfo.php" class="w3-bar-item w3-button w3-left">Customer Info</i></a>
      <a href="adminsteamprogram.php" class="w3-bar-item w3-button w3-left">Program</i></a>
      <a href="adminproduct.php" class="w3-bar-item w3-button w3-left">Product</i></a>
      <a href="adminexhibition.php" class="w3-bar-item w3-button w3-left">Exhibition</i></a>
      <a href="adminclass.php" class="w3-bar-item w3-button w3-left">Class</i></a>
      <a href="admincoupon.php" class="w3-bar-item w3-button w3-left">Coupon</i></a>
      <a href="adminlogout.php" class="w3-bar-item w3-button w3-right">Logout</i></a> 
</div>

    <div>
  <h2>List of Coupons</h2>
  <table>
    <thead>
      <tr>
        <th>Coupon Code</th>
        <th>Discount (%)</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Perform the database query to fetch coupon data
      $sql = "SELECT coupon_code, discount_percentage FROM coupons";
      $result = $conn->query($sql);

      // Check if there are any results
      if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          // Iterate through the results and display each coupon
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row["coupon_code"]) . "</td>";
          echo "<td>" . htmlspecialchars($row["discount_percentage"]) . "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='2'>No coupons found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

    
  </div>
</BODY>

</html>