<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION["rec_id"])) {
    header("Location: ./index.php");
    exit();
}

// Include the tcpdf.php file after the exit statement
require 'tcpdf/tcpdf.php';

// Date/time variable
$dateTime = date('Y-m-d H:i:s');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    // Initialize an array to store exhibition details
    $exhibitionDetails = [];

    // Process the form submissions
    foreach ($_POST['quantity'] as $countryName => $quantity) {
        // Check if all required fields are set in $_POST
        if (
            isset($_POST['country_name'][$countryName], $_POST['price'][$countryName], $_POST['point'][$countryName], $_POST['booking_time'][$countryName], $_POST['booking_date'][$countryName])
        ) {
            // Get form data
            $programName = $_POST['country_name'][$countryName];
            $price = $_POST['price'][$countryName];
            $points = $_POST['point'][$countryName];
            $bookingTime = $_POST['booking_time'][$countryName];
            $bookingDate = $_POST['booking_date'][$countryName];

            // Log data for debugging
            echo '<script>console.log("Processing exhibition ' . $countryName . ':", ' . json_encode($programName) . ', ' . json_encode($quantity) . ', ' . json_encode($price) . ', ' . json_encode($points) . ', ' . json_encode($bookingTime) . ', ' . json_encode($bookingDate) . ');</script>';

            // Call the addToCart function only if quantity is greater than 0
            if ($quantity > 0) {
                // Add the exhibition to the cart
                addToCart('Exhibition', $programName, $quantity, $price, $points, $bookingTime, $bookingDate, $dateTime);

                // Add exhibition details to the array
                $exhibitionDetails[] = [
                    'countryName' => $programName,
                    'quantity' => $quantity,
                    'price' => $price,
                    'points' => $points,
                    'booking_time' => $bookingTime,
                    'booking_date' => $bookingDate,
                    'date_Time' => $dateTime,
                ];
            }
        } else {
            // Log an error or handle the case where any of the required fields is not set
            echo 'Error: Required field is not set for exhibition ' . $countryName . '<br>';
            echo 'Debug info: ' . json_encode($_POST) . '<br>';
        }
    }
    // Return a response if needed
    echo 'Items added to cart successfully.';

    // Redirect to cart.php
    header('Location: cart.php');
    exit(); // Don't forget to exit to prevent further execution
}

// Updated addToCart function
// In exhibition.php 

