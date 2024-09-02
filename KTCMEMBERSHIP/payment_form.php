<?php
session_start();

if (!isset($_SESSION["rec_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ./index.php");
    exit();
}
?>
<?php
// Retrieve cart item details from the session
$cartItems = isset($_POST['cart_items']) ? json_decode($_POST['cart_items'], true) : [];

// Get total price
$totalPrice = isset($_POST['total_price']) ? $_POST['total_price'] : 0;

// Retrieve rec_id and studentname from the session
$recId = isset($_SESSION['rec_id']) ? $_SESSION['rec_id'] : null;
$studentName = isset($_SESSION['studentname']) ? $_SESSION['studentname'] : null;

// Get payment method from the form
$paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

// Check if the 'Pay' button or 'Pay with Cash' button is clicked
if (isset($_POST['submit_payment']) || isset($_POST['submit_cash_payment'])) {
    // Get payment details outside the loop
    $bankName = '';
    $accountNumber = '';
    $paymentDatetime = '';
    $commonReceiptImage = '';

    // Handle file upload outside the loop
    $targetDir = "uploads/";
    $uploadedFiles = [];

    if (isset($_POST['submit_payment'])) {
        // Process receipt file upload for online payment
        if ($paymentMethod === 'Pay with Bank') {
            // Additional handling for 'Pay with Bank' option
            $bankName = isset($_POST['bank_name']) ? $_POST['bank_name'] : '';
            $accountNumber = isset($_POST['account_number']) ? $_POST['account_number'] : '';
            $paymentDatetime = isset($_POST['payment_datetime']) ? $_POST['payment_datetime'] : '';
        if (!empty($_FILES['upload_file']['name'])) {
            foreach ($_FILES['upload_file']['name'] as $key => $value) {
                $uploadFile = $targetDir . basename($_FILES['upload_file']['name'][$key]);
                if (move_uploaded_file($_FILES['upload_file']['tmp_name'][$key], $uploadFile)) {
                    $uploadedFiles[] = $uploadFile;
                }
            }
        }
    }
}

    // Use the first uploaded file for all items
    $commonReceiptImage = !empty($uploadedFiles) ? $uploadedFiles[0] : '';

    // Database connection
    require 'db_conn.php';

    // Initialize total price
    $totalPrice = 0;

    // Initialize overallPoints before the loop
$overallPoints = 0;


    // Process cart items
    foreach ($cartItems as $key => $item) {
        if (is_array($item) && isset($item['type'])) {
            // Ensure the required keys exist in the item array
            $type = $item['type'];
            $programName = isset($item['program']) ? $item['program'] : '';
            $price = isset($item['price']) ? $item['price'] : 0;
            $points = isset($item['points']) ? $item['points'] : 0;
            $quantity = isset($item['quantity']) ? $item['quantity'] : 0;
            $bookingTime = isset($item['booking_time']) ? $item['booking_time'] : '';
            $bookingDate = isset($item['booking_date']) ? $item['booking_date'] : '';

            $subtotal = $price * $quantity;
            $totalPrice += $subtotal;

            // Set total_points based on each item's price and quantity
            $totalPoints = $price * $quantity;
            
            // Calculate overall points by adding the total points of each item
            $overallPoints += $totalPoints;

            // Insert purchase data
            $sql = "INSERT INTO purchases(type, program, price, points, quantity, total_price, total_points, bank_name, account_number, payment_datetime, image_filename, rec_id, studentname, payment_status, payment_method, booking_time, booking_date)
            VALUES (:type, :programName, :price, :points, :quantity, :subtotal, :totalPoints, :bankName, :accountNumber, :paymentDatetime, :image_filename, :recId, :studentName, 'pending', :paymentMethod, :booking_time, :booking_date)";

            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':programName', $programName);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':points', $points);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':subtotal', $subtotal);
            $stmt->bindParam(':totalPoints', $totalPoints);
            $stmt->bindParam(':bankName', $bankName);
            $stmt->bindParam(':accountNumber', $accountNumber);
            $stmt->bindParam(':paymentDatetime', $paymentDatetime);
            $stmt->bindParam(':image_filename', $commonReceiptImage); // Use the common receipt image
            $stmt->bindParam(':recId', $recId);
            $stmt->bindParam(':studentName', $studentName);
            $stmt->bindParam(':paymentMethod', $paymentMethod); // Bind payment method
            $stmt->bindParam(':booking_time', $bookingTime);
            $stmt->bindParam(':booking_date', $bookingDate);

            // Execute statement
            if (!$stmt->execute()) {
                // Handle the error
                echo "Error inserting purchase data.";
                exit(); // Exit script if an error occurs
            }
        }
    }

