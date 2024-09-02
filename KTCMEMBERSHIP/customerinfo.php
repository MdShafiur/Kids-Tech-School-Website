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

$conn = mysqli_connect("localhost", "id19727041_ktcmembership", "Ktcmembership123$", "id19727041_ktcwebsite");

// Check connection
if (!$conn) {
    die("Fatal Error: Connection Failed!");
}

// Check if the "update-btn" form is submitted
if (isset($_POST['update-btn'])) {
    $id = $_POST['id'];
    $rec_id = $_POST['rec_id'];
    $email = $_POST['email'];
    $emailstudent = $_POST['emailstudent'];
    $parentname = $_POST['parentname'];
    $studentname = $_POST['studentname'];
    $address = $_POST['address'];
    $schoolname = $_POST['schoolname'];
    $birthdate = $_POST['birthdate'];

    // Update the record in the database
    $query = "UPDATE tbl_member SET rec_id='$rec_id', email='$email', emailstudent='$emailstudent', parentname='$parentname', studentname='$studentname', address='$address', schoolname='$schoolname', birthdate='$birthdate' WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// ...

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Info</title><link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
    <link href="assets/css/phppot-style.css" type="text/css" rel="stylesheet">
    <link href="assets/css/user-registration.css" type="text/css" rel="stylesheet">
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

       
    /* Add styles to the table */
    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
    }
    th, td {
      text-align: left;
      padding: 5px;
    }
    th {
      background-color: #4CAF50;
      color: white;
    }
    tr:nth-child(even){background-color: #f2f2f2}

    /* Add hover effect to the table rows */
    tr:hover {background-color: #ddd;}

    /* Add styles to the table container */
    .table-container {
      max-width: 1500px;
      margin: 0 auto;
      background-color: white;
      border-radius: 5px;
      box-shadow: 0px 0px 5px #888888;
      padding: 20px;
    }
    @media only screen and (min-width: 978px) {
    .navbar {
        margin-left: 360px; /* Adjust this value based on the width of your sidebar */
    }
    .table-container {
        margin-left: 330px; /* Adjust this value based on the width of your sidebar */
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
    <style>
        /* Style for the popup overlay */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Style for the popup form */
        .popup-form {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        /* Style for the close button */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
    <style>
        .form-row {
            display: inline-block;
            margin-bottom: 10px;
        }
        .form-label {
            display: block;
        }
        .form-input {
            display: block;
        }
        label {
            display: inline;
        }
        button {
            display: block;
            margin-top: 10px;
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
<div class="table-container">
<div><h3><b>Customer Details</b></h3></div>
<br>
  <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="search-input">Search:</label>
    <input type="text" id="search-input" name="search-input">
    <button type="submit" name="search-btn"><i class="fa fa-search"></i></button>
  </form>

  <table>
    <thead>
      <tr>
        
        <th>User ID</th>
        <th>Parent Email</th>
        <th>Student Email </th>
        <th>Parent Name </th>
        <th>Student Name </th>
        <th>Address </th>
        <th>School Name </th>
        <th>Birthdate </th>
        <th><center>Update Information </center></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $conn = mysqli_connect("localhost", "id19727041_ktcmembership", "Ktcmembership123$", "id19727041_ktcwebsite");

        // Check connection
        if (!$conn) {
          die("Fatal Error: Connection Failed!");
        }

        // Check if search button is clicked
        if (isset($_GET["search-btn"])) {
          $searchInput = $_GET["search-input"];
          $query = "SELECT * FROM tbl_member WHERE rec_id LIKE '%$searchInput%' OR email LIKE '%$searchInput%' OR emailstudent LIKE '%$searchInput%' OR parentname LIKE '%$searchInput%' OR studentname LIKE '%$searchInput%' OR address LIKE '%$searchInput%' OR schoolname LIKE '%$searchInput%' OR birthdate LIKE '%$searchInput%'";
        } else {
          $query = "SELECT * FROM tbl_member";
        }

        // Fetch data from the database
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($result)) {
          echo "<tr>";
          
          echo "<td>" . $row['rec_id'] . "</td>";
          echo "<td>" . $row['email'] . "</td>";
          echo "<td>" . $row['emailstudent'] . "</td>";
          echo "<td>" . $row['parentname'] . "</td>";
          echo "<td>" . $row['studentname'] . "</td>";
          echo "<td>" . $row['address'] . "</td>";
          echo "<td>" . $row['schoolname'] . "</td>";
          echo "<td>" . $row['birthdate'] . "</td>";
          echo "<td>
                <button onclick='openPopupForm(" . $row['id'] . ",\"" . $row['rec_id'] . "\",\"" . $row['email'] . "\",\"" . $row['emailstudent'] . "\",\"" . $row['parentname'] . "\",\"" . $row['studentname'] . "\",\"" . $row['address'] . "\",\"" . $row['schoolname'] . "\",\"" . $row['birthdate'] . "\")'>Update</button>
            </td>";
        echo "</tr>";
    }

    // Free result set
    mysqli_free_result($result);

    // Close connection
    mysqli_close($conn);
?>
            </tbody>
        </table>
        <div class="popup-overlay" id="popupOverlay">
        <!-- Popup Form -->
        <div class="popup-form">
            <span class="close-btn" onclick="closePopupForm()">&times;</span>
            <h2>Update Member Information</h2>
            <form method="POST" action="">
        <input type="hidden" name="id" id="popup-id" value="">
        <div class="form-row">
            <div class="form-label">
                <label for="popup-rec_id">UserID:</label>
            </div>
            <div class="form-input">
                <input type="text" name="rec_id" id="popup-rec_id" value="">
            </div>
        </div>
        <div class="form-row">
            <div class="form-label">
                <label for="popup-email">Email:</label>
            </div>
            <div class="form-input">
                <input type="email" name="email" id="popup-email" value="">
            </div>
        </div>
        <div class="form-row">
            <div class="form-label">
                <label for="popup-emailstudent">Email (Student):</label>
            </div>
            <div class="form-input">
                <input type="email" name="emailstudent" id="popup-emailstudent" value="">
            </div>
        </div>
        <div class="form-row">
            <div class="form-label">
                <label for="popup-parentname">Parent Name:</label>
            </div>
            <div class="form-input">
                <input type="text" name="parentname" id="popup-parentname" value="">
            </div>
        </div>
        <div class="form-row">
            <div class="form-label">
                <label for="popup-studentname">Student Name:</label>
            </div>
            <div class="form-input">
                <input type="text" name="studentname" id="popup-studentname" value="">
            </div>
        </div>
        <div class="form-row">
            <div class="form-label">
                <label for="popup-address">Address:</label>
            </div>
            <div class="form-input">
                <input type="text" name="address" id="popup-address" value="">
            </div>
        </div>
        <div class="form-row">
            <div class="form-label">
                <label for="popup-schoolname">School Name:</label>
            </div>
            <div class="form-input">
                <input type="text" name="schoolname" id="popup-schoolname" value="">
            </div>
        </div>
        <div class="form-row">
            <div class="form-label">
                <label for="popup-birthdate">Birthdate:</label>
            </div>
            <div class="form-input">
                <input type="text" name="birthdate" id="popup-birthdate" value="">
            </div>
        </div>
        <button type="submit" name="update-btn">Update</button>
    </form>



        </div>
    </div>

    <script>
        function openPopupForm(id, rec_id, email, emailstudent, parentname, studentname, address, schoolname, birthdate) {
            document.getElementById("popup-id").value = id;
            document.getElementById("popup-rec_id").value = rec_id;
            document.getElementById("popup-email").value = email;
            document.getElementById("popup-emailstudent").value = emailstudent;
            document.getElementById("popup-parentname").value = parentname;
            document.getElementById("popup-studentname").value = studentname;
            document.getElementById("popup-address").value = address;
            document.getElementById("popup-schoolname").value = schoolname;
            document.getElementById("popup-birthdate").value = birthdate;
            document.getElementById("popupOverlay").style.display = "block";
        }

        function closePopupForm() {
            document.getElementById("popupOverlay").style.display = "none";
        }
    </script>
    </div>
   
</body>
</html>

