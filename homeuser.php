<?php
session_start();
if (isset($_SESSION["rec_id"])) {
    $recID = $_SESSION["rec_id"];
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
<TITLE>History</TITLE>
<link href="assets/css/phppot-style.css" type="text/css"
	rel="stylesheet" />
<link href="assets/css/user-registration.css" type="text/css"
	rel="stylesheet" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
        .dataPoint {
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        .pointText {
            font-size: 18px;
            color: #333;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #333;
            font-weight: bold;
        }

        .data-table {
            border: 1px solid #ddd;
        }

        #exhibition-container,
        #steam-program-container {
            display: none;
        }
    </style>

<style>
    /* Dropdown container */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Dropdown button */
    .dropbtn {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    /* Dropdown content (hidden by default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    }
</style>
<style>
        /* Custom CSS for smaller screens (max-width: 400px) */
        @media (max-width: 400px) {
            /* Navbar */
            nav {
                display: flex;
                justify-content: center;
                padding: 5px;
                background-color: #333;
            }

            nav .navbar-brand {
                font-size: 12px;
            }

            /* Menu items in the navigation bar */
            .w3-bar-item {
                display: block;
                text-align: center;
                padding: 3px; /* Adjust padding for smaller screens */
                font-size: 10px; /* Make the font size smaller */
                white-space: nowrap; /* Prevent text from wrapping */
            }

            /* Dropdown content in the navigation bar */
            .w3-dropdown-content {
                position: absolute;
                background-color: #f9f9f9;
                min-width: 120px;
                z-index: 1;
            }

            .w3-dropdown-content a {
                padding: 3px; /* Adjust padding for smaller screens */
                display: block;
                width: 100%;
                color: #000;
                text-decoration: none;
                font-size: 10px; /* Make the font size smaller */
            }

            /* Page content */
            .page-content {
                padding: 5px;
                font-size: 12px; /* Make the font size slightly bigger for readability */
            }
        }
    </style>
</HEAD>
<BODY>


<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand ms-auto" href="logout.php">
      <img src="https://www.w3schools.com/bootstrap5/img_avatar1.png" alt="Logo" style="width:40px;" class="rounded-pill">
      <!--<?php echo $recID; ?>--><?php echo $_SESSION["emailstudent"]; ?>
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
            <h3>Hello <?php echo $recID; ?>! We're so glad you're here!</h3>
        </div>-->
        <!-- Navbar -->
<!--<div class="w3-top">-->
<div class="w3-bar w3-black w3-card">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="home.php" class="w3-bar-item w3-button w3-padding-large">HOME</a>
    <a href="personalinfo.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Personal Info</a>
    <div class="w3-dropdown-hover w3-hide-small">
      <button class="w3-padding-large w3-button" title="PersonalInfo">Activities Enrollment<i class="fa fa-caret-down"></i></button>     
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="exhibition.php" class="w3-bar-item w3-button">Exhibition</a>
        <a href="class.php" class="w3-bar-item w3-button">Class</a>
        <a href="steamprogram.php" class="w3-bar-item w3-button">Steam Program</a>
        <a href="product.php" class="w3-bar-item w3-button">Product</a>
      </div>
    </div>
    <a href="redeempoint.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Redeem Point</a>
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
    
    <?php
    $servername = "localhost";
    $username = "id19727041_ktcmembership";
    $password = "Ktcmembership123$";
    $dbname = "id19727041_ktcwebsite";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>

<div class="container">
    <br><h2>Purchase Details</h2>
    <div class="dropdown">
        <button class="dropbtn">Select Purchase Type</button>
        <div class="dropdown-content">
            <a href="#" onclick="showExhibitionTable()">Exhibition</a>
            <a href="#" onclick="showProductTable()">Product</a>
            <a href="#" onclick="showProgramTable()">Program</a>
            <a href="#" onclick="showClassTable()">Class</a>
        </div>
    </div>
    <br><br>
    <table class="data-table" id="exhibition-table" style="display: none;">
        <!-- Table header -->
        <thead>
            <tr>
                <th>Quantity</th>
                <th>Price</th>
                <th>Point</th>
                <th>Booking Time</th>
                <th>Booking Date</th>
                <th>Payment Method</th>
                <th>Purchase Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Retrieve exhibition_purchase details for the rec_id session
            $sql = "SELECT * FROM exhibition_purchase WHERE rec_id = '$recID'";
            $result = $conn->query($sql);

            // Check if there are any rows returned
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Access the details of each row
                    $quantity = $row["quantity"];
                    $price = $row["price"];
                    $point = $row["point"];
                    $bookingTime = $row["booking_time"];
                    $bookingDate = $row["booking_date"];
                    $filePath = $row["file_path"];
                    $paymentMethod = $row["payment_method"];
                    $purchaseDate = $row["purchase_date"];

                    // Output the row data in the table
                    echo "<tr>";
                    echo "<td>$quantity</td>";
                    echo "<td>RM$price</td>";
                    echo "<td>$point points</td>";
                    echo "<td>$bookingTime</td>";
                    echo "<td>$bookingDate</td>";
                    echo "<td>$paymentMethod</td>";
                    echo "<td>$purchaseDate</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No exhibition purchase yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <table class="data-table" id="product-table" style="display: none;">
    <!-- Table header -->
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Point</th>
            <th>Payment Method</th>
            <th>Purchase Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Retrieve product purchase details for the rec_id session
        $sql = "SELECT * FROM productpurchase WHERE rec_id = '$recID' ORDER BY purchase_date";
        $result = $conn->query($sql);

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            $previousDate = null;
            $firstRow = true;
            while ($row = $result->fetch_assoc()) {
                // Access the details of each row
                $productName = $row["product_name"];
                $price = $row["price"];
                $quantity = $row["quantity"];
                $point = $row["point"];
                $paymentMethod = $row["payment_method"];
                $purchaseDate = $row["purchase_date"];

                if ($previousDate !== $purchaseDate) {
                    // Output the row data in the table
                    if (!$firstRow) {
                        echo "</tr>"; // Close the previous row
                    }
                    echo "<tr>";
                    echo "<td>$productName</td>";
                    echo "<td>$quantity</td>";
                    echo "<td>RM$price</td>";
                    echo "<td>$point</td>";
                    echo "<td>$paymentMethod</td>";
                    echo "<td>$purchaseDate</td>";
                    echo "</tr>";
                    $firstRow = false;
                } else {
                    // Output the combined product details in a new row
                    echo "<tr>";
                    echo "<td>$productName</td>";
                    echo "<td>$quantity</td>";
                    echo "<td>RM$price</td>";
                    echo "<td>$point</td>";
                    echo "<td>$paymentMethod</td>";
                    echo "<td></td>"; // Empty cell for purchase date
                    echo "</tr>";
                }

                $previousDate = $purchaseDate;
            }

            // Close the last row
            echo "</tr>";
        } else {
            echo "<tr><td colspan='5'>No product purchase yet.</td></tr>";
        }
        ?>
    </tbody>
</table>


    <table class="data-table" id="program-table" style="display: none;">
        <!-- Table header -->
        <thead>
            <tr>
                <th>Program Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Point</th>
                <th>Payment Method</th>
                <th>Purchase Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Retrieve productpurchase details for the rec_id session
            $sql = "SELECT * FROM schoolprogrampurchase WHERE rec_id = '$recID'";
            $result = $conn->query($sql);

            // Check if there are any rows returned
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Access the details of each row
                    $programName = $row["program_name"];
                    $price = $row["price"];
                    $quantity = $row["quantity"];
                    $point = $row["point"];
                    $paymentMethod = $row["payment_method"];
                    $purchaseDate = $row["purchase_date"];

                    if ($previousDate !== $purchaseDate) {
                        // Output the row data in the table
                        if (!$firstRow) {
                            echo "</tr>"; // Close the previous row
                        }

                    // Output the row data in the table
                    echo "<tr>";
                    echo "<td>$programName</td>";
                    echo "<td>$quantity</td>";
                    echo "<td>RM$price</td>";
                    echo "<td>$point</td>";
                    echo "<td>$paymentMethod</td>";
                    echo "<td>$purchaseDate</td>";
                    echo "</tr>";
                    $firstRow = false;
                } else {
                    // Output the combined product details in a new row
                    echo "<tr>";
                    echo "<td>$programName</td>";
                    echo "<td>$quantity</td>";
                    echo "<td>RM$price</td>";
                    echo "<td>$point</td>";
                    echo "<td>$paymentMethod</td>";
                    echo "<td></td>"; // Empty cell for purchase date
                    echo "</tr>";
                }

                $previousDate = $purchaseDate;
            }

            // Close the last row
            echo "</tr>";
        } else {
            echo "<tr><td colspan='5'>No program purchase yet.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <table class="data-table" id="class-table" style="display: none;">
        <!-- Table header -->
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Point</th>
                <th>Payment Method</th>
                <th>Purchase Date</th>
            </tr>
        </thead>
        <tbody>
        <?php
// Retrieve productpurchase details for the rec_id session
$sql = "SELECT * FROM classpurchase WHERE rec_id = '$recID'";
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    $previousDate = null;
    $firstRow = true;

    while ($row = $result->fetch_assoc()) {
        // Access the details of each row
        $className = $row["class_name"];
        $price = $row["price"];
        $quantity = $row["quantity"];
        $point = $row["point"];
        $paymentMethod = $row["payment_method"];
        $purchaseDate = $row["purchase_date"];

        if ($previousDate !== $purchaseDate) {
            // Close the previous row if it exists
            if (!$firstRow) {
                echo "</tr>";
            }

            // Output the row data in the table
            echo "<tr>";
            echo "<td>$className</td>";
            echo "<td>$quantity</td>";
            echo "<td>RM$price</td>";
            echo "<td>$point</td>";
            echo "<td>$paymentMethod</td>";
            echo "<td>$purchaseDate</td>";
            echo "</tr>";
            $firstRow = false;
        } else {
            // Output the combined product details in a new row
            echo "<tr>";
            echo "<td>$className</td>";
            echo "<td>$quantity</td>";
            echo "<td>RM$price</td>";
            echo "<td>$point</td>";
            echo "<td>$paymentMethod</td>";
            echo "<td></td>"; // Empty cell for purchase date
            echo "</tr>";
        }

        $previousDate = $purchaseDate;
    }

    // Close the last row
    echo "</tr>";
} else {
    echo "<tr><td colspan='6'>No class purchase yet.</td></tr>";
}
?>

        </tbody>
    </table>