// Clear the cart upon successful database entry
unset($_SESSION['cart_items']);

// Redirect to confirmation
header("Location: payment_confirmation.php");
exit();
}
?>
<?php
// Get the image path from the query string
$imagePath = isset($_GET['image']) ? $_GET['image'] : '';

// Check if the image path is not empty
if (!empty($imagePath)) {
    // Set the appropriate headers for image download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($imagePath) . '"');
    readfile($imagePath);
} 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
    <link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
    <link href="assets/css/phppot-style.css" type="text/css"
	rel="stylesheet" />
<link href="assets/css/user-registration.css" type="text/css"
	rel="stylesheet" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .gallery {
  text-align: center;
    cursor: pointer;

}

.popup {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 90%;
  background-color: rgba(0, 0, 0, 0.5) !important; /* Add !important */
  justify-content: center;
  align-items: center;
}


.popup img {
  max-width: 100%;
  max-height: 100%;
  transform: scale(1.2); /* Zoom the image by 20% */
  transition: transform 0.3s ease; /* Add a smooth transition effect */
}

.popup button {
  position: absolute;
  top: 10px;
  left: 10px;
}

.popup span.close {
  color: #fff;
  font-size: 30px;
  position: absolute;
  top: 10px;
  right: 20px;
  cursor: pointer;
}
@font-face {
  font-family: 'MyCustomFont';
  src: url('assets/css/Varietykiller.otf') format('truetype');
}

@font-face {
  font-family: 'MyOtherCustomFont';
  src: url('assets/css/RifficFreeBold.ttf') format('truetype');
}

h1{
  color:black;
  text-align:center;
  font:arial;
}

.other-card h1 {
  font-family: 'MyOtherCustomFont', Arial, sans-serif;
  color:#1A68B2;
  font-size: 50px;
  text-align: center;
}
  .card {
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width: 40%;
    border-radius: 5px;
  }

  .card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
  }

  .card-content {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  img {
    border-radius: 5px 5px 0 0;
    max-width: 100%;
    height: auto;
  }

  .container {
            position: relative;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border: 1px solid #ccc;
            border-radius: 20px;
            margin: 10px;
            background-color: #ffeb54;
            width: 850px;
            padding: 30px;
            text-align: center;
        }

        .account-number {
            margin-bottom: 20px;
        }

        .copy-success {
    display: none;
    position: absolute;
    top: calc(100% + 10px);
    left: 50%;
    transform: translateX(-50%);
    color: #4CAF50;
    padding: 5px;
    border-radius: 5px;
    font-size: 14px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.copy-success.show {
    display: block;
    opacity: 1;
}


  .purchase-button {
    background-color: #4CAF50;
    color: white;
    border: none;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 5px;
    padding: 8px 16px;
    cursor: pointer;
  }

/* Pop-up styles */
.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: none;
  justify-content: center;
  align-items: center;
}

/*.popup {
    background-color: white;
    border-radius: 10px;
    padding: 50px;
    text-align: center;
    max-width: 400px; /* Updated max-width */
    width: 80%; /* Added width */
    max-height: 80vh; /* Added max-height */
    overflow-y: auto; /* Added overflow-y for scrolling if needed */
  }*/

.close-button {
  color: #aaa;
  float: right;
  font-size: 32px;
  font-weight: bold;
  cursor: pointer;
}

.popup p,
.popup input {
  font-size: 20px;
}

.popup input {

  font-size: 16px;
}

.popup input:focus {
  outline: none;
  border-color: #aaa;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
}
.total-price {
    font-size: 15px;
    font-weight: bold;
  }

  .total-price-container {
    text-align: center;
    font-weight: bold;
  }
.carousel-container {
    display: flex;
    flex-wrap: nowrap;
    justify-content: flex-start;
    gap: 20px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scroll-padding: 20px;
    scrollbar-width: thin;
  }

  .carousel-item {
    scroll-snap-align: center;
    flex: 0 0 auto;
    width: 40%;
    max-width: 400px;
    border-radius: 5px;
    background-color: #f2f2f2;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
  }

  .carousel-item:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
  }

  .carousel-controls {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }

  .carousel-control {
    margin: 0 10px;
    font-size: 24px;
    color: #aaa;
    cursor: pointer;
  }

  .carousel-control:hover {
    color: #666;
  }

  .image-container {
  float: left;
  margin-right: 80px;
}

