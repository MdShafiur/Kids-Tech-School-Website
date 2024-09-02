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

// Date/time variable
$dateTime = date('Y-m-d H:i:s');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Initialize an array to store class details
    $classDetails = [];

    // Inside the loop where you process the form submission
    foreach ($_POST['quantity'] as $className => $quantity) {
        // Check if 'className' is set in $_POST
        if (isset($_POST['className'][$className])) {
            // Get form data
            $programName = $_POST['className'][$className];
            $price = $_POST['price'][$className];
            $points = $_POST['point'][$className];

            // Call the addToCart function only if quantity is greater than 0
            if ($quantity > 0) {
                // Set booking_date and booking_time to empty strings
                addToCart('Class', $programName, $quantity, $price, $points, '', '', $dateTime);

                // Add class details to the array
                $classDetails[] = [
                    'className' => $programName,
                    'quantity' => $quantity,
                    'price' => $price,
                    'points' => $points
                ];
            }
        } else {
            // Log an error or handle the case where 'className' is not set
            echo 'Error: className is not set for class ' . $className;
        }
    }

    // Return a response if needed
    echo 'Items added to cart successfully.';

    // Redirect to cart.php
    header('Location: cart.php');
    exit(); // Don't forget to exit to prevent further execution
}




// Updated addToCart function
function addToCart($type, $programName, $quantity, $price, $points,$bookingTime,$bookingDate, $dateTime)
{ date_default_timezone_set('Asia/Kuala_Lumpur');
    $dateTime = date('Y-m-d H:i:s');
    
    // Initialize cart_items if not set
    if (!isset($_SESSION['cart_items']) || !is_array($_SESSION['cart_items'])) {
        $_SESSION['cart_items'] = [];
    }

    // Add to cart array
    $_SESSION['cart_items'][] = array(
        'type' => $type,
        'program' => $programName,
        'quantity' => $quantity,
        'price' => $price,
        'points' => $points,
        'booking_time' => $bookingTime,
        'booking_date'=> $bookingDate,
        'date_time' => $dateTime
    );

    // Log a message to the console
    echo '<script>console.log("Item added to cart:", ' . json_encode($type) . ', ' . json_encode($programName) . ', ' . json_encode($quantity) . ', ' . json_encode($price) . ', ' . json_encode($points) . ', ' . json_encode($bookingTime) . ', ' . json_encode($bookingDate) . ', ' . json_encode($dateTime) . ');</script>';

    // Return true to allow the form submission to proceed
    return true;
}


?>

<!DOCTYPE html>
<HTML>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<HEAD>
<TITLE>Class</TITLE><link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
<link href="assets/css/phppot-style.css" type="text/css"
	rel="stylesheet" />
<link href="assets/css/user-registration.css" type="text/css"
	rel="stylesheet" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script>
function addToCart() {
    // Get form data
    var programName = document.querySelector('input[name="class_name"]:checked').value;
    var quantity = document.getElementById('quantity-' + programName).value;
    var price = document.getElementById('price-' + programName).textContent;
    var points = document.getElementById('quantity-' + programName).dataset.points;

    // Call the addToCart function
    $.ajax({
        type: 'POST',
        url: 'class.php',
        data: {
            submit: true,
            programName: programName, // Change 'programName' to match the variable used in addToCart
            quantity: quantity,
            price: price,
            point: points
        },
        success: function (response) {
            // Handle the success response
            console.log(response);
        },
        error: function (error) {
            // Handle the error response
            console.error(error);
        }
    });

    return false; // Prevent the default form submission
}
</script>

<style>
@font-face {
    font-family: 'MyCustomFont';
    src: url('assets/css/Varietykiller.otf') format('truetype');
}

@font-face {
    font-family: 'MyOtherCustomFont';
    src: url('assets/css/RifficFreeBold.ttf') format('truetype');
}

body {
    background-image: url('assets/img/DSC04973.jpg'); /* Replace with your image path */
    background-size: cover;
    background-repeat: no-repeat;
    font-family: 'Arial', sans-serif;
    margin: 0;
}

h1 {
    color: black;
    text-align: center;
}

.other-card h1 {
    font-family: 'MyOtherCustomFont', Arial, sans-serif;
    color: #1A68B2;
    font-size: 50px;
    text-align: center;
}

.container {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    border: 1px solid #ccc;
    border-radius: 20px;
    margin: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: rgba(255, 255, 255, 0.8); /* Adjust the alpha value for transparency */
    backdrop-filter: blur(10px); /* Adjust the blur effect for transparency */
    width: 700px;
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

.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}