function addToCart($type, $programName, $quantity, $price, $points, $bookingTime, $bookingDate, $dateTime)
{
    // Set the correct timezone to Kuala Lumpur
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $dateTime = date('Y-m-d H:i:s');

    // Initialize cart_items if not set
    if (!isset($_SESSION['cart_items']) || !is_array($_SESSION['cart_items'])) {
        $_SESSION['cart_items'] = [];
    }

    // Add to cart array with the "date_time" key
    $_SESSION['cart_items'][] = array(
        'type' => $type,
        'program' => $programName,
        'quantity' => $quantity,
        'price' => $price,
        'points' => $points,
        'booking_time' => $bookingTime,
        'booking_date' => $bookingDate,
        'date_time' => $dateTime, // Ensure "date_time" key is set
    );

    // Log a message to the console
    echo '<script>console.log("Item added to cart:", ' . json_encode($type) . ', ' . json_encode($programName) . ', ' . json_encode($quantity) . ', ' . json_encode($price) . ', ' . json_encode($points) . ', ' . json_encode($bookingTime) . ', ' . json_encode($bookingDate) . ', ' . json_encode($dateTime) . ');</script>';

    // Return true to allow the form submission to proceed
    return true;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exhibition</title>
    <link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
    <link href="assets/css/phppot-style.css" type="text/css" rel="stylesheet" />
    <link href="assets/css/user-registration.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">


  <style>
     
      @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

      @font-face {
        font-family: 'MyCustomFont';
        src: url('assets/css/RifficFreeBold.ttf') format('truetype');
      }

      

      h1 {
        font-family: 'Playfair Display', serif;
        font-family: 'MyCustomFont', Arial, sans-serif;
        color:#1A68B2;
        font-size: 50px;
        text-align: center;
        margin-top: 50px;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 0.2em;
      }
      
      h2 {
        font-family: 'Playfair Display', serif;
        font-family: 'MyCustomFont', Arial, sans-serif;
        color:black;
        font-size: 30px;
        text-align: center;
        margin-top: 20px;
        text-transform: uppercase;
        letter-spacing: 0.2em;
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
.container {
   max-width: 800px;
   margin: 0 auto;
   padding: 20px;
}

.row {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.image-container {
    flex: 1;
}

.image-container img {
    max-width: 100%;
    height: auto;
}

.text-container {
    flex: 1;
    margin-left: 10px;
}

.quantity-container {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
    }
    
    .quantity-input,
    input[type="time"],
    input[type="date"] {
        margin-top: 5px;
    }
    
    .additional-info {
        display: none;
        margin-top: 5px;
        border: 1px solid #ccc;
        padding: 5px;
        background-color: #f9f9f9;
    }

.price-element,
.point-element {
    margin-top: 10px;
}

.submit-button-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-left: auto;
        margin-top: 20px; /* Add some spacing from the previous elements */
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

    .price-element,
    .point-element {
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 14px;
        width: 120px;
        text-align: center;
        margin-top: 5px;
    }
    .country-option{
        text-align:center;
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
            h1 {
                font-family: 'Playfair Display', serif;
                font-family: 'MyCustomFont', Arial, sans-serif;
                color:#1A68B2;
                font-size: 30px;
                text-align: center;
                margin-top: 50px;
                text-transform: uppercase;
                letter-spacing: 0.2em;
              }
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
                max-width: 450px;
                text-align: center;
            }
        
            /* Close button */
            .close-btn {
                position: absolute;
                top: 10px;
                right: 10px;
                cursor: pointer;
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

</style>
<style>
     body {
            background-image: url('assets/img/DSC04874.jpg'); /* Add your background image path */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif; /* Use the Montserrat font */
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Adjust the transparency by changing the last parameter */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        h1, h2 {
            color: #1A68B2;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.2em;
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


    <body>
    <h1>EXHIBITION AREA</h1>
    </body>

<?php
    $servername = "localhost";
    $username = "id19727041_ktcmembership";
    $password = "Ktcmembership123$";
    $dbname = "id19727041_ktcwebsite";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve data for Malaysian exhibitions
    $sqlMalaysian = "SELECT id, country_name, price, point, file_path FROM exhibition WHERE country_name = 'Malaysian'";
    $resultMalaysian = $conn->query($sqlMalaysian);

    // Retrieve data for non-Malaysian exhibitions
    $sqlNonMalaysian = "SELECT id, country_name, price, point, file_path FROM exhibition WHERE country_name = 'Non-Malaysian'";
    $resultNonMalaysian = $conn->query($sqlNonMalaysian);
    ?>

<!-- Display Malaysian exhibitions -->
<div class="country-option">
    <div class="btn-group" role="group" aria-label="Exhibition Type">
        <button type="button" class="btn btn-primary" onclick="showExhibitionDetails('malaysian')">Malaysian</button>
        <button type="button" class="btn btn-primary" onclick="showExhibitionDetails('non-malaysian')">Non-Malaysian</button>
    </div>
</div>
<div id="malaysian-exhibition" class="container ">
<h2>Malaysian Exhibitions</h2>
<div class="container">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <?php
        if ($resultMalaysian->num_rows > 0) {
            while ($row = $resultMalaysian->fetch_assoc()) {
                $id = $row["id"];
                $exhibitionid = isset($row["exhibition_ID"]) ? $row["exhibition_ID"] : '';
                $countryname = $row["country_name"];
                $price = $row["price"];
                $point = $row["point"];
                $file_path = $row["file_path"];
                ?>
                <div class="row">
                    
                    <div class="text-container">
                        <span><?php echo $countryname; ?> (RM<?php echo $price; ?>)</span>
                        <div class="point-elements">(<?php echo $point; ?> points)</div>
                        <div class="quantity-container <?php echo $id; ?>">
                        <label for="quantity<?php echo $id; ?>">Quantity:</label>
                        <input type="number" name="quantity[]" id="quantity<?php echo $id; ?>" class="quantity-input" min="0" max="100" value="0" onchange="updatePrice(<?php echo $price; ?>, this.value, 'price<?php echo $id; ?>', 'point<?php echo $id; ?>', <?php echo $point; ?>)">
                            <label for="booking_time<?php echo $id; ?>">Booking Time:</label>
                            <input type="time" name="booking_time[]" id="booking_time<?php echo $id; ?>" placeholder="Booking Time" min="10:00" max="18:00" onchange="validateBookingTime(this)">
                            <label for="booking_date<?php echo $id; ?>">Booking Date:</label>
                            <input type="date" name="booking_date[]" id="booking_date<?php echo $id; ?>" placeholder="Booking Date" onchange="validateBookingDate(this)">

                        </div>
                      <center>  <div class="price-element" id="price<?php echo $id; ?>">RM0</div>
                        <div class="point-element" id="point<?php echo $id; ?>">0</div></center>
                    </div>
                    <input type="hidden" name="exhibition_id[]" value="<?php echo $id; ?>">
                    <input type="hidden" name="country_name[]" value="<?php echo $countryname; ?>">
                    <input type="hidden" name="price[]" value="<?php echo $price; ?>">
                    <input type="hidden" name="point[]" value="<?php echo $point; ?>">
                    <input type="hidden" name="add_to_cart" value="1">
                    <div class="submit-button-container" id="goToPaymentContainer" style="display:none;">
                    <button class="btn3" type="submit" name="submit">Add to Cart</button>



                    </div>
                </div>
                <?php
            }
        } else {
            echo "No Malaysian exhibitions found.";
        }
        ?>
    </form>
</div>
</div>
<!-- Display non-Malaysian exhibitions -->
<div id="non-malaysian-exhibition" class="container" style="display: none;">
<h2>Non-Malaysian Exhibitions</h2>
<div class="container">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <?php
            if ($resultNonMalaysian->num_rows > 0) {
                while ($row = $resultNonMalaysian->fetch_assoc()){
                $id = $row["id"];
                $exhibitionid = isset($row["exhibition_ID"]) ? $row["exhibition_ID"] : '';
                $countryname = $row["country_name"];
                $price = $row["price"];
                $point = $row["point"];
                $file_path = $row["file_path"];
                ?>
                <div class="row">
                   
                    <div class="text-container">
                        <span><?php echo $countryname; ?> (RM<?php echo $price; ?>)</span>
                        <div class="point-elements">(<?php echo $point; ?> points)</div>
                        <div class="quantity-container <?php echo $id; ?>">
                            <label for="quantity<?php echo $id; ?>">Quantity:</label>
                            <input type="number" name="quantity[]" id="quantity<?php echo $id; ?>" class="quantity-input-non-malaysian" min="0" max="100" value="0" onchange="updatePrice(<?php echo $price; ?>, this.value, 'price<?php echo $id; ?>', 'point<?php echo $id; ?>', <?php echo $point; ?>)">
                            <label for="booking_time<?php echo $id; ?>">Booking Time:</label>
                            <input type="time" name="booking_time[]" placeholder="Booking Time" min="10:00" max="18:00" onchange="validateBookingTime(this)">
                            <label for="booking_date<?php echo $id; ?>">Booking Date:</label>
                            <input type="date" name="booking_date[]" placeholder="Booking Date" onchange="validateBookingDate(this)">
                        </div>
                      <center>  <div class="price-element" id="price<?php echo $id; ?>">RM0</div>
                        <div class="point-element" id="point<?php echo $id; ?>">0</div></center>
                    </div>
                    <input type="hidden" name="exhibition_id[]" value="<?php echo $id; ?>">
                    <input type="hidden" name="country_name[]" value="<?php echo $countryname; ?>">
                    <input type="hidden" name="price[]" value="<?php echo $price; ?>">
                    <input type="hidden" name="point[]" value="<?php echo $point; ?>">
                    <input type="hidden" name="add_to_cart" value="1">
                    <div class="submit-button-container" id="goToPaymentContainerNonMalaysian" style="display:none;">
                    <button class="btn3" type="submit" name="submit">Add to Cart</button>



                    </div>
                </div>
                <?php
            }
        } else {
            echo "No non-Malaysian exhibitions found.";
        }
        ?>
    </form>
</div>
</div>

<script>
function viewInvoice() {
    // Get exhibition details from the form
    var exhibitionIds = document.getElementsByName("exhibition_id[]");
    var countrynames = document.getElementsByName("country_name[]");
    var quantities = document.getElementsByName("quantity[]");
    var bookingTimes = document.getElementsByName("booking_time[]");
    var bookingDates = document.getElementsByName("booking_date[]");
    var prices = document.getElementsByName("price[]");
    var points = document.getElementsByName("point[]");

    // Process the exhibition details
    var exhibitionDetails = [];

    for (var i = 0; i < exhibitionIds.length; i++) {
        var id = exhibitionIds[i].value;
        var quantity = quantities[i].value;

        if (quantity > 0) {
            exhibitionDetails.push({
                'exhibitionId': id,
                'countryName': countrynames[i].value,
                'quantity': quantity,
                'bookingTime': bookingTimes[i].value,
                'bookingDate': bookingDates[i].value,
                'price': prices[i].value,
                'point': points[i].value
            });
        }
    }

    // Store exhibition details in the session
    <?php echo "var sessionURL = '$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]';"; ?>
    window.location.href = 'exhibition_generate_invoice.php?exhibitionDetails=' + encodeURIComponent(JSON.stringify(exhibitionDetails)) + '&redirect=' + encodeURIComponent(sessionURL);
}

</script>

<script>
    function updatePrice(price, quantity, priceElementId, pointElementId, point) {
        var totalPrice = price * quantity;
        var priceElement = document.getElementById(priceElementId);
        priceElement.innerHTML = 'RM' + totalPrice;

        var totalPoint = point * quantity;
        var pointElement = document.getElementById(pointElementId);
        pointElement.innerHTML = totalPoint + ' point added';

        // Calculate and update the total price and total point
        var quantityInputs = document.getElementsByClassName('quantity-input');
        var totalPriceSum = 0;
        var totalPointSum = 0;

        for (var i = 0; i < quantityInputs.length; i++) {
            var input = quantityInputs[i];
            var currentPrice = parseInt(input.value) * parseInt(input.getAttribute('data-price'));
            totalPriceSum += currentPrice;
            totalPointSum += parseInt(input.value) * parseInt(input.getAttribute('data-point'));
        }

        document.getElementById('total-price').innerHTML = 'Total Price: RM' + totalPriceSum;
        document.getElementById('total-point').innerHTML = 'Total Points: ' + totalPointSum;
    }
</script>

<script>
    function openPaymentForm() {
        // Display the overlay and popup form
        document.getElementById("paymentOverlay").style.display = "block";
    }

    function closePaymentForm() {
        // Hide the overlay and popup form
        document.getElementById("paymentOverlay").style.display = "none";
    }
</script>
<script>
    function openPaymentForm2() {
        // Display the overlay and popup form
        document.getElementById("paymentOverlay2").style.display = "block";
    }

    function closePaymentForm2() {
        // Hide the overlay and popup form
        document.getElementById("paymentOverlay2").style.display = "none";
    }
</script>
<script>
    // JavaScript function to handle showing/hiding the "Go To Payment" button
    function handleQuantityChange() {
        // Get all the select elements with class "quantity-input"
        const quantitySelects = document.querySelectorAll('.quantity-input');
        let showPaymentButton = false;

        // Check if any of the select elements have a selected value greater than 0
        quantitySelects.forEach(select => {
            if (parseInt(select.value) > 0) {
                showPaymentButton = true;
            }
        });

        // Show or hide the "Go To Payment" button based on the showPaymentButton variable
        const goToPaymentContainer = document.getElementById('goToPaymentContainer');
        goToPaymentContainer.style.display = showPaymentButton ? 'block' : 'none';
    }

    // Add an event listener to each select element to call the handleQuantityChange function on change
    const quantitySelects = document.querySelectorAll('.quantity-input');
    quantitySelects.forEach(select => {
        select.addEventListener('change', handleQuantityChange);
    });
</script>
<script>
    // JavaScript function to handle showing/hiding the "Go To Payment" button for non-Malaysian exhibitions
function handleQuantityChangeNonMalaysian() {
    // Get all the select elements with class "quantity-input"
    const quantitySelectsNonMalaysian = document.querySelectorAll('.quantity-input-non-malaysian');
    let showPaymentButtonNonMalaysian = false;

    // Check if any of the select elements have a selected value greater than 0
    quantitySelectsNonMalaysian.forEach(select => {
        if (parseInt(select.value) > 0) {
            showPaymentButtonNonMalaysian = true;
        }
    });

    // Show or hide the "Go To Payment" button based on the showPaymentButton variable
    const goToPaymentContainerNonMalaysian = document.getElementById('goToPaymentContainerNonMalaysian');
    goToPaymentContainerNonMalaysian.style.display = showPaymentButtonNonMalaysian ? 'block' : 'none';
}

// Add an event listener to each select element for non-Malaysian exhibitions to call the handleQuantityChangeNonMalaysian function on change
const quantitySelectsNonMalaysian = document.querySelectorAll('.quantity-input-non-malaysian');
quantitySelectsNonMalaysian.forEach(select => {
    select.addEventListener('change', handleQuantityChangeNonMalaysian);
});

</script>
<script>
    function handlePaymentOption(id, option) {
        const fileInput = document.getElementById('file' + id);
        const additionalInfoContainer = document.getElementById('additional-info' + id);
        
        if (option === 'bank') {
            fileInput.style.display = 'block';
            additionalInfoContainer.style.display = 'block';
        } else {
            fileInput.style.display = 'none';
            additionalInfoContainer.style.display = 'none';
        }
    }

    function validateBookingDate(dateInput) {
        // ... Existing validateBookingDate function ...
    }
</script>


<script>
    function validateBookingTime(timeInput) {
        const selectedTime = timeInput.value;

        if (selectedTime >= "12:00" && selectedTime < "13:00") {
            alert("Booking time cannot be between 12 pm and 1 PM.");
            timeInput.value = '';
        }
    }
</script>



<script>
    function showExhibitionDetails(option) {
        const malaysianExhibition = document.getElementById('malaysian-exhibition');
        const nonMalaysianExhibition = document.getElementById('non-malaysian-exhibition');

        if (option === 'malaysian') {
            malaysianExhibition.style.display = 'block';
            nonMalaysianExhibition.style.display = 'none';
        } else if (option === 'non-malaysian') {
            malaysianExhibition.style.display = 'none';
            nonMalaysianExhibition.style.display = 'block';
        }
    }
</script>


 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</BODY>
</HTML>