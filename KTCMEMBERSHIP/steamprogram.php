<?php
session_start();

if (!isset($_SESSION["rec_id"])) {
    session_unset();
    session_write_close();
    $url = "./index.php";
    header("Location: $url");
    exit;
}

$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$imageQuery = "SELECT image_filename FROM programposter";
$imageResult = $conn->query($imageQuery);

$query = "SELECT * FROM updatesteamprogrampage";
$result = $conn->query($query);

if ($result === false) {
    echo "Error executing the query: " . mysqli_error($conn);
} else {
    if ($result->num_rows > 0) {
        // Process and display the retrieved programs
    } else {
        echo "No programs found.";
    }
}

// Fetch program names from the database
$programNamesQuery = "SELECT DISTINCT program_name FROM updatesteamprogrampage";
$programNamesResult = $conn->query($programNamesQuery);

if ($programNamesResult === false) {
    echo "Error executing the query to fetch program names: " . mysqli_error($conn);
} else {
    $programNames = array();

    // Fetch program names and store them in an array
    while ($programRow = $programNamesResult->fetch_assoc()) {
        $programNames[] = $programRow['program_name'];
    }
}

// Check form submission
if (isset($_POST['addToCart'])) {
    // Set variables
    $type = "Steam Program";
    $dateTime = date('Y-m-d H:i:s');

    // Get posted data
    $quantities = $_POST['quantity'];

    foreach ($quantities as $programType => $quantity) {
        // Skip if quantity is 0
        if ($quantity == 0) {
            continue;
        }

        // Get program details from the database based on program name
        $programName = $programNames[$programType - 1]; // Adjust index to match array
        $programQuery = "SELECT * FROM updatesteamprogrampage WHERE program_name = '$programName'";
        $programResult = $conn->query($programQuery);

        if ($programResult === false) {
            echo "Error executing the query to fetch program details: " . mysqli_error($conn);
        } else {
            $programRow = $programResult->fetch_assoc();
            $price = $programRow['price'];
            $points = $programRow['point'];

            // Call addToCart function with calculated values
            addToCart($type, $programName, $quantity, $price, $points, '', '', $dateTime, $price * $quantity, $points * $quantity);
        }
    }

    // Comment out the redirection
    header('Location: cart.php');
    exit();
}



function addToCart($type, $programName, $quantity, $price, $points, $bookingTime, $bookingDate, $dateTime, $totalPrice, $totalPoints)
{ date_default_timezone_set('Asia/Kuala_Lumpur');
    $dateTime = date('Y-m-d H:i:s');

    // Start the session if not started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if cart_items is set in the session, if not, initialize it as an empty array
    if (!isset($_SESSION['cart_items'])) {
        $_SESSION['cart_items'] = array();
    }

    // Create a new cart item
    $cartItem = array(
        'type' => 'Steam Program',
        'program' => $programName,
        'quantity' => $quantity,
        'price' => $price,
        'points' => $points,
        'booking_time' => $bookingTime,
        'booking_date' => $bookingDate,
        'date_time' => $dateTime,
        'total_price' => $totalPrice,
        'total_points' => $totalPoints
    );

    // Add the new cart item to the cart_items array
    $_SESSION['cart_items'][] = $cartItem;

    // Update the cart subtotal, total price, and total points
    $_SESSION['cart_subtotal'] += $totalPrice;
    $_SESSION['total_price'] += $totalPrice;
    $_SESSION['total_points'] += $totalPoints;

    // Return the updated cart items
    return $_SESSION['cart_items'];
}

// Function to retrieve program details from the form
function getProgramDetails() {
    $programDetails = [];

    // Loop through each program type
    for ($programType = 1; $programType <= 3; $programType++) {
        // Retrieve quantity input and program name
        $quantityInput = isset($_POST['quantity'][$programType]) ? $_POST['quantity'][$programType] : 0;
        $programNameElement = isset($_POST['program'][$programType]) ? $_POST['program'][$programType] : '';

        if ($quantityInput && $programNameElement) {
            // Parse quantity as an integer
            $quantity = (int)$quantityInput;

            // If quantity is greater than 0, add program details to the array
            if ($quantity > 0) {
                $programDetails[] = [
                    'programName' => $programNameElement,
                    'quantity' => $quantity
                ];
            }
        }
    }

    return $programDetails;
}
?>

