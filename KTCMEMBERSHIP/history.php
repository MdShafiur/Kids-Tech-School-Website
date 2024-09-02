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
require 'tcpdf/tcpdf.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>History</title>
    <link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
    <link rel="stylesheet" href="assets/css/phppot-style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/user-registration.css" type="text/css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openReceipt(recId, rowIndex) {
            var win = window.open("generate_receipt.php?rec_id=" + recId + "&row_index=" + rowIndex, '_blank');
            win.focus(); 
        }
    </script>

<style>
    body {
    background-image: url('assets/img/DSC04988.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    color: #333;
    margin: 0;
    padding: 0;
}

.data-table {
    width: 80%;
    margin: 0 auto;
    border-collapse: collapse;
    margin-bottom: 20px;
    background-color: rgba(255, 255, 255, 0.7); /* Adjust the alpha (last) value for transparency */
}

.data-table th,
.data-table td {
    padding: 6px;
    text-align: center;
    border-bottom: 1px solid #000; /* Border at the bottom of each cell */
    border-right: 1px solid #000;  /* Border to the right of each cell */
    color: #333;
    font-weight: bold;
    white-space: nowrap;
}

.data-table td a.btn3 {
    display: inline-block;
    text-decoration: none;
    background-color: #fc7d28;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 2px;
}

.data-table td a.btn3:hover {
    background-color: #993d00;
    color: white;
}

    /* Navbar */
    nav {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        background-color: #4285f4; /* Blue background */
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
        transition: background-color 0.3s;
    }

    nav .navbar-brand {
        font-family: 'Lobster', cursive;
        font-size: 24px;
        color: #fff;
        transition: color 0.3s;
    }

    /* Navigation links */
    .navbar-nav {
        display: flex;
        gap: 10px;
    }

    .nav-item {
        font-size: 18px;
    }

    .nav-link {
        color: #fff !important;
        transition: color 0.3s;
        position: relative;
    }

    .nav-link:hover {
        color: #FFD700 !important; /* Gold color on hover */
    }

    .nav-link::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: #FFD700; /* Gold line */
        visibility: hidden;
        transform: scaleX(0);
        transition: all 0.3s ease-in-out;
    }

    .nav-link:hover::before {
        visibility: visible;
        transform: scaleX(1);
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
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
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

        .data-table td a.btn3 {
            display: inline-block;
            text-decoration: none;
            background-color: #fc7d28;
            color: white;
            padding: 6px 12px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 2px;
        }

        .data-table td a.btn3:hover {
            background-color: #993d00;
            color: white;
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
                padding: 3px;
                font-size: 10px;
                white-space: nowrap;
            }

            /* Dropdown content in the navigation bar */
            .w3-dropdown-content {
                position: absolute;
                background-color: #f9f9f9;
                min-width: 120px;
                z-index: 1;
            }

            .w3-dropdown-content a {
                padding: 3px;
                display: block;
                width: 100%;
                color: #000;
                text-decoration: none;
                font-size: 10px;
            }

            /* Page content */
            .page-content {
                padding: 5px;
                font-size: 12px;
            }
        }
    </style>

    <style>
        .show-purchases-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .purchase-details-heading {
    color: white;
}
    </style>
    
</HEAD>
<BODY>

