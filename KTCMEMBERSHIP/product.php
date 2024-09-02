<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION["rec_id"])) {
  header("Location: ./index.php");
  exit();
}

// Database connection
$servername = "localhost";
$username = "id19727041_ktcmembership"; 
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);  

// Get products
$sql = "SELECT * FROM product";
$result = $conn->query($sql);

// Form submit
if(isset($_POST['addToCart'])) {

foreach($_POST['quantity'] as $productId => $quantity) {

  if ($quantity == 0) {
    continue; 
  }
  
  // Get the product details from the database result
  $result->data_seek($productId);
  $row = $result->fetch_assoc();
  
  $productName = $row['product_name'];  
  $price = $row['price'];
  $points = $row['point'];  
  
  $totalPrice = $price;
  $totalPoints = $points;  
    
  addToCart("Product", $productName, $quantity, $totalPrice, $totalPoints, '', '', date('Y-m-d H:i:s'));

}

  header('Location: cart.php');
  exit();
}

// Add product to cart
function addToCart($type, $name, $quantity, $totalPrice, $totalPoints, $bookingTime, $bookingDate, $dateTime) 
{date_default_timezone_set('Asia/Kuala_Lumpur');
  $dateTime = date('Y-m-d H:i:s');

  // Initialize cart array
  if(!isset($_SESSION['cart_items'])) {
    $_SESSION['cart_items'] = array();
  }

  // Add item to cart
  $_SESSION['cart_items'][] = array(
    'type' => $type,
    'program' => $name, 
    'quantity' => $quantity,
    'price' => $totalPrice,
    'points' => $totalPoints,
    'booking_time' => $bookingTime,
    'booking_date' => $bookingDate,
    'date_time' => $dateTime,
    'total_price' => $totalPrice,
    'total_points' => $totalPoints
  ); 
  $totalPrice = $_POST['total_price'][$productId]; 
$totalPoints = $_POST['total_points'][$productId];
}

?>

<!DOCTYPE html>
<HTML>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<HEAD>
<TITLE>Product</TITLE><link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
<link href="assets/css/phppot-style.css" type="text/css"
	rel="stylesheet" />
<link href="assets/css/user-registration.css" type="text/css"
	rel="stylesheet" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
        console.log('$_POST:', <?php echo json_encode($_POST); ?>);
        console.log('$_SESSION:', <?php echo json_encode($_SESSION); ?>);
    </script>
</HEAD>

<style>
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
/* Common styles for both larger and smaller screens */

/* The Modal (background) */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.9);
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content,
#caption {
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {
    -webkit-transform: scale(0);
  }
  to {
    -webkit-transform: scale(1);
  }
}

