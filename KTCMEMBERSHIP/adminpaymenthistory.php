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
$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["update_status"]) && isset($_POST["purchase_id"])) {
    $purchaseId = $_POST["purchase_id"];
    $tableName = $_POST["table_name"]; // Add this line to get the table name

 // Update the payment status to 'complete'
$updateSql = "UPDATE $tableName SET payment_status = 'complete' WHERE id = ?";
$stmt = $conn->prepare($updateSql);
$stmt->bind_param("i", $purchaseId);
$stmt->execute();
$stmt->close();

// Fetch the rec_id of the completed purchase
$fetchRecIdQuery = "SELECT rec_id FROM $tableName WHERE id = ?";
$stmtFetchRecId = $conn->prepare($fetchRecIdQuery);
$stmtFetchRecId->bind_param("i", $purchaseId);
$stmtFetchRecId->execute();
$recId = $stmtFetchRecId->get_result()->fetch_assoc()['rec_id'];

// Update tbl_member with the new totalpointpurchase value after completing the purchase
$updateMemberPointsQuery = "UPDATE tbl_member SET totalpointpurchase = totalpointpurchase + (SELECT total_points FROM $tableName WHERE id = ?) WHERE rec_id = ? AND rec_id IN (SELECT rec_id FROM $tableName WHERE id = ?)";
$stmtUpdateMemberPoints = $conn->prepare($updateMemberPointsQuery);
$stmtUpdateMemberPoints->bind_param("iii", $purchaseId, $recId, $purchaseId);
$stmtUpdateMemberPoints->execute();


// Redirect back to the appropriate page based on the table name
if ($tableName === 'purchases') {
    header("Location: adminpaymenthistory.php");
}
exit();

}
?>

<!DOCTYPE html>
<html>
<HEAD>
<TITLE>Payment Details</TITLE><link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
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

