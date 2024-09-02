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
<?php

if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<div class="alert alert-success">Your information has been updated.</div>';
}
?>

<!--<?php

// Connect to the database
$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

//connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Checking connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];

// SQL statement
$sql = "SELECT * FROM tbl_member WHERE email = '$email'";

// Execute the SQL statement
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
  // Output the data in a HTML table
  echo "<table>";
  while ($row = $result->fetch_assoc()) {
    echo "<tr><td>Student Name:</td><td>" . $row['studentname'] . "</td></tr>";
    echo "<tr><td>Email:</td><td>" . $row['emailstudent'] . "</td></tr>";
    echo "<tr><td>Birthdate:</td><td>" . $row['birthdate'] . "</td></tr>";
    echo "<tr><td>Parent Name:</td><td>" . $row['parentname'] . "</td></tr>";
    echo "<tr><td>Address:</td><td>" . $row['address'] . "</td></tr>";
    echo "<tr><td>School Name:</td><td>" . $row['schoolname'] . "</td></tr>";
    echo "<tr><td>Telephone Number:</td><td>" . $row['telephone'] . "</td></tr>";
    echo "<tr><td>Password:</td><td>" . $row['password'] . "</td></tr>";

  }
  echo "</table>";
} else {
  echo "No results found.";
}

// Close the database connection
$conn->close();
?>-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal Info</title>
    <link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
    <link href="assets/css/phppot-style.css" type="text/css" rel="stylesheet" />
    <link href="assets/css/user-registration.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

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
     <style>
        

        body {
            background-image: url('assets/img/DSC05017.jpg'); /* Replace with your background image */
            background-size: cover;
            background-position: center;
            color: #000000;; /* Text color on top of the background */
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8); /* White background with some transparency */
            border-radius: 10px;
            padding: 20px;
            margin-top: 50px; /* Adjust the margin as needed */
        }

        /* Add fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Apply the animation to the container */
        .container {
            animation: fadeIn 1s ease-in-out;
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

<style>
  .readonly-input {
    background-color: #f5f5f5; /* Background color to light gray */
    color: #555; /* Dark gray fon color*/
    cursor: not-allowed; /* "not-allowed" cursor when need to click over the input box */
}

.notification {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 16px;
  background-color: #fff;
  border: 1px solid #ccc;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  z-index: 9999;
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
            Cart<span class="badge bg-danger text-white position-relative" style="top: -5px;"><?php echo $count ?></span>



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
    <div class="container mt-3">
    <h2>Edit Profile Information</h2>
    <form action="update.php" method="post">
    <input type="hidden" name="rec_id" value="<?php echo $recID; ?>">
        <div class="form-group">
            <label for="rec_id">KTC ID:</label>
            <input type="text" class="form-control readonly-input" id="rec_id" name="rec_id" value="<?php echo $_SESSION['rec_id']; ?>" readonly>
        </div>
        
        <div class="form-group">
            <label for="parentname">Parent Name:</label>
            <input type="text" class="form-control" id="parentname" name="parentname" value="<?php echo $_SESSION['parentname']; ?>">
        </div>
       
        <div class="form-group">
            <label for="studentname">Student Name:</label>
            <input type="text" class="form-control" id="studentname" name="studentname" value="<?php echo $_SESSION['studentname']; ?>">
        </div>
        <div class="form-group">
            <label for="emailstudent">Student Email:</label>
            <input type="email" class="form-control" id="emailstudent" name="emailstudent" value="<?php echo $_SESSION['emailstudent']; ?>">
        </div>
        <div class="form-group">
            <label for="age">Birthday:</label>
            <input type="text" class="form-control" id="birthdate" name="birthdate" value="<?php echo $_SESSION['birthdate']; ?>">
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $_SESSION['address']; ?>">
        </div>
        <div class="form-group">
            <label for="schoolname">School Name:</label>
            <input type="text" class="form-control" id="schoolname" name="schoolname" value="<?php echo $_SESSION['schoolname']; ?>">
        </div><br>
        <div class="form-group">
                <label for="telephone">Telephone Number:</label>
                <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo isset($_SESSION['telephone']) ? $_SESSION['telephone'] : ''; ?>">
            </div><br>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="text" class="form-control" id="password" name="password" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>">
            </div><br>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<script>
  document.querySelector('form').addEventListener('submit', function(event) {
  // prevent the form from submitting
  event.preventDefault();

  // create a pop-up notification
  var notification = document.createElement('div');
  notification.classList.add('notification');
  notification.textContent = 'Changes saved successfully!';
  document.body.appendChild(notification);

  // remove the notification after 5 seconds
  setTimeout(function() {
    notification.remove();
    // submit the form
    event.target.submit();
  }, 5000);
});

</script>

    </BODY>
</HTML>