<div class="content-wrapper">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
        <!-- Add a toggler button for small screens -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <!-- Navigation links -->
                <li class="nav-item">
                    <a href="home.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="personalinfo.php" class="nav-link">Personal Info</a>
                </li>
               <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="activitiesDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Activities Enrollment</a>
                    <ul class="dropdown-menu" aria-labelledby="activitiesDropdown">
                        <li><a href="exhibition.php" class="dropdown-item">Exhibition</a></li>
                        <li><a href="class.php" class="dropdown-item">Class</a></li>
                        <li><a href="steamprogram.php" class="dropdown-item">Steam Program</a></li>
                        <li><a href="product.php" class="dropdown-item">Product</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="redeempoint.php" class="nav-link">Redeem Point</a>
                </li>
                <li class="nav-item">
                    <a href="history.php" class="nav-link">History</a>
                </li>
            </ul>
            </div> 
        <?php 
      $cartItems = isset($_SESSION['cart_items']) ? $_SESSION['cart_items'] : [];
      $count = count($cartItems);

      ;
        
        ?>      
         <a class="navbar-brand d-flex align-items-center ms-sm-auto" href="cart.php">
            Cart <span class="badge bg-danger text-white position-relative" style="top: -5px;"><?php echo $count ?></span>

        </a>
        <!-- Logo and brand text -->
     <a class="navbar-brand d-flex align-items-center ms-sm-auto" href="logout.php">
            Logout
        </a>
    </div>
</nav>

    
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
    <br><h2 class="purchase-details-heading">Purchase Details</h2>

    <br>
    <button class="show-purchases-button" onclick="showPurchasesTable()">Show Purchases</button>
    <br>
    <br>
    <table class="data-table" id="purchases-table" style="display: none;">
        <!-- Table header -->
        <thead>
            <tr>
                <th>Type</th>
                <th>Program/Product</th>
                <th>Quantity</th> 
                <th>Price (RM)</th>
                <th>Points</th>                
                <th>Booking Time</th>
                <th>Booking Date</th>
                <th>Date/Time</th>	
                <th>Payment Method</th>	
                <th>Payment Status</th>	
                <th>Receipt</th> 
            </tr>
        </thead>
        <tbody>
        <?php
        $rowIndex = 0; // Initialize $rowIndex before the loop
        $sql = "SELECT * FROM purchases WHERE rec_id = '$recID' ORDER BY CAST(purchase_date AS DATETIME) DESC";
        $result = $conn->query($sql);        
        

        if ($result->num_rows > 0) {
            $purchaseDetails = array();
            $rowIndex = $result->num_rows - 1; // Start from the last index
        
            while ($row = $result->fetch_assoc()) {
                $purchaseId = $row["rec_id"];
                $type = $row["type"];
                $program = $row["program"];
                $quantity = $row["quantity"];
                $totalPrice = $row["total_price"];
                $totalPoints = $row["total_points"];
                $bookingTime = $row["booking_time"];
                $bookingDate = $row["booking_date"];
                $purchaseDate = $row["purchase_date"];
                $paymentMethod = $row["payment_method"];
                $paymentStatus = $row["payment_status"];
        
                echo "<tr>";
                echo "<td>$type</td>";
                echo "<td>$program</td>";
                echo "<td>$quantity</td>";
                echo "<td>$totalPrice</td>";
                echo "<td>$totalPoints</td>";
                echo "<td>$bookingTime</td>";
                echo "<td>$bookingDate</td>";
                echo "<td>$purchaseDate</td>";
                echo "<td>$paymentMethod</td>";
                echo "<td>$paymentStatus</td>";
        
                // Inside the loop where you generate buttons
                if ($row["payment_status"] == 'complete') {
                    // Display the Payment Approval Receipt button with the corresponding rec_id and row_index
                    echo "<td><a href='#' onclick='openReceipt(\"{$row['rec_id']}\", $rowIndex)' class='btn3'>Receipt</a></td>";
                } else {
                    echo "<td></td>";
                }
                $rowIndex--;
                echo "</tr>";
            }
            $_SESSION['purchaseDetails'] = $purchaseDetails;
        } else {
            echo "<tr><td colspan='11'>No purchase yet.</td></tr>";
        }
                ?>
        </tbody>
    </table><br><br><br><br><br><br>
</div>

<script>
    function showPurchasesTable() {
        var purchasesTable = document.getElementById("purchases-table");
        purchasesTable.style.display = (purchasesTable.style.display === "none") ? "table" : "none";
    }
</script>


</body>
</html>