.btn3 {
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

@media (max-width: 400px) {
    nav {
        display: flex;
        justify-content: center;
        padding: 5px;
        background-color: #333;
    }

    nav .navbar-brand {
        font-size: 12px;
    }

    .w3-bar-item {
        display: block;
        text-align: center;
        padding: 3px;
        font-size: 10px;
        white-space: nowrap;
    }

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

    .page-content {
        padding: 5px;
        font-size: 12px;
    }

    .container {
        border: 1px solid #ccc;
        border-radius: 8px;
        margin: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        width: 330px;
    }

    .fillin {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        width: 320px;
        text-align: center;
        font-family: Arial;
        font-size: 12px;
        border-radius: 5px;
        overflow: hidden;
        background: #e6f0fa;
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
            .container {
              border: 1px solid #ccc; /* Border style */
              border-radius: 8px; /* Border radius */
              margin: 10px; /* Margin around the container */
              display: flex; /* Use flexbox to align items */
              flex-direction: column; /* Stack elements vertically within the container */
              align-items: center; /* Center items horizontally within the container */
              background-color:#ffeb54;
              width:330px;
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
    /* Styling for form elements and other CSS as needed */
    /* ... */

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
              width: 300px; 
              text-align: center;
              font-family: Arial;
              font-size:10px;
              border-radius: 5px;
              overflow: hidden;
              background:#e6f0fa;
            }
        }
    </style>
</HEAD>

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
<br>
    <div class="other-card"><br>
    <h1>CLASS</h1>
  </div>
    
    <form method="POST" action="class.php" enctype="multipart/form-data" onsubmit="return addToCart()">
    <div style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
    <?php
$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM class";
$result = mysqli_query($conn, $sql);

$containerHtml = '<div class="container">';
$containerHtml .= '<div class="fillin">';
$containerHtml .= '<p style="margin-top: 8px;">Fill in the following details for your selected classes:</p>';
$containerHtml .= '</div>';
$cardHtml = ''; // Initialize $cardHtml

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $className = $row['class_name'];
        $price = $row['price'];
        $point = $row['point'];
        $filePath = $row['file_path'];


        $containerHtml .= '<div class="program-info">';
        $containerHtml .= '<h4><b><br>' . $className . '</b></h4>';
        $containerHtml .= '</div>';
        $containerHtml .= '<div class="program-details">';
        $containerHtml .= '<div class="image-container">';
        $containerHtml .= '<img src="' . $filePath . '" alt="Picture" style="width:100px; height:auto; float:left; margin-right:10px;">';
        $containerHtml .= '</div>';
        $containerHtml .= '<div class="content-container">';
        $containerHtml .= '<p id="price-' . $className . '">RM ' . $price . ' and ' . $point . ' redeem points</p>';
        $containerHtml .= '<select class="quantity-input" name="quantity[' . htmlspecialchars($className, ENT_QUOTES) . ']" id="quantity-' . htmlspecialchars($className, ENT_QUOTES) . '" onchange="updatePrice(' . $price . ', this.value, \'price-' . htmlspecialchars($className, ENT_QUOTES) . '\', ' . $point . ', \'' . htmlspecialchars($className, ENT_QUOTES) . '\')">';
        $containerHtml .= '<option value="0">Select Quantity</option>';
        for ($i = 0; $i <= 50; $i++) {
            $containerHtml .= '<option value="' . $i . '">' . $i . '</option>';
        }
        $containerHtml .= '</select>';

        $containerHtml .= '<input type="hidden" name="className[' . htmlspecialchars($className, ENT_QUOTES) . ']" value="' . htmlspecialchars($className, ENT_QUOTES) . '">';
        $containerHtml .= '<input type="hidden" name="price[' . $className . ']" value="' . $price . '">';
        $containerHtml .= '<input type="hidden" name="point[' . $className . ']" value="' . $point . '">';
        $containerHtml .= '</div>';
        $containerHtml .= '<div style="clear:both;"></div>';
        $containerHtml .= '</div>';
    }
} else {
    $containerHtml .= '<p>No programs found.</p>';
}

$conn->close();
?>

<div style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
    <?php echo $cardHtml; // Display all the unique cards at the top ?>
    <div style="clear:both;"></div> <!-- Add a clear element to separate the top and bottom sections -->
    <?php echo $containerHtml; // Display all the containers at the bottom ?>
    <br><div class="row">
        <div class="total-price-container">
            <span id="total-price"></span>
        </div>
        <div class="total-point-container">
            <span id="total-point"></span>
        </div>
    </div>
    
    <div class="submit-button-container" id="goToPaymentContainer" style="display:none;">
    <button class="btn3" type="submit" name="submit">Add to Cart</button>

</div>

    <div class="overlay" id="paymentOverlay">
    <div class="popup">
        <span class="close-btn" onclick="closePaymentForm()">&times;</span>
        <h3>Payment Details</h3>
        <!-- Include the payment form here -->
        <form id="payment-form" method="post" action="update_payment.php">
            <div class="payment-method-container">
            <label>Payment Method:</label>
            <div class="payment-method-option">
                <input type="radio" name="payment_method" value="cash" id="cash">
                <label for="cash">Cash</label>
            </div>
            <div class="payment-method-option">
                <input type="radio" name="payment_method" value="bank" id="bank">
                <label for="bank">Bank</label>
            </div>
        </div>
        <div class="file-container">
            <label for="file">Proof of Purchase:</label>
            <input type="file" name="file" id="file"><br>
            <img id="myFileImg" src="assets/img/qrcode.jpg" alt="Small Image" onclick="openFileModal()">
            <!-- Transfer to account: Provided Information -->
            <div class="transfer-to-account">Transfer to account:</div>
            <div class="cimb-bank">CIMB Bank</div>
            <div class="dreamedge">DreamEDGE Sdn Bhd</div>
            <div class="account-number">8603743834</div>
        </div>
        <div class="submit-button-container">
            <button type="submit" class="submit-button-payment">Submit Payment</button>
        </div>
        </form>
    </div>