.center-table {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
 .navbar {
    background: #ffffff;
    grid-area: nav;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 30px 0 30px;
    border-bottom: 1px solid lightgray;
    margin-left:0px; /* Adjust this value based on the width of your sidebar */
}

        .nav_icon>i {
            font-size: 26px;
            color: #a5aaad;
        }

        .navbar__left>a {
            margin-right: 30px;
            text-decoration: none;
            color: #a5aaad;
            font-size: 15px;
            font-weight: 700;
        }

        .navbar__left .active_link {
            color: #265acc;
            border-bottom: 3px solid #265acc;
            padding-bottom: 12px;
        }

        .navbar__right {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .navbar__right>a {
            margin-left: 20px;
            text-decoration: none;
        }

        .navbar__right>a>i {
            color: #a5aaad;
            font-size: 16px;
            border-radius: 50px;
            background: #ffffff;
            box-shadow: 2px 2px 5px #d9d9d9, -2px -2px 5px #ffffff;
            padding: 7px;
        }

        .navbar__left>a:hover {
            color: #265acc;
            border-bottom: 3px solid #265acc;
            padding-bottom: 12px;
            transition: color 0.3s ease, border-bottom 0.3s ease;
        }

</style>

</HEAD>
<body>
    <div class="container">
             <nav class="navbar">
        
        <div class="navbar__left">
        <a href="adminhome.php">Dashboard</a>  
          <a href="customerinfo.php">Subscribers</a>
          <a href="adminpaymenthistory.php">Subscription Management</a>
          <a href="adminhome.php">Admin</a>
        </div>
        <div class="navbar__right">
          <a href="#">
            <i class="fa fa-search" aria-hidden="true"></i>
          </a>
          <a href="#">
            <i class="fa fa-clock-o" aria-hidden="true"></i>
          </a>
          <a href="#">
            <img width="30" src="assets/avatar.svg" alt="" />
            <!-- <i class="fa fa-user-circle-o" aria-hidden="true"></i> -->
          </a>
        </div>
      </nav>
        <br>
        <div class="admin-welcome"><b>Payment Record</b></div><br>

        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search...">
            <select name="category">
                <option value="product">Product</option>
                <option value="exhibition">Exhibition</option>
                <option value="program">Program</option>
                <option value="class">Class</option>
            </select>
            <select name="criteria">
                <option value="rec_id">ID</option>
                <option value="studentname">Student Name</option>
                <option value="program">Program/Product Name</option>
                <option value="purchase_date">Purchase Date (YYYY-MM-DD)</option>
                <option value="payment_method">Payment Method</option>
            </select>
            <input type="submit" value="Search">
            <input type="button" value="Reset Filter" onclick="resetFilter()">
<br><br>
        </form>

        <?php
        if (isset($_GET["search"]) && isset($_GET["category"]) && isset($_GET["criteria"])) {
            // Sanitize input to prevent SQL injection
            $search = mysqli_real_escape_string($conn, $_GET["search"]);
            $category = mysqli_real_escape_string($conn, $_GET["category"]);
            $criteria = mysqli_real_escape_string($conn, $_GET["criteria"]);

            // Fetch data based on the selected category and criteria
            switch ($category) {
                case "product":
                    $table = "purchases";
                    $imageColumn = "image_filename";
                    $additionalCondition = ($criteria === 'quantity') ? "AND program LIKE '%$search%'" : "AND type = 'Product'";
                    break;
                case "exhibition":
                    $table = "purchases";
                    $imageColumn = "image_filename";
                    $additionalCondition = "AND type = 'Exhibition'";
                    break;
                case "program":
                    $table = "purchases";
                    $imageColumn = "image_filename";
                    $additionalCondition = "AND type = 'Steam Program'";
                    break;
                case "class":
                    $table = "purchases";
                    $imageColumn = "image_filename";
                    $additionalCondition = "AND type = 'Class'";
                    break;
                default:
                    $table = "";
                    $imageColumn = "";
                    $additionalCondition = "";
                    break;
            }                       

            if (!empty($table) && !empty($imageColumn)) {
                $query = "SELECT * FROM $table WHERE $criteria LIKE '%$search%' $additionalCondition ORDER BY purchase_date";
                $result = mysqli_query($conn, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    echo "<div class='center-table'>";
                    echo "<table border='1' style='margin: 0 auto;'>";

                    // Table headers
                    echo "<tr>";
                    echo "<th>Student ID</th>";
                    echo "<th>Student Name</th>";
                    echo "<th>Type</th>";
                    echo "<th>Program/Product Name</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Price per item (RM)</th>";
                    echo "<th>Point per item</th>";
                    echo "<th>Booking Time</th>";
                    echo "<th>Booking Date</th>";
                    echo "<th>Payment Method</th>";
                    echo "<th>Bank Name</th>";
                    echo "<th>Account Number</th>";
                    echo "<th>Payment Date and Time</th>";
                    echo "<th>Payment Receipt (File)</th>";
                    echo "<th>Payment Status</th>";
                    echo "<th>Subtotal Price (RM)</th>";
                    echo "<th>Action</th>"; // Added column for the action button
                    echo "</tr>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        // Table rows
                        echo "<tr>";
                        echo "<td>" . $row['rec_id'] . "</td>";
                        echo "<td>" . $row['studentname'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "<td>" . $row['program'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>" . $row['points'] . "</td>";
                        echo "<td>" . $row['booking_time'] . "</td>";
                        echo "<td>" . $row['booking_date'] . "</td>";
                        echo "<td>" . $row['payment_method'] . "</td>";
                        echo "<td>" . $row['bank_name'] . "</td>";
                        echo "<td>" . $row['account_number'] . "</td>";
                        echo "<td>" . $row['payment_datetime'] . "</td>";
                        echo "<td>";
                        if (!empty($row['image_filename'])) {
                            // Use the existing path in image_filename
                            $filePath = $row['image_filename'];
                            echo "<a href='$filePath' target='_blank'>";
                            echo "<img src='$filePath' alt='Product Image' style='width: 50px; height: 50px;'>";
                            echo "</a>";
                        }
                        echo "</td>";
                        echo "<td>" . $row['payment_status'] . "</td>";
                        echo "<td>" . $row['total_price'] . "</td>";
                       
                        echo "<td>";
                        if ($row['payment_status'] === 'pending') {
                            echo "<form method='post' action=''>";
                            echo "<input type='hidden' name='purchase_id' value='" . $row['id'] . "'>";
                            echo "<input type='hidden' name='table_name' value='$table'>";
                            echo "<button type='submit' name='update_status'>Mark as Complete</button>";
                            echo "</form>";
                        } else {
                            echo "Complete";
                        }
                        echo "</td>";

                        echo "</tr>";
                    }

                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>No records found.</p>";
                }
            }
        } else {
            // If no search parameters are provided, fetch all records from the table
            $table = "purchases";
            $query = "SELECT * FROM $table ORDER BY purchase_date DESC";
            $result = mysqli_query($conn, $query);
        
            if ($result && mysqli_num_rows($result) > 0) {
                echo "<div class='center-table'>";
                echo "<table border='1' style='margin: 0 auto;'>";
        
                // Table headers
                echo "<tr>";
                echo "<th>Student ID</th>";
                echo "<th>Student Name</th>";
                echo "<th>Type</th>";
                echo "<th>Program/Product Name</th>";
                echo "<th>Quantity</th>";
                echo "<th>Price per item (RM)</th>";
                echo "<th>Point per item</th>";
                echo "<th>Booking Time</th>";
                echo "<th>Booking Date</th>";
                echo "<th>Payment Method</th>";
                echo "<th>Bank Name</th>";
                echo "<th>Account Number</th>";
                echo "<th>Payment Date and Time</th>";
                echo "<th>Payment Receipt (File)</th>";
                echo "<th>Payment Status</th>";
                echo "<th>Subtotal Price (RM)</th>";
            
                echo "<th>Action</th>";
                echo "</tr>";
        
                // Loop through the records and display table rows
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['rec_id'] . "</td>";
                    echo "<td>" . $row['studentname'] . "</td>";
                    echo "<td>" . $row['type'] . "</td>";
                    echo "<td>" . $row['program'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['points'] . "</td>";
                    echo "<td>" . $row['booking_time'] . "</td>";
                    echo "<td>" . $row['booking_date'] . "</td>";
                    echo "<td>" . $row['payment_method'] . "</td>";
                    echo "<td>" . $row['bank_name'] . "</td>";
                    echo "<td>" . $row['account_number'] . "</td>";
                    echo "<td>" . $row['payment_datetime'] . "</td>";
                    echo "<td>";
                    if (!empty($row['image_filename'])) {
                        $filePath = $row['image_filename'];
                        echo "<a href='$filePath' target='_blank'>";
                        echo "<img src='$filePath' alt='Product Image' style='width: 50px; height: 50px;'>";
                        echo "</a>";
                    }
                    echo "</td>";
                    echo "<td>" . $row['payment_status'] . "</td>";
                    echo "<td>" . $row['total_price'] . "</td>";
                    
                    echo "<td>";
                    if ($row['payment_status'] === 'pending') {
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='purchase_id' value='" . $row['id'] . "'>";
                        echo "<input type='hidden' name='table_name' value='$table'>";
                        echo "<button type='submit' name='update_status'>Mark as Complete</button>";
                        echo "</form>";
                    } else {
                        echo "Complete";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
        
                // Close the table
                echo "</table>";
                echo "</div>";
            } else {
                echo "<p>No records found.</p>";
            }
        }
        
        ?>
        <script>
    function resetFilter() {
        // Redirect back to the initial adminpaymenthistory.php page state
        window.location.href = 'adminpaymenthistory.php';
    }
</script>


    </body>
    </html>