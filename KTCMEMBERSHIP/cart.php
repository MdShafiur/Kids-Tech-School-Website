<?php
session_start();

if (!isset($_SESSION["rec_id"])) {
    // Redirect to login page if the user is not logged in
    header("Location: ./index.php");
    exit();
    require 'tcpdf/tcpdf.php';

}?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart</title>
    <link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
    <link href="assets/css/phppot-style.css" type="text/css"
	rel="stylesheet" />
<link href="assets/css/user-registration.css" type="text/css"
	rel="stylesheet" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  border: 1px solid #ccc; /* Border style */
  border-radius: 20px; /* Border radius */
  margin: 10px; /* Margin around the container */
  display: flex; /* Use flexbox to align items */
  flex-direction: column; /* Stack elements vertically within the container */
  align-items: center; /* Center items horizontally within the container */
  background-color:#ffeb54;
  width:auto;
  padding-top: 30px;
  padding-bottom: 30px;
  padding-left: 30px;
  padding-right: 30px;
}

    .container th, .container td {
        padding: 10px;
        border: 1px solid #666;
    }

    .total-price-container {
        text-align: center;
        font-weight: bold;
    }

    /* Adjust width and alignment for specific columns */
    .container th:nth-child(1), .container td:nth-child(1) {
        width: 10%;
    }

    .container th:nth-child(2), .container td:nth-child(2) {
        width: 20%;
    }

    .container th:nth-child(3){
        width: 10%;
        text-align: center;
    } .container td:nth-child(3) {
        width: 25%;
        text-align: right;
        padding-right: 90px;
    }

    .container th:nth-child(4){
        width: 15%;
        text-align: center;
    } .container td:nth-child(4) {
        width: 20%;
        text-align: right;
        padding-right: 70px;
    }
    
    .container th:nth-child(5){
        width: 10%;
        text-align: center;
    } .container td:nth-child(5) {
        width: 20%;
        text-align: center;
        padding-right: 15px;
    }

    .container th:nth-child(6){
        width: 10%;
        text-align: center;
        padding-left: 50px;
    } .container td:nth-child(6) {
        width: 20%;
        text-align: right;
        padding-right: 60px;
    }

    .container th:nth-child(7){
        width: 15%;
        text-align: center;
    } .container td:nth-child(7) {
        width: 20%;
        text-align: right;
        padding-right: 50px;
    }

    .container th:nth-child(8){
        width: 15%;
        text-align: center;
    } .container td:nth-child(8) {
        width: 20%;
        text-align: right;
        padding-right: 50px;
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
    .btn1 {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 2px;
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
            margin-right: 2px;
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
    margin-right: 2px;
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
       
        <a class="navbar-brand d-flex align-items-center ms-sm-auto" href="logout.php">
            Logout
        </a>
    </div>
</nav>
<center><div class="container">
<b><h2>Cart</h2></b><br>
<?php
$cartItems = isset($_SESSION['cart_items']) && is_array($_SESSION['cart_items']) ? $_SESSION['cart_items'] : [];
$totalPrice = 0;
$totalPoints = 0;

if (!empty($cartItems)) {
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th style="padding-right: 20px, text-align: center;">Type</th>';
    echo '<th style="padding-right: 20px, text-align: center;">Program/Product</th>';
    echo '<th style="padding-right: 90px, text-align: center;">Quantity</th>';
    echo '<th style="padding-right: 70px, text-align: center;">Price (RM)</th>';
    echo '<th style="padding-right: 50px, text-align: center;">Points</th>';
    echo '<th style="padding-right: 50px; text-align: center;">Booking Time</th>';
    echo '<th style="padding-right: 50px;padding-left: 50px; text-align: center;">Booking Date</th>';
    echo '<th style="padding-right: 50px;padding-left: 50px; text-align: center;">Date/Time</th>';
    echo '</tr>';
    echo '</thead>';
    foreach ($cartItems as $item) {
        // Ensure $item is an array before trying to access its keys
        if (is_array($item)) {
            echo '<input type="hidden" name="cart_items[]" value=\''.json_encode($item).'\'>';
    
            // Additional hidden fields for each item
            echo '<input type="hidden" name="type[]" value="'.htmlspecialchars($item['type']).'">';
            echo '<input type="hidden" name="program[]" value="'.htmlspecialchars($item['program']).'">';
            echo '<input type="hidden" name="price[]" value="'.(float)$item['price'].'">';
            echo '<input type="hidden" name="points[]" value="'.(int)$item['points'].'">';
            echo '<input type="hidden" name="quantity[]" value="'.(int)$item['quantity'].'">';
            echo '<input type="hidden" name="booking_time[]" value="'.(isset($item['booking_time']) ? htmlspecialchars($item['booking_time']) : '').'">';
            echo '<input type="hidden" name="booking_date[]" value="'.(isset($item['booking_date']) ? htmlspecialchars($item['booking_date']) : '').'">';
    
            $type = $item['type'];
            $name = $item['program'];
            $quantity = is_numeric($item['quantity']) ? $item['quantity'] : 0;
            $price = is_numeric($item['price']) ? (float)$item['price'] : 0;
            $points = is_numeric($item['points']) ? (int)$item['points'] : 0;
            $bookingTime = isset($item['booking_time']) ? htmlspecialchars($item['booking_time']) : 'N/A';
            $bookingDate = isset($item['booking_date']) ? htmlspecialchars($item['booking_date']) : 'N/A';            
            $dateTime = $item['date_time'];
    
            


            $subtotal = $quantity * $price;
            $totalPrice += $subtotal;
            $totalPoints += $quantity * $points;
    
            echo '<tr>';
            echo "<td style=\"padding-right: 20px;\">$type</td>";
            echo '<td style="padding-right: 20px;">' . (is_array($name) ? implode(', ', $name) : $name) . '</td>'; // Display only the name
            echo "<td style=\"padding-right: 60px;\">$quantity</td>";
            echo "<td style=\"padding-right: 60px;\">$subtotal</td>";
            echo "<td style=\"padding-right: 15px;\">" . ($points * $quantity) . "</td>";
            echo "<td style=\"padding-right: 60px;\">" . (isset($bookingTime) ? $bookingTime : 'N/A') . "</td>";
            echo "<td style=\"padding-right: 40px;\">" . (isset($bookingDate) ? $bookingDate : 'N/A') . "</td>";
            echo "<td style=\"padding-right: 50px;\">$dateTime</td>";            
            echo '<td>';
            // Update this line to include the program name in the deleteItem function
            echo '<button class="btn4" onclick="deleteItem(\'' . htmlspecialchars($item['program'], ENT_QUOTES) . '\')">Delete</button>';
            echo '</td>';
            echo '</tr>';
        } else {
            // Log or handle the case where $item is not an array
        }
    }

    echo '<tr><td colspan="6">&nbsp;</td></tr>';
    echo '<tr>';
    echo '<td colspan="3">Total</td>';
    echo "<td>RM $totalPrice</td>";
    echo "<td>$totalPoints</td>";
    echo '</tr>';
    echo '</table><br>';
} else {
    // Cart is empty, display message and link
    echo '<b><h4>The Cart is Empty. <a href="home.php">Continue Shopping</a></h4></b>';
}
?>
<?php if (!empty($cartItems)) : ?>
    <br>
    <div class="d-flex">
        <button onclick="clearCart()" class="btn3">Clear Cart</button>
        <!--<button class="btn2 mx-2" onclick="viewInvoice()">View Invoice</button>-->
        
        <form action="payment_form.php" method="POST">
            <input type="hidden" name="cart_items" value='<?php echo json_encode($cartItems); ?>'>
            <input type="hidden" name="total_price" value='<?php echo $totalPrice; ?>'>
            <button class="btn1 mx-2" type="button" onclick="checkout()">Checkout</button>
        </form>
    </div>
<?php endif; ?>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function viewInvoice() {
        // Get cart items
        var cartItems = <?php echo json_encode($_SESSION['cart_items']); ?>;

        // Check if cartItems is not empty before proceeding
        if (cartItems === undefined || cartItems.length === 0) {
            alert('Your cart is empty.');
            return;
        }

        // Stringify as JSON
        var cartData = JSON.stringify(cartItems);

        // URL encode 
        var encodedCart = encodeURIComponent(cartData);

        // Construct invoice URL including encoded cart data
        var url = "generate_invoice.php?cart=" + encodedCart;

        // Open in a new tab/window
        window.open(url);
    }

    function clearCart() {
        // Clear the cart using AJAX
        $.ajax({
            type: 'POST',
            url: 'clear_cart.php',
            success: function (response) {
                // Reload the page to update the cart display
                location.reload();
            },
            error: function (error) {
                // Handle error response
                console.error(error);
            }
        });
    }

    function checkout() {
        // Submit the form to payment_form.php
        $('form').submit();
    }
</script>
<script>
function deleteItem(program) {
    // Use AJAX to send a request to delete_cart_item.php
    $.ajax({
        type: 'POST',
        url: 'delete_item.php',
        data: { program: program },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Reload the page to update the cart display
                location.reload();
            } else {
                // Handle error response
                console.error(response.message);
            }
        },
        error: function (error) {
            // Handle AJAX error
            console.error(error);
        }
    });
}
</script>


</div></center>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>
