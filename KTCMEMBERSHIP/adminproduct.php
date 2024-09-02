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

?>
<?php

$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM product";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the updated prices from the form submission
    $productPrices = $_POST["product_price"];

    // Loop through the product prices and update each product's price
    foreach ($productPrices as $productId => $newPrice) {
        // Escape the values to prevent SQL injection
        $productId = $conn->real_escape_string($productId);
        $newPrice = $conn->real_escape_string($newPrice);

        // Update the product's price
        $sql = "UPDATE product SET price = '$newPrice' WHERE id = '$productId'";

        if ($conn->query($sql) !== true) {
            echo "Error updating price for product with ID $productId: " . $conn->error;
        }
    }

    echo "Prices updated successfully.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>Product Details</title><link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
<link href="assets/css/phppot-style.css" type="text/css" rel="stylesheet" />
<link href="assets/css/user-registration.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
 body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0; /* Reset margin to ensure full width */
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
        .form-container {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .form-container label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    .form-container input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-container button {
        background-color: #4caf50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .form-container button:hover {
        background-color: #45a049;
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

        h1 {
            color: black;
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
    margin-left: 280px; /* Adjust this value based on the width of your sidebar */
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

        /*  SIDEBAR STARTS HERE  */

        #sidebar {
            background: #020509;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            overflow-y: auto;
            padding: 20px;
            -webkit-transition: all 0.5s;
            transition: all 0.5s;
        }

        .sidebar__title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #f3f4f6;
            margin-bottom: 30px;
        }

        .sidebar__img {
            display: flex;
            align-items: center;
        }

        .sidebar__title>div>img {
            width: 280px;
            object-fit: contain;
        }

        .sidebar__title>div>h1 {
            font-size: 18px;
            display: inline;
        }

        .sidebar__title>i {
            font-size: 18px;
            display: none;
        }

        .sidebar__menu>h2 {
            color: #3ea175;
            font-size: 16px;
            margin-top: 15px;
            margin-bottom: 5px;
            padding: 0 10px;
            font-weight: 700;
        }

        .sidebar__link {
            color: #f3f4f6;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 5px;
        }

        .active_menu_link {
            background: rgba(62, 161, 117, 0.3);
            color: #3ea175;
        }

        .active_menu_link a {
            color: #3ea175 !important;
        }

        .sidebar__link>a {
            text-decoration: none;
            color: #a5aaad;
            font-weight: 700;
        }

        .sidebar__link>i {
            margin-right: 10px;
            font-size: 18px;
        }

        .sidebar__logout {
            margin-top: 20px;
            padding: 10px;
            color: #e65061;
        }

        .sidebar__logout>a {
            text-decoration: none;
            color: #e65061;
            font-weight: 700;
            text-transform: uppercase;
        }

        .sidebar__logout>i {
            margin-right: 10px;
            font-size: 18px;
        }

        .sidebar_responsive {
            display: inline !important;
            z-index: 9999 !important;
            left: 0 !important;
            position: absolute;
        }

        .sidebar__link:hover {
            background: rgba(62, 161, 117, 0.3);
            color: #3ea175;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar__link>a {
            text-decoration: none;
            color: #a5aaad;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .sidebar__link:hover>a {
            color: #3ea175;
        }

        @media only screen and (min-width: 978px) {
    .navbar {
        margin-left: 360px; /* Adjust this value based on the width of your sidebar */
    }
    .form-container {
        margin-left: 360px; /* Adjust this value based on the width of your sidebar */
    }
}

        @media only screen and (max-width: 978px) {
            .container {
                grid-template-columns: 1fr;
                grid-template-rows: 0.2fr 3fr;
                grid-template-areas: "nav" "main";
            }

            #sidebar {
                display: none;
            }

            .sidebar__title>i {
                display: inline;
            }

            .nav_icon {
                display: inline;
            }
        }