@keyframes zoom {
  from {
    transform: scale(0);
  }
  to {
    transform: scale(1);
  }
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

.quantity-input{
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
/* Styles specific to larger screens */
@media only screen and (min-width: 701px) {
  #myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }

  #myImg:hover {
    opacity: 0.7;
  }

  body {
    background-image: url('assets/img/DSC04744.jpg'); /* Add your background image URL here */
    background-size: cover;
}

  .center-container {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .form-container {
    background-color: rgba(255, 255, 255, 0.8);
    margin: 0 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 20px;
    
    width: 1000px;
    box-shadow: 3px 3px 8px 5px #888888;
    backdrop-filter: blur(10px);
  }

  .row {
    display: flex;
    align-items: center;
  }

  .image-container {
    margin-right: 10px;
  }

  .text-container {
    flex: 1;
  }

  .column {
    flex: 1;
  }

  .column+.column {
    margin-left: 10px;
  }

  .row img {
    max-width: 100%;
    cursor: pointer;
  }

  .image-container {
    flex: 1;
    max-width: 150px;
  }

  .image-container img {
    width: 100%;
  }

  .text-container {
    flex: 2;
    display: flex;
    align-items: center;
    margin-left: 10px;
  }

  .quantity-input {
    margin-right: 5px;
  }

  .price-element {
    font-size: 15px;
    font-weight: bold;
    margin-left: 10px;
  }

  .total-price {
    font-size: 15px;
    font-weight: bold;
  }

  .total-price-container {
    text-align: center;
    font-weight: bold;
  }

  .submit-button-container {
    text-align: center;
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
      margin: auto;
      text-align: center;
      font-family: Arial;
      border-radius: 5px;
      overflow: hidden;
      background:#e6f0fa;
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
/* Styles specific to smaller screens (max-width: 400px) */
@media only screen and (max-width: 400px) {
  #myImg {
    /* Modify styles for smaller screens here */
    border-radius: 3px;
    cursor: pointer;
    transition: 0.2s;
  }

  #myImg:hover {
    opacity: 0.8;
  }

  body {
    /* Modify body background for smaller screens here */
    background-color: #ffffff;
  }

  .center-container {
    /* Modify center-container styles for smaller screens here */
    display: block;
    text-align: center;
  }

  .form-container {
    /* Modify form-container styles for smaller screens here */
    width: 90%;
    padding: 10px;
    border-radius: 10px;
    box-shadow: none;
    background-color: #f8f9f9;
    margin: 10px auto;
    background-color:#ffeb54;
  }

  .row {
    /* Modify row styles for smaller screens here */
    display: block;
  }

  .image-container {
    /* Modify image-container styles for smaller screens here */
    margin: 0 auto;
    max-width: 200px;
  }

  .image-container img {
    /* Modify image size for smaller screens here */
    width: 100%;
    max-width: 180px;
  }

  .text-container {
    /* Modify text-container styles for smaller screens here */
    margin: 10px auto;
    text-align: center;
  }

  .column+.column {
    /* Remove margin between columns for smaller screens */
    margin-left: 0;
  }

  .price-element {
    /* Modify price element styles for smaller screens here */
    font-size: 13px;
    margin-left: 5px;
  }

  .total-price {
    /* Modify total price styles for smaller screens here */
    font-size: 13px;
    font-weight: bold;
  }

  .total-price-container {
    /* Modify total price container styles for smaller screens here */
    font-weight: normal;
    font-weight: bold;
  }

  .submit-button-container {
    /* Modify submit button container styles for smaller screens here */
    text-align: center;
    margin-top: 20px;
  }
  .fillin{
              box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
              width: 300px; 
              margin: auto;
              font-size:12px;
              text-align: center;
              font-family: Arial;
              border-radius: 5px;
              overflow: hidden;
              background:#e6f0fa;
            }
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
            
            .other-card h1 {
              font-family: 'MyOtherCustomFont', Arial, sans-serif;
              color:#1A68B2;
              font-size: 30px;
              text-align: center;
            }
        }
    </style>

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

  <script>
        // JavaScript function to set the height of the container
        function setFormContainerHeight() {
            var formContainer = $('.form-container');
            var formContent = $('#form-content');
            var formHeight = formContent.height();
            formContainer.height(formHeight);
        }

        $(document).ready(function() {
            setFormContainerHeight(); // Call the function on page load
        });
    </script>

<br>
<div class="other-card"><br>
    <h1>PRODUCT</h1>
  </div><br>
<div class="center-container">
<div class="form-container">
<div id="myModal" class="modal">
  <span class="close" onclick="closeModal()">&times;</span>
  <img class="modal-content" id="modalImg">
  <div id="caption"></div>
</div>
<?php
$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, product_ID, product_name, price, point, file_path FROM product";
$result = $conn->query($sql);

?>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" id="product-form">
    <div class="fillin">
    <p style="margin-top:8px;">Fill in the following details for your selected products:</p>
    </div>
    <input type="hidden" name="program[<?php echo $row['id']; ?>]" value="<?php echo $row['product_name']; ?>">

<input type="hidden" name="price[<?php echo $row['id']; ?>]" value="<?php echo $row['price']; ?>">

<input type="hidden" name="points[<?php echo $row['id']; ?>]" value="<?php echo $row['point']; ?>">

  <input type="hidden" name="total_price[<?php echo $row['id']; ?>]" value="0">

  <input type="hidden" name="total_points[<?php echo $row['id']; ?>]" value="0">


    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $productid = isset($row["product_ID"]) ? $row["product_ID"] : '';
            $productname = $row["product_name"];
            $price = $row["price"];
            $point = $row["point"];
            $file_path = $row["file_path"];
            ?>
            <div class="row">
    <div class="image-container">
        <img id="myImg<?php echo $id; ?>" src="<?php echo $file_path; ?>" alt="<?php echo $productname; ?>" onclick="openModal('<?php echo $file_path; ?>', '<?php echo $productname; ?>', <?php echo $price; ?>, <?php echo $point; ?>)">
    </div>
    <div class="text-container">
        <span><?php echo $productname; ?> (RM<?php echo $price; ?>)</span>
    </div>
    
    <div class="column">
    <div class="quantity-container <?php echo $id; ?>">
        <!--<p>
            <label for="quantity<?php echo $id; ?>">Quantity:</label>
        </p>-->
        <p>
        <select class="quantity-input" name="quantity[]" data-product-id="<?php echo $productid; ?>" id="quantity<?php echo $id; ?>" data-point="<?php echo $point; ?>" onchange="updatePrice(<?php echo $price; ?>, this.value, 'price<?php echo $id; ?>', <?php echo $point; ?>)">
    <option value="0">Select Quantity</option>
    <?php for ($i = 0; $i <= 50; $i++) { ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
    <?php } ?>
</select>



        </p>
    </div>
</div>

    <!-- Price Column -->
    <div class="column">
        <div class="price-element" id="price<?php echo $id; ?>">RM0</div>
    </div>
    <!-- Point Column -->
    
    <!-- Quantity Column -->

    <!-- Include the product ID as a hidden field within each row -->
    <input type="hidden" name="product_id[]" value="<?php echo $id; ?>">
</div>

        <?php
        }
    } else {
        echo "No products found.";
    }
    ?>


    <div class="row">
        <div class="total-price-container">
            <span id="total-price"></span>
        </div>
        <div class="total-point-container">
            <span id="total-point"></span>
        </div>
    </div>
    <div class="submit-button-container" id="goToPaymentContainer" style="display:none;">
    <button class="btn3" type="submit" name="addToCart">Add to Cart</button>
      </div>