<!DOCTYPE html>
<HTML>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<HEAD>
<TITLE>Steam Program</TITLE><link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
<link href="assets/css/phppot-style.css" type="text/css"
	rel="stylesheet" />
<link href="assets/css/user-registration.css" type="text/css"
	rel="stylesheet" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</HEAD>

<style>

@font-face {
  font-family: 'MyCustomFont';
  src: url('assets/css/Varietykiller.otf') format('truetype');
}

@font-face {
        font-family: 'MyCustomFont';
        src: url('assets/css/RifficFreeBold.ttf') format('truetype');
      }

h1{
  color:black;
  text-align:center;
  font:arial;
}

.other-card h1 {
  font-family: 'MyCustomFont', Arial, sans-serif;
  color:#1A68B2;
  font-size: 50px;
  text-align: center;
}

.card-container {
  display: flex;
  justify-content: center;

}

.card-container.custom-button{
  text-align:center;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  width: 850px; 
  margin: 40px;
  text-align: center;
  font-family: Arial;
  border-radius: 20px;
  overflow: hidden;
  background:#ffeb54;
  display: flex; /* Use flex display */
  align-items: center;
}

/*.card img {
  border-radius: 20px;
  width: 100%;
  height: auto;
}*/

.card h1 {
  font-family: Arial;
  color: black;
  font-size: 17px;
}

.price {
  color: black;
  font-size: 18px;
}

/*.card button {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 30%;
  font-size: 18px;
}*/