.content-container {
  overflow: hidden; /* Clear float */
}
.submit-button {
        background-color:#1A68B2;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .submit-button:hover {
        background-color: #207ed6;
    }
    
    .submit-button-payment{
        background-color:#1A68B2;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .submit-button-payment:hover {
        background-color: #207ed6;
    }
    .fillin{
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      width: 500px; 
      text-align: center;
      font-family: Arial;
      border-radius: 5px;
      overflow: hidden;
      background:#e6f0fa;
    }
    .quantity-input {
    width: 110px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    background-color: #fff;
    appearance: none; /* Remove default arrow */
    -webkit-appearance: none; /* Safari */
    -moz-appearance: none; /* Firefox */
    background-repeat: no-repeat;
    background-position: right center;
    background-size: 12px 12px; /* Adjust arrow image size */
}
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

    body {
    background-image: url('assets/img/DSC04773.jpg'); /* Replace with the actual path to your image */
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
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
            .fillin{
              box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
              width: 320px; 
              text-align: center;
              font-family: Arial;
              font-size:12px;
              border-radius: 5px;
              overflow: hidden;
              background:#e6f0fa;
            }
            .quantity{
                width:50px;
            }
        }
    </style>
    
<style>
    /* Overlay for the popup */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 9999;
        display: none; /* Hide the overlay by default */
    }

    /* Popup container */
    .popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 10000;
        max-width: 500px;
        text-align: center;
    }

    /* Close button */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
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
        .btn2 {
            background-color: #206aba;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn2:hover {
            background-color: #174d87;
        }
.btn3{
    text-decoration: none; 
    background-color: #fc7d28; 
    color: white; 
    padding: 10px 20px; 
    border: none; 
    border-radius: 5px;
    cursor: pointer;
}

.row {
        display: flex;
        justify-content: center;
    }

    .column {
        width: 20%;
        margin: 2%;
        text-align: center;
    }

  .column a img {
    width: 100%;
    max-width: 100%; /* Ensure images don't exceed their container's width */
  }

.btn3:hover {
            background-color: #993d00;
        }
    
        .btn4{
    text-decoration: none; 
    background-color: #D11A2A; 
    color: white; 
    padding: 5px 10px; 
    border: none; 
    border-radius: 5px;
    cursor: pointer;
}

.btn4:hover {
            background-color: #7c0000;
        }
</style>
    
           <style>

