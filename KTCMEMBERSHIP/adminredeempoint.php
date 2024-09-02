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
if (isset($_POST['update'])) {
    $redeem_id = $_POST['redeem_id'];
    $new_redeemname = $_POST['redeemname'];
    $new_redeempoint = $_POST['redeempoint'];

    $servername = "localhost";
    $username = "id19727041_ktcmembership";
    $password = "Ktcmembership123$";
    $dbname = "id19727041_ktcwebsite";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a valid image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "File uploaded successfully.";

            // Update the database with new data and filename
            $image_filename = $_FILES["fileToUpload"]["name"]; // Get the uploaded filename
            $sql = "UPDATE redeemlist SET redeemname='$new_redeemname', redeempoint='$new_redeempoint', image_filename='$image_filename' WHERE id='$redeem_id'";
            
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully.";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    }

    $conn->close();
}



?>

<!DOCTYPE html>
<html>
<HEAD>
<TITLE>Redeem Point</TITLE>
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
      <a href="adminredeempoint.php" class="w3-bar-item w3-button w3-left">Redeem Point</i></a>
      <a href="admincoupon.php" class="w3-bar-item w3-button w3-left">Coupon</i></a>
      <a href="adminlogout.php" class="w3-bar-item w3-button w3-right">Logout</i></a> 
</div>

    

    
    <div>
        <h2>Redeem List</h2>
        <form method="post" action="" enctype="multipart/form-data">
        <table>
            <tr>
                <th>Redeem Name</th>
                <th>Redeem Point</th>
            </tr>
            
            <?php
            $servername = "localhost";
            $username = "id19727041_ktcmembership";
            $password = "Ktcmembership123$";
            $dbname = "id19727041_ktcwebsite";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT id, redeemname, redeempoint, image_filename FROM redeemlist";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<form method='post' action='' enctype='multipart/form-data'>";
echo "<td><input type='text' name='redeemname' value='" . $row["redeemname"] . "'></td>";
echo "<td><input type='text' name='redeempoint' value='" . $row["redeempoint"] . "'></td>";
echo "<td><input type='file' name='fileToUpload'></td>";
echo "<td><input type='hidden' name='redeem_id' value='" . $row["id"] . "'>";
echo "<input type='hidden' name='image_filename' value='" . $row["image_filename"] . "'>";
echo "<input type='submit' name='update' value='Update'></td>";
echo "</form>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No data available</td></tr>";
            }
            
            // Close the database connection
            $conn->close();
            ?>
        </table>
        </form>
    </div>
  <div>
        <h2>Customer Redeemed Items</h2>
        <table>
            <tr>
                <th>Gift Name</th>
                <th>Student Name</th>
                <th>KTC ID</th>
            </tr>
            
            <?php
            $servername = "localhost";
            $username = "id19727041_ktcmembership";
            $password = "Ktcmembership123$";
            $dbname = "id19727041_ktcwebsite";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $customerRedeemQuery = "SELECT cr.gift_name, cr.rec_id, m.studentname FROM customerredeem cr
                                    JOIN tbl_member m ON cr.rec_id = m.rec_id";
            $customerRedeemResult = $conn->query($customerRedeemQuery);
            
            if ($customerRedeemResult->num_rows > 0) {
                while ($row = $customerRedeemResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["gift_name"] . "</td>";
                    echo "<td>" . $row["studentname"] . "</td>";
                    echo "<td>" . $row["rec_id"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No data available</td></tr>";
            }
            
            // Close the database connection (if needed)
            $conn->close();
            ?>

        </table>
    </div>
</div>
  
</BODY>

</html>