.card button:hover {
  opacity: 0.7;
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

.hidden-form {
  display: none;
}

.submit {
  position: absolute;
  top: 1100px;
}
.btn3{
    text-decoration: none; 
    background-color: #fc7d28; 
    color: white; 
    padding: 10px 20px; 
    border: none; 
    border-radius: 5px;
    cursor: pointer;
    margin-right: 2px;
}

.btn3:hover {
            background-color: #993d00;
        }
.program-details {
  transform: translate(-4%, 100%);
  display: flex;
  align-items: center;
  margin-bottom: 30px;
  border-bottom: 2px solid #ccc; /* Change the color as needed */
  margin-bottom: 20px; /* Adjust the margin as needed */
  padding-bottom: 20px;
}

.program-details h1,
.program-details p {
  margin: 0;
  padding: 0;
}

.program-details h1 {
  flex: 1;
  margin-right: 10px;
}

.program-details .price,
.program-details p {
  margin-left: 60px;
}

.quantity {
    width: 60px;
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


.program-name {
        position: relative; /* Set the position to relative */
        margin-top: 10px; /* Adjust the margin as needed */
        margin-right:25px;
    }

    /* Additional styling for the program name */
    .program-name h1 {
        font-size: 16px;
        color: #333;
    }
.image-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px auto; /* Adjust as needed */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 10px;
    max-width: 50%;
}

.image-container img {
    max-width: 100%;
    max-height: 1000px; /* Adjust as needed */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: center;
    align-items: center;
}
.custom-button{
    background-color:#1A68B2;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .custom-button:hover {
        background-color: #207ed6;
    }
    .submit-button{
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
    .totalPrice{
        font-size: 13px;
        font-weight: bold;
    }
    .totalPoint{
        font-size: 13px;
    }
    .fillin{
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      width: 500px; 
      margin: 40px;
      text-align: center;
      font-family: Arial;
      border-radius: 5px;
      overflow: hidden;
      background:#e6f0fa;
    }
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
            
            .card {
              box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
              width: 354px; 
              margin: 40px;
              text-align: center;
              font-family: Arial;
              border-radius: 20px;
              overflow: hidden;
              font-size:10px;
              padding-bottom:50px;
            
            }
            .card h1 {
              font-family: Arial;
              color: black;
              font-size: 10px;
            }
            
            .price {
              color: black;
              font-size: 10px;
            }
            .card-container {
              display: flex;
              justify-content: center;
            }
            .program_details{
                border-bottom: 2px solid #ccc; /* Change the color as needed */
                margin-top:0;
                margin-bottom: 0; /* Adjust the margin as needed */
                padding-bottom: 20px;
            }
            .program-details .price,
            .program-details p {
              margin-left: 24px;
            }
            .program-details h1,
            .program-details p {
              margin: 0;
              padding: 0;
            }
            .quantity {
              width: 40px;
              margin-right:30px;
            }
            .totalprice{
                margin-right:20px;
            }
            .program-name {
                    position: relative;
                    margin-top: 5px;
                    margin-left:15px;
                }
            
                /* Additional styling for the program name */
                .program-name h1 {
                    font-size: 10px;
                    color: #333;
                }
                
                .other-card h1 {
              font-family: 'MyCustomFont', Arial, sans-serif;
              color:#1A68B2;
              font-size: 30px;
              text-align: center;
            }
            .image-container {
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 20px auto; /* Adjust as needed */
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 10px;
                max-width: 100%;
            }
            
            .image-container img {
                max-width: 100%;
                max-height: 1000px; /* Adjust as needed */
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .fillin{
              box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
              width: 300px; 
              margin: 40px;
              text-align: center;
              font-family: Arial;
              border-radius: 5px;
              overflow: hidden;
              background:#e6f0fa;
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
    }

    /* Close button */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }

    /* Styling for form elements and other CSS as needed */
    /* ... */

</style>
<style>
    
    body {
            background-image: url('assets/img/DSC04798.jpg'); /* Specify the path to your background image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            margin: 0; /* Remove default body margin */
            padding: 0; /* Remove default body padding */
            font-family: Arial, sans-serif; /* Change the font family as needed */
        }

        .card-container {
            background-color: rgba(255, 255, 255, 0.8); /* Adjust the alpha value for transparency */
            padding: 20px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); /* Add a subtle box shadow for depth */
            backdrop-filter: blur(10px);
        }

        .card {
            background: none; /* Remove the background color */
            box-shadow: none; /* Remove the box shadow */
            border: 1px solid #ccc; /* Add a border for separation */
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
       

</HEAD>

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
        <!-- Logo and brand text -->
        <a class="navbar-brand d-flex align-items-center ms-sm-auto" href="logout.php">
            Logout
        </a>
    </div>
</nav>
<!--</div>-->
    <!--<nav class="w3-bar w3-green">
        <a href="home.php" class="w3-button w3-bar-item">Home</a>
        <a href="enrollment.php" class="w3-button w3-bar-item">Personal Info</a>
        <a href="enrollment.php" class="w3-button w3-bar-item">Enrollment</a>
        <a href="redeempoint.php" class="w3-button w3-bar-item">Redeem Points</a>
    </nav>-->

    <!--<h2 style="text-align:center">PROGRAM</h2>-->
    <body><br><br>
    <div class="other-card">
    <h1>SCHOOL HOLIDAY PROGRAM</h1>
    <div class="image-container">
        <?php
        if ($imageResult && $imageResult->num_rows > 0) {
            $imageRow = $imageResult->fetch_assoc();
            $imageFilename = $imageRow['image_filename'];
            echo '<img src="' . $imageFilename . '" alt="Program Poster">';
        } else {
            echo 'No program poster available.';
        }
        ?>
    </div>
  </div><br>
<!--  <div class="container">
  <div class="row justify-content-center">
    <div class="col-md-3">
      <div class="form-group">
        <!--<label for="program">Type</label>-->
        <!--<select id="type" class="form-control" onchange="showForm(this.value)">
          <option selected>Choose type</option>
          <option value="SchoolHolidayProgram">School Holiday Program</option>
          <option value="SteamProgram">Steam Program</option>
        </select>
      </div>
    </div>
  </div>
</div>-->
<!--<h1>School Holiday Program</h1>-->
<div class="card-container">
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    <?php
    if ($result->num_rows > 0) {
        echo '<div class="card">';
        $programType = 1; // Set program type
        $overallTotalPrice = 0;
        $overallTotalPoints = 0;
    }
    ?>
    <div class="fillin">
        <p style="margin-top:8px;">Fill in the following details for your selected programs:</p>
    </div>

    <?php
    while ($row = $result->fetch_assoc()) {
        $programName = $row['program_name'];
        $price = $row['price'];
        $points = $row['point'];
        $programDetailsId = 'program-details-' . $programType;
    ?>
<!-- Repeat this pattern for each program type -->

<input type="hidden" name="program[<?php echo $programType; ?>]" value="<?php echo $programName; ?>">
<input type="hidden" name="price[<?php echo $programType; ?>]" value="<?php echo $price; ?>">
<input type="hidden" name="points[<?php echo $programType; ?>]" value="<?php echo $points; ?>">

        <div class="program-details" id="<?php echo $programDetailsId; ?>">
            <h1>
                <div class="program-name">
                    <h1><?php echo $programName; ?></h1>
                </div>
            </h1>
            <p><label for="quantity-<?php echo $programType; ?>">Quantity:</label></p>
            <p>
                <select class="quantity" name="quantity[<?php echo $programType; ?>]" id="quantity-<?php echo $programType; ?>">
                    <option value="0">Select Quantity</option>
                    <?php for ($i = 1; $i <= 50; $i++) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                </select>
            </p>
            <p>Total<br>Price: <span class="totalprice" id="total-price-<?php echo $programType; ?>"><?php echo $price; ?></span></p>
            <p>Total<br>Point: <span id="total-points-<?php echo $programType; ?>"><?php echo $points; ?></span></p>

        </div>

        <script>
            var quantityInput<?php echo $programType; ?> = document.getElementById('quantity-<?php echo $programType; ?>');
            var totalPriceElement<?php echo $programType; ?> = document.getElementById('total-price-<?php echo $programType; ?>');
            var totalPointsElement<?php echo $programType; ?> = document.getElementById('total-points-<?php echo $programType; ?>');
            var price<?php echo $programType; ?> = <?php echo $price; ?>;
            var points<?php echo $programType; ?> = <?php echo $points; ?>;

            quantityInput<?php echo $programType; ?>.addEventListener('change', function() {
                var quantity<?php echo $programType; ?> = parseInt(quantityInput<?php echo $programType; ?>.value);
                var totalPrice<?php echo $programType; ?> = quantity<?php echo $programType; ?> * price<?php echo $programType; ?>;
                var totalPoints<?php echo $programType; ?> = quantity<?php echo $programType; ?> * points<?php echo $programType; ?>;

                if (quantity<?php echo $programType; ?> === 0) {
                    totalPrice<?php echo $programType; ?> = 0;
                    totalPoints<?php echo $programType; ?> = 0;
                }

                totalPriceElement<?php echo $programType; ?>.textContent = totalPrice<?php echo $programType; ?>;
                totalPointsElement<?php echo $programType; ?>.textContent = totalPoints<?php echo $programType; ?>;

                updateOverallTotals(); // Call the function to update overall totals
            });

            // Initialize totals with quantity 0
var initialQuantity<?php echo $programType; ?> = 0;
var initialTotalPrice<?php echo $programType; ?> = initialQuantity<?php echo $programType; ?> * price<?php echo $programType; ?>;
var initialTotalPoints<?php echo $programType; ?> = initialQuantity<?php echo $programType; ?> * points<?php echo $programType; ?>;

totalPriceElement<?php echo $programType; ?>.textContent = initialTotalPrice<?php echo $programType; ?>;
totalPointsElement<?php echo $programType; ?>.textContent = initialTotalPoints<?php echo $programType; ?>;

        </script>

    <?php
        $programType++;
    }
    ?>
    <script>
        function updateOverallTotals() {
            var overallTotalPrice = 0;
            var overallTotalPoints = 0;

            <?php for ($i = 1; $i < $programType; $i++) { ?>
                var quantity<?php echo $i; ?> = parseInt(document.getElementById('quantity-<?php echo $i; ?>').value);
                overallTotalPrice += quantity<?php echo $i; ?> * price<?php echo $i; ?>;
                overallTotalPoints += quantity<?php echo $i; ?> * points<?php echo $i; ?>;
            <?php } ?>

            document.getElementById('overall-total-price').textContent = 'Total Price: RM ' + overallTotalPrice.toFixed(2);
            document.getElementById('overall-total-points').textContent = overallTotalPoints + ' points added';
        }

        updateOverallTotals();
    </script>
<br> <br><br> <br>
    <!-- Add the "Add to Cart" button outside the loop -->
    <p class="custom-button-container" id="goToPaymentContainer" style="display:none;">
        <button class="btn3" type="submit" name="addToCart">Add to Cart</button>
    </p>
    <br>
    </div>
    </form>
</div>

<script>
    function toggleFileContainer(showFileUpload) {
        const fileContainer = document.getElementById('fileContainer');
        if (showFileUpload) {
            fileContainer.style.display = 'block';
        } else {
            fileContainer.style.display = 'none';
        }
    }

    // Call the toggleFileContainer function initially to set the initial state based on the selected radio button
    const cashRadio = document.getElementById('cash');
    const bankRadio = document.getElementById('bank');
    const fileContainer = document.getElementById('fileContainer');

    cashRadio.checked ? toggleFileContainer(false) : toggleFileContainer(true);
</script>
<script>
        // JavaScript function to handle showing/hiding the "Go To Payment" button
        function handleQuantityChange() {
            // Get all the quantity input elements
            const quantityInputs = document.querySelectorAll('.quantity');
            let showPaymentButton = false;

            // Check if any of the quantity inputs have a value greater than 0
            quantityInputs.forEach(input => {
                if (parseInt(input.value) > 0) {
                    showPaymentButton = true;
                }
            });

            // Show or hide the "Go To Payment" button based on the showPaymentButton variable
            const goToPaymentContainer = document.getElementById('goToPaymentContainer');
            goToPaymentContainer.style.display = showPaymentButton ? 'block' : 'none';
        }

        // Add an event listener to each quantity input to call the handleQuantityChange function on change
        const quantityInputs = document.querySelectorAll('.quantity');
        quantityInputs.forEach(input => {
            input.addEventListener('change', handleQuantityChange);
        });

        // Call the handleQuantityChange function initially to check if the button should be shown
        handleQuantityChange();
    </script>


</div>


<br><br>

<script>
  function showForm(value) {
    var schoolHolidayProgramForm = document.getElementById("school-holiday-program-form");
    var steamProgramForm = document.querySelector(".card.hidden-form");

    if (value === "SteamProgram") {
      schoolHolidayProgramForm.style.display = "none";
      steamProgramForm.style.display = "block";
    } else if (value === "SchoolHolidayProgram") {
      steamProgramForm.style.display = "none";
      schoolHolidayProgramForm.style.display = "block";
    } else {
      steamProgramForm.style.display = "none";
      schoolHolidayProgramForm.style.display = "none";
    }
  }
</script>
<script>
    function viewInvoice() {
        // Retrieve program details from the form
        var programDetails = getProgramDetails();

        // Check if there are selected programs
        if (programDetails.length > 0) {
            // Convert program details to JSON and encode for URL
            var programDetailsJSON = encodeURIComponent(JSON.stringify(programDetails));

            // Open the invoice PDF with program details in the URL
            window.location.href = 'steamInvoice.php?programDetails=' + programDetailsJSON;
        } else {
            alert('Please select programs before viewing the invoice.');
        }
    }

</script>

<script>
    // Function to update overall totals
    function updateOverallTotals() {
        var overallTotalPrice = 0;
        var overallTotalPoints = 0;

        // Loop through each program type
        for (var programType = 1; programType <= 3; programType++) {
            var quantityInput = document.getElementById('quantity-' + programType);

            // Check if the quantity input exists
            if (quantityInput) {
                var quantity = parseInt(quantityInput.value);

                // Check if the quantity is greater than 0
                if (quantity > 0) {
                    var price = parseFloat(document.querySelector('#program-details-' + programType + ' .totalprice').textContent);
                    var points = parseFloat(document.getElementById('total-points-' + programType).textContent);

                    overallTotalPrice += quantity * price;
                    overallTotalPoints += quantity * points;
                }
            }
        }

        // Update the overall totals
        document.getElementById('overall-total-price').textContent = 'Total Price: RM ' + overallTotalPrice.toFixed(2);
        document.getElementById('overall-total-points').textContent = overallTotalPoints + ' points added';
    }

    // Add event listeners for quantity change on each program type
    for (var programType = 1; programType <= 3; programType++) {
        var quantityInput = document.getElementById('quantity-' + programType);

        // Check if the quantity input exists
        if (quantityInput) {
            quantityInput.addEventListener('change', function () {
                updateOverallTotals();
            });
        }
    }

    // Call the updateOverallTotals function initially to set the initial overall totals
    updateOverallTotals();
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</BODY>
</HTML> 