</style>
</head>
<body id="body">
    <div id="sidebar">
        <div class="sidebar__title">
            <div class="sidebar__img">
                <img src="assets/img/asset-1.2.png" alt="logo" />
            </div>
            <i onclick="closeSidebar()" class="fa fa-times" id="sidebarIcon" aria-hidden="true"></i>
        </div>

        <div class="sidebar__menu">
          <div class="sidebar__link">
            <i class="fa fa-home"></i>
            <a href="adminhome.php">Dashboard</a>
          </div>
          <h2>GENERAL</h2>
          <div class="sidebar__link">
            <i class="fa fa-user-secret" aria-hidden="true"></i>
            <a href="adminpaymenthistory.php">Payment Record</a>
          </div>
          <div class="sidebar__link">
            <i class="fa fa-building-o"></i>
            <a href="customerinfo.php">Customer Info</a>
          </div>
          <h2>ACTIVITIES</h2>
          <div class="sidebar__link">
            <i class="fa fa-wrench"></i>
            <a href="adminsteamprogram.php">Steam Program</a>
          </div>
          <div class="sidebar__link">
            <i class="fa fa-archive"></i>
            <a href="adminproduct.php">Product</a>
          </div>
          <div class="sidebar__link">
            <i class="fa fa-handshake-o"></i>
            <a href="adminexhibition.php">Exhibition</a>
          </div>
          <div class="sidebar__link">
            <i class="fa fa-question"></i>
            <a href="adminclass.php">Class</a>
          </div>
          <div class="sidebar__link">
            <i class="fa fa-sign-out"></i>
            <a href="#">Leave Policy</a>
          </div>
          <div class="sidebar__link">
            <i class="fa fa-calendar-check-o"></i>
            <a href="#">Special Days</a>
          </div>
          <div class="sidebar__link">
            <i class="fa fa-files-o"></i>
            <a href="#">Apply for leave</a>
          </div>
          <h2>PAYROLL</h2>
          <div class="sidebar__link">
            <i class="fa fa-money"></i>
            <a href="#">Payroll</a>
          </div>
          <div class="sidebar__link">
            <i class="fa fa-briefcase"></i>
            <a href="#">Paygrade</a>
          </div>
          <div class="sidebar__logout">
            <i class="fa fa-power-off"></i>
            <a href="adminlogout.php">Log out</a>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="script.js"></script>
<script>

// This is for able to see chart. We are using Apex Chart. U can check the documentation of Apex Charts too..
var options = {
  series: [
    {
      name: "Net Profit",
      data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
    },
    {
      name: "Revenue",
      data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
    },
    {
      name: "Free Cash Flow",
      data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
    },
  ],
  chart: {
    type: "bar",
    height: 250, // make this 250
    sparkline: {
      enabled: true, // make this true
    },
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: "55%",
      endingShape: "rounded",
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    show: true,
    width: 2,
    colors: ["transparent"],
  },
  xaxis: {
    categories: ["Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
  },
  yaxis: {
    title: {
      text: "RM (thousands)",
    },
  },
  fill: {
    opacity: 1,
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return "RM " + val + " thousands";
      },
    },
  },
};

var chart = new ApexCharts(document.querySelector("#apex1"), options);
chart.render();

// Sidebar Toggle Codes;

var sidebarOpen = false;
var sidebar = document.getElementById("sidebar");
var sidebarCloseIcon = document.getElementById("sidebarIcon");

function toggleSidebar() {
  if (!sidebarOpen) {
    sidebar.classList.add("sidebar_responsive");
    sidebarOpen = true;
  }
}

function closeSidebar() {
  if (sidebarOpen) {
    sidebar.classList.remove("sidebar_responsive");
    sidebarOpen = false;
  }
}

</script>
    <div class="container">
      <nav class="navbar">
        
        <div class="navbar__left">
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

<br><div class="form-container">
   <div class="admin-welcome"><b>Update Product Details</b></div><br>
    <form action="updateproduct.php" method="POST" enctype="multipart/form-data">
    <?php foreach ($products as $product) {
    $productId = $product["id"];
    $productName = $product["product_name"];
    $price = $product["price"];
    $point = $product["point"];
?>
    <label for="product_name_">Product Name:</label>
    <input type="text" id="product_name_<?php echo $productId; ?>" name="product_data[<?php echo $productId; ?>][product_name]" value="<?php echo $productName; ?>" required>
    <br>
    
    <label for="product_price_">Price:</label>
    <input type="number" id="product_price_<?php echo $productId; ?>" name="product_data[<?php echo $productId; ?>][product_price]" min="0" max="1000000" value="<?php echo $price; ?>" required>
    <br>

    <label for="product_point_">Point:</label>
    <input type="number" id="product_point_<?php echo $productId; ?>" name="product_data[<?php echo $productId; ?>][product_point]" min="0" max="1000000" value="<?php echo $point; ?>" required>
    <br>

    <label for="file_<?php echo $productId; ?>">Product Image:</label>
    <input type="file" name="file_<?php echo $productId; ?>" id="file_<?php echo $productId; ?>" >
    <br>

    <button type="submit" name="update_price_<?php echo $productId; ?>">Update Price</button>
    <hr> <!-- Optional: Add a horizontal line between products -->
<?php } ?>


    </form>
    <form method="post" action="addproduct.php" enctype="multipart/form-data">
    <h2>Add New Product</h2>
    <label for="product_ID">Product ID:</label>
    <input type="text" id="product_ID" name="product_ID" required>
    <br>
    <label for="product_name">Product Name:</label>
    <input type="text" id="product_name" name="product_name" required>
    <br>
    <label for="product_price">Product Price:</label>
    <input type="number" id="price" name="price" min="0" max="100" value="0" required>
    <br>
    <label for="product_point">Product Point:</label>
    <input type="number" id="point" name="point" min="0" max="100" value="0" required>
    <br>
    <label for="file">Product Image:</label>
    <input type="file" id="file" name="file" required>
    <br>
    <button type="submit">Add Product</button>
</form>
    </div>
    </div>
</body>
</html>