</div>

<script>
    function showExhibitionTable() {
        var exhibitionTable = document.getElementById("exhibition-table");
        var productTable = document.getElementById("product-table");
        var programTable = document.getElementById("program-table");
        var classTable = document.getElementById("class-table");

        exhibitionTable.style.display = "table";
        productTable.style.display = "none";
        programTable.style.display = "none";
        classTable.style.display = "none";
    }

    function showProductTable() {
        var exhibitionTable = document.getElementById("exhibition-table");
        var productTable = document.getElementById("product-table");
        var programTable = document.getElementById("program-table");
        var classTable = document.getElementById("class-table");

        exhibitionTable.style.display = "none";
        productTable.style.display = "table";
        programTable.style.display = "none";
        classTable.style.display = "none";
    }

    function showProgramTable() {
        var exhibitionTable = document.getElementById("exhibition-table");
        var programTable = document.getElementById("program-table");
        var productTable = document.getElementById("product-table");
        var classTable = document.getElementById("class-table");

        exhibitionTable.style.display = "none";
        productTable.style.display = "none";
        programTable.style.display = "table";
        classTable.style.display = "none";
    }

    function showClassTable() {
        var exhibitionTable = document.getElementById("exhibition-table");
        var programTable = document.getElementById("program-table");
        var productTable = document.getElementById("product-table");
        var classTable = document.getElementById("class-table");

        exhibitionTable.style.display = "none";
        productTable.style.display = "none";
        programTable.style.display = "none";
        classTable.style.display = "table";
    }
</script>

</body>
</html>