.btn2 {
            background-color: #f93c6f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 2px;
        }
        .btn2:hover {
            background-color: #f9245e;
        }
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
            .fillin{
              box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
              width: 300px; 
              text-align: center;
              font-family: Arial;
              font-size:10px;
              border-radius: 5px;
              overflow: hidden;
              background:#e6f0fa;
            }
        }
        .copy-comment {
  position: absolute;
  top: -20px;
  right: 0;
  background-color: #4CAF50;
  color: #fff;
  padding: 5px;
  border-radius: 5px;
  font-size: 12px;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.copy-comment.show {
  opacity: 1;
}

.btn4 {
  background-color: #206aba;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 2px;
}
.btn4:hover {
            background-color: #174d87;
        }
</style>
   
</head>
<body>

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
        <a class="navbar-brand d-flex align-items-center ms-sm-auto" href="logout.php">
            Logout
        </a>
    </div>
</nav>

<center>
  <div class="container">
    <b><h1>Checkout</h1></b><br>

    <!-- Display total price -->
    <b><h4 style="color: #ef510b;">Total: RM <?php echo $totalPrice; ?></h4></b><br>

    <!-- Display DuitNow QR Code -->
    <div class="transfer-to-account"><h5>Transfer to account:</h5></div>
    <div class="gallery">
  <img src="assets/img/qrcode.jpg" alt="Image" id="popupImage">
</div>

<div class="popup" id="imagePopup">
  <img src="assets/img/qrcode.jpg" alt="Image">
  <button class="btn2" id="saveButton"><b>Save to Gallery</b></button>
  <span class="close" onclick="closePopup()">&times;</span>
</div><br>
    <b>
      <div class="cimb-bank"><h4>CIMB Bank</h4></div>
      <div class="dreamedge"><h4>DreamEDGE Sdn Bhd</h4></div>
      <div class="account-number">
      <h4 id="accountNumber">8603743834</h4>
      <button id="copyButton" class="btn4" onclick="copyToClipboard()">Copy Account Number</button>
      <div class="copy-success" id="copySuccess">Copied to clipboard</div>
    </div><br>


<div class="row">
        <div class="column">
          <a href="https://www.allianceonline.com.my/personal/login/login.do" target="_blank">
            <img src="assets/img/alliance.jpeg" alt="Alliance Bank">
          </a>
        </div>
        <div class="column">
          <a href="https://ambank.amonline.com.my/web/" target="_blank">
            <img src="assets/img/amOnlinebank.svg" alt="AmBank">
          </a>
        </div>
        <div class="column">
          <a href="https://www.affinalways.com/en/homepage" target="_blank">
            <img src="assets/img/Affin Bank.jpg" alt="Affin Bank">
          </a>
        </div>
      </div>

      <div class="row">
        <div class="column">
          <a href="https://www.cimbclicks.com.my/clicks/" target="_blank">
            <img src="assets/img/cimb-bank.jpg" alt="CIMB Bank">
          </a>
        </div>
        <div class="column">
          <a href="https://s.hongleongconnect.my/rib/app/fo/login?web=1" target="_blank">
            <img src="assets/img/hong-leong.png" alt="Hong Leong Bank">
          </a>
        </div>
      </div>

      <div class="row">
        <div class="column">
          <a href="https://www.maybank2u.com.my/home/m2u/common/login.do" target="_blank">
            <img src="assets/img/maybank.png" alt="Maybank">
          </a>
        </div>
        <div class="column">
          <a href="https://www.pbebank.com/" target="_blank">
            <img src="assets/img/public-bank.png" alt="Public Bank">
          </a>
        </div>
        <div class="column">
          <a href="https://onlinebanking.rhbgroup.com/my/login" target="_blank">
            <img src="assets/img/rhb-bank.png" alt="RHB Bank">
          </a>
        </div>
      </div>
      </b>
    <br><br>

<!-- Payment form -->
<b><form method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateForm()">
    <!-- Add hidden fields to store purchase data -->
    <input type="hidden" name="cart_items" value='<?php echo json_encode($_SESSION['cart_items']); ?>'>
    <input type="hidden" name="total_price" value='<?php echo $totalPrice; ?>'>

    <!-- Table for organizing labels and input fields -->
    <table style="margin: 0 auto;">
    <tr>
        <td><label for="payment_method">Payment Method:</label></td>
        <td>
            <select name="payment_method" id="payment_method" onchange="togglePaymentFields()">
                <option value="Pay with Bank">Pay with Bank</option>
                <option value="Pay with QR">Pay with QR</option>
                <option value="Pay with Cash">Pay with Cash</option>
            </select>
        </td>
    </tr>
    <tr id="bankFields">
        <td><label for="bank_name">Bank Name:</label></td>
        <td><input type="text" name="bank_name" id="bank_name" required></td>
    </tr>
    <tr id="accountNumberFields">
        <td><label for="account_number">Account Number:</label></td>
        <td><input type="text" name="account_number" id="account_number" required></td>
    </tr>
    <tr id="paymentDatetimeFields">
        <td><label for="payment_datetime">Payment Date and Time:</label></td>
        <td><input type="text" name="payment_datetime" id="payment_datetime" placeholder="dd-mm-yyyy 00:00 AM/PM" required></td>
    </tr>
    <tr id="receiptFields">
        <td><label for="upload_file">Receipt:</label></td>
        <td>
            <input type="file" name="upload_file[]" id="upload_file" accept="image/*" required>
        </td>
    </tr>
</table>
<br>
    <!-- Submit button -->
    <input type="submit" name="submit_payment" class="btn1" value="Submit Payment">
</form></b>

<script>
    function togglePaymentFields() {
        var paymentMethod = document.getElementById('payment_method').value;
        var bankFields = document.getElementById('bankFields');
        var accountNumberFields = document.getElementById('accountNumberFields');
        var paymentDatetimeFields = document.getElementById('paymentDatetimeFields');
        var receiptFields = document.getElementById('receiptFields');

        if (paymentMethod === 'Pay with Cash') {
            // Hide and disable bank and account number fields
            bankFields.style.display = 'none';
            bankFields.querySelectorAll('input').forEach(function (input) {
                input.disabled = true;
            });

            accountNumberFields.style.display = 'none';
            accountNumberFields.querySelectorAll('input').forEach(function (input) {
                input.disabled = true;
            });
            paymentDatetimeFields.style.display = 'none';
            paymentDatetimeFields.querySelectorAll('input').forEach(function (input) {
                input.disabled = true;
            });
            // Hide and disable receipt field for cash payments
            receiptFields.style.display = 'none';
            receiptFields.querySelector('label').style.display = 'none';
            receiptFields.querySelector('input').disabled = true;
        }else if (paymentMethod === 'Pay with QR') {
            // Hide and disable bank and account number fields
            bankFields.style.display = 'none';
            bankFields.querySelectorAll('input').forEach(function (input) {
                input.disabled = true;
            });

            accountNumberFields.style.display = 'none';
            accountNumberFields.querySelectorAll('input').forEach(function (input) {
                input.disabled = true;
            });
            paymentDatetimeFields.style.display = 'none';
            paymentDatetimeFields.querySelectorAll('input').forEach(function (input) {
                input.disabled = true;
            });
            // Hide and disable receipt field for cash payments
            // Show and enable receipt field for bank payments
            receiptFields.style.display = 'table-row';
            receiptFields.querySelector('label').style.display = 'table-cell';
            receiptFields.querySelector('input').disabled = false;
        }else {
            // Show and enable bank and account number fields
            bankFields.style.display = 'table-row';
            bankFields.querySelectorAll('input').forEach(function (input) {
                input.disabled = false;
            });

            accountNumberFields.style.display = 'table-row';
            accountNumberFields.querySelectorAll('input').forEach(function (input) {
                input.disabled = false;
            });

            paymentDatetimeFields.style.display = 'table-row';
            paymentDatetimeFields.querySelectorAll('input').forEach(function (input) {
                input.disabled = false;
            });

            // Show and enable receipt field for bank payments
            receiptFields.style.display = 'table-row';
            receiptFields.querySelector('label').style.display = 'table-cell';
            receiptFields.querySelector('input').disabled = false;
        }
    }

    // Initial call to set the state based on the default selection
    togglePaymentFields();
</script>

</div></center>


<!-- JavaScript to validate form -->
<script>
function validateForm() {
    var paymentMethod = document.getElementById('payment_method').options[document.getElementById('payment_method').selectedIndex].value;

    if (paymentMethod === 'Pay with Bank') {
        var bankName = document.getElementById('bank_name').value;
        var accountNumber = document.getElementById('account_number').value;
        var paymentDatetime = document.getElementById('payment_datetime').value;
        var receiptFile = document.getElementById('upload_file').value;

        if (bankName === '' || accountNumber === '' || paymentDatetime === '' || receiptFile === '') {
            alert('Please fill in all the fields.');
            return false;
        }
    } else if (paymentMethod === 'Pay with Cash') {
        // No additional validation needed for 'Pay with Cash'
    }

    return true;
}
</script>
<script>
  document.getElementById('popupImage').addEventListener('click', function() {
  document.getElementById('imagePopup').style.display = 'flex';
});

document.getElementById('saveButton').addEventListener('click', function() {
  // Use encodeURIComponent to properly handle special characters in the image path
  var imagePath = 'assets/img/qrcode.jpg';  // Replace with the actual image path
  window.location.href = 'payment_form.php?image=' + encodeURIComponent(imagePath);
});


function closePopup() {
  document.getElementById('imagePopup').style.display = 'none';
}

</script>
<script>
function copyToClipboard() {
    var accountNumber = document.getElementById('accountNumber');
    var copySuccess = document.getElementById('copySuccess');
    var copyButton = document.getElementById('copyButton');

    // Create a temporary input element to copy the text
    var tempInput = document.createElement('input');
    tempInput.value = accountNumber.textContent;
    document.body.appendChild(tempInput);

    // Select the text and copy it
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);

    // Position the success message below the button
    var buttonRect = copyButton.getBoundingClientRect();
    var containerRect = document.querySelector('.container').getBoundingClientRect();

    // Ensure the success message stays within the container
    copySuccess.style.position = 'absolute';
    copySuccess.style.top = buttonRect.bottom + 2 - containerRect.top + 'px';
    copySuccess.style.left = '50%';
    copySuccess.style.transform = 'translateX(-50%)'; // Center horizontally

    // Display the success message
    copySuccess.classList.add('show');

    // Hide the success message after a delay
    setTimeout(function () {
        copySuccess.classList.remove('show');
    }, 2000);
}
</script>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>