</form>


  </div>
</div>


<br><br>
<script>
// JavaScript function to handle form submission
function updateCartDetails() {
    // Get all quantity inputs
    var quantityInputs = document.querySelectorAll('.quantity-input');

    // Create an array to store program details
    var programDetails = [];

    // Loop through each quantity input
    quantityInputs.forEach(function (input) {
        var quantity = parseInt(input.value);
        var productId = input.getAttribute('data-product-id');
        var priceElementId = 'price' + productId;
        var priceElement = document.getElementById(priceElementId);

        // Check if the price element exists
        if (priceElement) {
            var priceText = priceElement.textContent;

            if (!isNaN(quantity) && quantity > 0) {
                var matches = priceText.match(/(\d+\.\d{1,2})/); // Extract numeric value from price text

                if (matches) {
                    var price = parseFloat(matches[0]);
                    var points = parseInt(input.getAttribute('data-point'));

                    // Add program details to the array
                    programDetails.push({
                        productId: productId,
                        quantity: quantity,
                        price: price,
                        points: points,
                    });
                }
            }
        }
    });

    // Debug: Display program details in the console
    console.log('Program Details:', programDetails);

    // Set the program details in hidden inputs (for PHP processing)
    document.getElementById('program_details').value = JSON.stringify(programDetails);

    // Calculate and set total price and total point in hidden inputs
    calculateTotals(programDetails);
}



  
</script>
<script>
function updateTotals(productId, price, points) {

  var quantity = document.querySelector('[name="quantity['+productId+']"]').value;
  
  var totalPrice = quantity * price;
  var totalPoints = quantity * points;

  // Update hidden total price and points inputs
  document.querySelector('[name="total_price['+productId+']"]').value = totalPrice;  
  document.querySelector('[name="total_points['+productId+']"]').value = totalPoints;

}  
</script>
<script>

function calculateTotal(productId, price, points) {

  var quantity = document.querySelector('[name="quantity['+productId+']"]').value;
  
  var totalPrice = quantity * price;
  var totalPoints = quantity * points;

  document.querySelector('[name="total_price['+productId+']"]').value = totalPrice;  
  document.querySelector('[name="total_points['+productId+']"]').value = totalPoints;

}

</script>

<script>
    // JavaScript function to calculate and set total price and total point
    function calculateTotals(programDetails) {
        var totalPrice = 0;
        var totalPoint = 0;

        // Loop through program details and calculate totals
        programDetails.forEach(function (program) {
            totalPrice += program.price * program.quantity;
            totalPoint += program.points * program.quantity;
        });

        // Set total price and total point in hidden inputs
        document.getElementById('total-price-input').value = totalPrice.toFixed(2);
        document.getElementById('total-point-input').value = totalPoint;
    }
</script>


<script>
function viewInvoice() {
    // Retrieve product details from the form
    var productDetails = getProductDetails();

    // Log product details to the console for debugging
    console.log('Product Details:', productDetails);

    // Check if there are selected products
    if (productDetails.length > 0) {
        // Convert product details to JSON
        var productDetailsJSON = JSON.stringify(productDetails);

        // Log the constructed URL for debugging
        console.log('Constructed URL:', 'productInvoice.php?productDetails=' + productDetailsJSON);

        // Open the invoice PDF with product details in the URL
        window.location.href = 'productInvoice.php?productDetails=' + encodeURIComponent(productDetailsJSON);
    } else {
        // Display an alert or handle the case where no products are selected
        alert('Please select products before viewing the invoice.');
    }
}

// Function to retrieve product details from the form
function getProductDetails() {
    var productDetails = [];

    // Get all elements with the class "quantity-input"
    var quantityInputs = document.querySelectorAll('.quantity-input');

    // Loop through each quantity input
    quantityInputs.forEach(function (input) {
        // Get the quantity value
        var quantity = parseInt(input.value);

        // Get the product ID (assuming product ID is stored in the data-product-id attribute)
        var productId = input.getAttribute('data-product-id');

        // If quantity is greater than 0, add product details to the array
        if (!isNaN(quantity) && quantity > 0 && productId) {
            productDetails.push({
                productId: productId,
                quantity: quantity
            });
        }
    });

    return productDetails;
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
    // Call the handleQuantityChange function initially to set the initial state
handleQuantityChange();

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
    function handlePaymentMethodChange(paymentMethod) {
        const fileContainer = document.getElementById('file-container');

        if (paymentMethod === 'cash') {
            fileContainer.style.display = 'none';
        } else {
            fileContainer.style.display = 'block';
        }
    }
</script>

<script>
  var modal = document.getElementById("myModal");
  var modalImg = document.getElementById("modalImg");
  var captionText = document.getElementById("caption");

  function openModal(filePath, productName, price, point) {
    modal.style.display = "block";
    modalImg.src = filePath;
    captionText.innerHTML = productName;

    // Additional logic for handling price and point
    // ...
  }

  function closeModal() {
    modal.style.display = "none";
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </BODY>
</HTML>