</div>

<div class="row">
        <div class="total-price-container">
            <span id="total-price"></span>
        </div>
        <div class="total-point-container">
            <span id="total-point"></span>
        </div>
    </div>
</form>


<script>
function viewInvoice() {
    // Retrieve program details from the form
    var classDetails = getClassDetails();

    // Log class details to the console for debugging
    console.log('Class Details:', classDetails);

    // Check if there are selected programs
    if (classDetails.length > 0) {
        // Convert program details to JSON
        var classDetailsJSON = JSON.stringify(classDetails);

        // Log the constructed URL for debugging
        console.log('Constructed URL:', 'classInvoice.php?classDetails=' + classDetailsJSON);

        // Open the invoice PDF with program details in the URL
        window.location.href = 'classInvoice.php?classDetails=' + encodeURIComponent(classDetailsJSON);
    } else {
        // Display an alert or handle the case where no classes are selected
        alert('Please select classes before viewing the invoice.');
    }
}



// Function to retrieve program details from the form
function getClassDetails() {
    var classDetails = [];

    // Get all elements with the class "quantity-input"
    var quantityInputs = document.querySelectorAll('.quantity-input');

    // Loop through each quantity input
    quantityInputs.forEach(function (input) {
        // Get the quantity value
        var quantity = parseInt(input.value);

        // Get the class name (assuming class name is stored as a data attribute)
// Extract the class name from the 'name' attribute
var matches = /quantity\[(.*?)\]/.exec(input.getAttribute('name'));

console.log('Matches:', matches);

var className = matches && matches[1] ? matches[1] : null; // Use the captured class name

console.log('Class Name:', className);

        // If quantity is greater than 0, add class details to the array
        if (!isNaN(quantity) && quantity > 0 && className) {
            classDetails.push({
                className: className,
                quantity: quantity
            });
        }
    });

    return classDetails;
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
    function showFileUpload() {
        var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        var fileUpload = document.querySelector('input[name="file"]');
        
        if (paymentMethod === "cash") {
            fileUpload.style.display = "none";
        } else {
            fileUpload.style.display = "block";
        }
    }
    
    // Add event listener to the radio buttons
    var paymentRadioButtons = document.querySelectorAll('input[name="payment_method"]');
    paymentRadioButtons.forEach(function(radioButton) {
        radioButton.addEventListener('click', showFileUpload);
    });
</script>

<script>
    // Function to open the payment details popup
    function openPaymentForm() {
        document.getElementById("paymentOverlay").style.display = "block";
    }

    // Function to close the payment details popup
    function closePaymentForm() {
        document.getElementById("paymentOverlay").style.display = "none";
    }
</script>


<script>
var cumulativeTotalPrice = 0;
var cumulativeTotalPoint = 0;
var previousQuantities = {}; // Object to store previous quantities for each container

function updatePrice(price, quantity, elementId, point) {
  // Deduct the contribution of the previous quantity for the specific container
  var previousQuantity = previousQuantities[elementId] || 0;
  var previousTotalPrice = price * previousQuantity;
  cumulativeTotalPrice -= previousTotalPrice;
  cumulativeTotalPoint -= point * previousQuantity;

  // Calculate the total price for the current product
  var totalPrice = price * quantity;

  // Calculate the total point for the current product
  var totalPoint = point * quantity;

  // Update the price element for the current product
  document.getElementById(elementId).textContent = "RM" + totalPrice + " (+" + totalPoint + " points)";

  // Update the cumulative total price
  cumulativeTotalPrice += totalPrice;

  // Update the cumulative total point
  cumulativeTotalPoint += totalPoint;

  // Update the total price element
  var totalPriceElement = document.getElementById("total-price");
  if (cumulativeTotalPrice === 0) {
    totalPriceElement.textContent = "";
  } else {
    totalPriceElement.textContent = "Total Price: RM" + cumulativeTotalPrice.toFixed(2);
  }

  // Update the total point element
  document.getElementById("total-point").textContent = cumulativeTotalPoint + " points added";

  // Store the current quantity as the previous quantity for the specific container
  previousQuantities[elementId] = quantity;
}

function calculateTotal() {
  var priceElements = document.getElementsByClassName("price-element");
  var totalPrice = 0;

  for (var i = 0; i < priceElements.length; i++) {
    var priceElement = priceElements[i];
    var priceText = priceElement.textContent;
    var price = parseFloat(priceText.substring(2)); // Remove "RM" and convert to a number

    if (!isNaN(price)) {
      totalPrice += price;
    }
  }

  document.getElementById("total-price").textContent = "Total Price: RM" + totalPrice.toFixed(2);
}
</script>




</div>

<br>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Add this script at the end of your class.php file -->

</BODY>
</HTML>