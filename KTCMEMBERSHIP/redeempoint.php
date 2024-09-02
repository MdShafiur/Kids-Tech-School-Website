<?php
session_start();
if (isset($_SESSION["rec_id"])) {
    $recID = $_SESSION["rec_id"];
} else {
    session_unset();
    session_write_close();
    $url = "./index.php";
    header("Location: $url");
    exit();
}
$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$overallPoints = 0;

// Retrieve points from purchases table using SUM
$classPurchaseQuery = "SELECT totalpointpurchase FROM tbl_member WHERE rec_id = '$recID'";
$classPurchaseResult = $conn->query($classPurchaseQuery);
if (!$classPurchaseResult) {
    echo "Error retrieving purchase points: " . $conn->error;
} else {
    $classPurchaseRow = $classPurchaseResult->fetch_assoc();
    if ($classPurchaseRow) {
        $overallPoints = intval($classPurchaseRow['totalpointpurchase']);
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Redeem Point</title>
    <link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
    <link href="assets/css/phppot-style.css" type="text/css" rel="stylesheet" />
    <link href="assets/css/user-registration.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-image: url('https://source.unsplash.com/1920x1080/?abstract');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #fff;
            overflow: hidden;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }

        h2, h3, p {
            color: #ffd700;
        }

        form {
            margin-top: 20px;
        }

        .redeem-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .redeem-point-container {
            font-size: 18px;
            color: #ffd700;
            margin-right: 20px;
            flex: 1;
        }

        .redeem-image-container {
            max-width: 150px;
            height: auto;
            border-radius: 10px;
           
        }

        .redeem-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
            transform: rotate(10deg);
            transition: transform 0.3s;
        }

        .redeem-image:hover {
            transform: rotate(-10deg);
        }

        .btn-primary {
            background-color: #ffd700;
            border-color: #ffd700;
            font-size: 16px;
            padding: 10px 20px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #cca300;
            border-color: #cca300;
        }

        .sticky-overlay {
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #5A5A5A;
            color: #ff0000;
            padding: 20px;
            text-align: center;
            z-index: 1000;
            transition: background-color 0.3s, color 0.3s;
            animation: pulse 1.5s infinite;
        }

        .gotoclass {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .gotoclass:hover {
            background-color: #0056b3;
        }

        .content-wrapper {
            display: flex;
            flex-direction: column;
            max-height: auto;
            box-sizing: border-box;
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
</head>
<body>
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
<div class="container mt-4">
    <h2>Redeem Point</h2>
    <p><b>Overall Total Points:</b> <?php echo $overallPoints; ?></p>
    
    <form action="redeem_process.php" method="post" onsubmit="return checkPoints();">
        <?php
        // Establish a new database connection for retrieving redeemlist
        $redeemConn = new mysqli($servername, $username, $password, $dbname);

        if ($redeemConn->connect_error) {
            die("Redeem Connection failed: " . $redeemConn->connect_error);
        }

        $redeemListQuery = "SELECT redeemname, redeempoint, image_filename FROM redeemlist";
        $redeemListResult = $redeemConn->query($redeemListQuery);
        
        if ($redeemListResult && $redeemListResult->num_rows > 0) {
            while ($row = $redeemListResult->fetch_assoc()) {
                $giftName = $row['redeemname'];
                $redeemPoint = $row['redeempoint'];
                $giftImage = $row['image_filename'];
        ?>
        <div class="form-check">
            <div class="redeem-item">
                <input type="checkbox" class="form-check-input" id="<?php echo $giftName; ?>" name="gift[]" value="<?php echo $giftName; ?>" data-redeem-points="<?php echo $redeemPoint; ?>">
                <label class="form-check-label" for="<?php echo $giftName; ?>"><?php echo $giftName; ?></label>
            </div>

            <div class="redeem-point-container">
                Redeem Points: <?php echo $redeemPoint; ?>
            </div>
            
            <div class="redeem-image-container">
                <img src="uploads/<?php echo $giftImage; ?>" alt="<?php echo $giftName; ?>" class="redeem-image">
            </div>
        </div>
        <?php
            }
        }

        // Close the redeem connection
        $redeemConn->close();
        ?>
        <br>
        <div><button type="submit" id="submitBtn" class="btn btn-primary mt-3">Redeem</button></div>
<br>
    </form>
<h3>Your Redeemed Items</h3>
    <ul>
        <?php
                $servername = "localhost";
        $username = "id19727041_ktcmembership";
        $password = "Ktcmembership123$";
        $dbname = "id19727041_ktcwebsite";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $customerRedeemConn = new mysqli($servername, $username, $password, $dbname);

        if ($customerRedeemConn->connect_error) {
            die("Customer Redeem Connection failed: " . $customerRedeemConn->connect_error);
        }

        $loggedInRecId = $_SESSION["rec_id"]; // Assuming "rec_id" is the session variable for the logged-in user

        $customerRedeemQuery = "SELECT gift_name FROM customerredeem WHERE rec_id = '$loggedInRecId'";
        $customerRedeemResult = $customerRedeemConn->query($customerRedeemQuery);

        if ($customerRedeemResult && $customerRedeemResult->num_rows > 0) {
            while ($row = $customerRedeemResult->fetch_assoc()) {
                $giftName = $row['gift_name'];
                echo "<li>$giftName</li>";
            }
        } else {
            echo "<li>No redeemed items yet.</li>";
        }

        // Close the customerredeem connection
        $customerRedeemConn->close();
        ?>
    </ul>
</div>
</div>
<div class="sticky-overlay">
    <p>Not enough credit points? Make Purchase Now </p>
    <a href="class.php" class="gotoclass">Make Purchase</a>
</div>





<!--</div>-->
    <!--<nav class="w3-bar w3-green">
        <a href="home.php" class="w3-button w3-bar-item">Home</a>
        <a href="enrollment.php" class="w3-button w3-bar-item">Personal Info</a>
        <a href="enrollment.php" class="w3-button w3-bar-item">Enrollment</a>
        <a href="redeempoint.php" class="w3-button w3-bar-item">Redeem Points</a>
    </nav>-->
    <script>
function checkPoints() {
    var availablePoints = <?php echo $availablePoints; ?>;
    var selectedGifts = document.querySelectorAll('input[name="gift[]"]:checked');
    var totalRedeemPoints = 0;

    selectedGifts.forEach(function(gift) {
        totalRedeemPoints += parseInt(gift.getAttribute('data-redeem-points'));
    });

    if (totalRedeemPoints > availablePoints) {
        alert("Error: You do not have enough points for redemption.");
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}
</script>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

