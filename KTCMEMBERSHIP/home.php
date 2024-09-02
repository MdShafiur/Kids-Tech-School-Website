<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["rec_id"])) {
    // If not logged in, redirect to the login page or index page
    header("Location: ./index.php");
    exit();
}

$recID = $_SESSION["rec_id"];

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

$usernameQuery = "SELECT username FROM tbl_member WHERE rec_id = '$recID'";
$usernameResult = $conn->query($usernameQuery);

if (!$usernameResult) {
    echo "Error retrieving username: " . $conn->error;
} else {
    $usernameRow = $usernameResult->fetch_assoc();
    $welcomeMessage = "Welcome " . $usernameRow['username'] . "!";
}

// Retrieve cart items specific to the user
$cartItems = isset($_SESSION['cart_items'][$recID]) ? $_SESSION['cart_items'][$recID] : [];
$count = count($cartItems);

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>     
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KTC Membership Website</title><link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="assets/css/phppot-style.css" rel="stylesheet" type="text/css">
    <link href="assets/css/user-registration.css" rel="stylesheet" type="text/css">
    <link href="assets/css/styles.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="assets/vendor/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="assets/vendor/owl-carousel/css/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="assets/vendor/owl-carousel/css/owl.theme.default.css" rel="stylesheet" type="text/css">
    <script src="https://www.w3schools.com/lib/w3.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    
       <style> 
        /* Custom CSS for smaller screens (max-width: 400px) */
        @media (max-width: 1400px) {
            @font-face {
          font-family: 'MyOtherCustomFont';
          src: url('assets/css/RifficFreeBold.ttf') format('truetype');
        }
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
                  
        }

       </style>
    <style>

     #myImg {

     border-radius: .50rem;
     cursor: pointer;
     transition: 0.3s;
     width:  100%;
     height:  auto;
     object-fit:cover;
  

     }

     #myImg:hover {opacity: 0.7;}

     /* The Modal (background) */
     .modal {
     display: none; /* Hidden by default */
     position: fixed; /* Stay in place */
     z-index: 20; /* Sit on top */
     padding-top: 100px; /* Location of the box */
     left: ;
     top: 0;
     width: 100%; /* Full width */
     height: 100%; /* Full height */
     overflow: auto; /* Enable scroll if needed */
     background-color: rgb(0,0,0); /* Fallback color */
     background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
     object-fit:cover;

     }

     /* Modal Content (image) */
     .modal-content {
     margin:auto;
     display: block;
     width: 80%;        /*80*/
     max-width: 700px;  /*700*/
     object-fit:cover;

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
     .modal-content, #caption {  
     -webkit-animation-name: zoom;
     -webkit-animation-duration: 0.6s;
     animation-name: zoom;
     animation-duration: 0.6s;

     }

     @-webkit-keyframes zoom {
     from {-webkit-transform:scale(0)} 
     to {-webkit-transform:scale(1)}
     }

     @keyframes zoom {
     from {transform:scale(0)} 
     to {transform:scale(1)}
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

     /* 100% Image Width on Smaller Screens */
     @media only screen and (max-width: 700px){
     .modal-content {
     width: 100%;

     }
     }

     img.img-full
     {     
     max-width: 100%;
     height: auto;
     object-fit:cover;
   
     }

     #joinPoster{     
     background-color: #e6ffff;
     padding: 3em 3em 7em 3em;
     }


     /*Modal For Popup Style*/
     .modal-contents{
     position: absolute;
     background-color: transparent;
     border: none;
     left: %;  /*to make the image center*/
     max-width: 100%;
     object-fit:cover;
     /*margin-left: -10px; option 1 to make the image center*/
     /*transform: translateX(-50%); option 2 to make the image center*/

     }
     .modal-content{
     /*position:absolute;*/
     background-color: transparent;
     border: none;
     object-fit:cover;
       display: block;
         margin-left: auto;
         margin-right: auto;
     /*left: 25%;  to make the image center*/
     /*margin-left: -10px; option 1 to make the image center*/
     /*transform: translateX(-50%); option 2 to make the image center*/

     }


     .modal-header{

     border-bottom: none;
     }

     .close {

     color: red;
     }

     .close:hover {

     color: red;
     }

     /*Modal For Popup Style End*/
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
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

  <style>
.total-points-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: linear-gradient(45deg, #4caf50, #2196f3); /* Gradient background */
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    margin-bottom: 20px;
    color: #fff; /* Text color */
    animation: fadeInUp 1s ease-out; /* Fade-in animation */
}

.total-points-container p {
    font-family: 'Lobster', cursive;
    font-size: 30px;
    font-weight: bold;
    margin: 0;
}

@media (max-width: 768px) {
    .total-points-container {
        padding: 15px; /* Adjust padding for smaller screens */
    }

    .total-points-container p {
        font-size: 18px; /* Make the font size smaller for smaller screens */
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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
            Cart <p class="badge badge-pill badge-danger"><?php echo $count ?></p>
        </a>
        <!-- Logo and brand text -->
     <a class="navbar-brand d-flex align-items-center ms-sm-auto" href="logout.php">
            Logout
        </a>
    </div>
</nav>
<div class="container mt-4 total-points-container">
        <p><?php echo $welcomeMessage; ?></p>
        <p>Your Overall Points: <?php echo $overallPoints; ?></p>
    </div>



   
<header>
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"  >
  <div class="carousel-inner shadow" >
    <div class="carousel-item active">
      <img src="assets/img/slider/edit/slider_01.jpg" class="overlay d-block w-100" alt="...">
		 <div class="carousel-caption d-none d-md-block" style="padding-bottom: 10%">
			<div class="asset-logo-1"><img src="assets/img/asset-1.2.png" alt="Logo" style="width: 550px;"><br></br></div>
  		    <div class="asset-logo-2"><img src="assets/img/asset-2.2.png" alt="Logo" style="width: 550px;"><br></br></div>
		    <div class="asset-logo-3"><img src="assets/img/asset-3.2.png" alt="Logo" style="width: 550px;"></div>
         </div>
    </div>
		<div class="carousel-item">
    <img src="assets/img/slider/edit/Slider_1.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
    <img src="assets/img/slider/edit/Slider_2.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
     <img src="assets/img/slider/edit/Slider_3.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</header>

<!--Header-->



<!--Our core values-->
	
	<section class=" ktc-services text-center" >
	<div class="container">
		<div class="container">
			<h1><br></h1>
		</div>
		<div class="row">
			<div class="col-md-6">
				<a href="#">
					<div class="services-class tc-image-effect-shine">
						<a href="exhibits.html">
						<div class="servicesText">
							<div>
								<h1><b>Exhibits</b></h1>
							</div>
						</div>
						<div class="services-img">
							<img src="assets/img/exhibits.jpg" alt="" class="img-fluid">
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6">
				<div class="services-class tc-image-effect-shine">
					<a href="education.html">
						<div class="servicesText">
							<div>
								<h1><b>Education</b></h1>
							</div>
						</div>
						<div class="services-img">
							<img src="assets/img/education.jpg" alt="" class="img-fluid">
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
	
<!--Our core values-->
<!--360-->
		
<section>
			
		</section>
		 <section class=" text-center" style="gradie ; background-image: linear-gradient( rgba(0, 0, 0, 0.7),rgba(0, 0, 0, 0.2)) , url('assets/img/homepage_ktc360.jpg');  background-repeat: no-repeat;
  background-size: cover; height: 300px;">
    <div class="container">
		 <div class="clear" style="padding-top:5%" >&nbsp;</div>
	<h1 class="text-white" style="font-size: 2rem"><b>Explore our exhibits in 360&#176;</b></h1>
      
      <p>
        <a href="exhibits.html" class="btn btn-success shadow btn-lg btn-lg my-2">Explore</a>
      </p>
    </div>
  </section>
<!--360-->

<!--Section for poster START-->
<section id="joinPoster">
    
    <div class="ktc-SecTitle">
			<h1><br>Join Us</h1>
		</div><br>
		  <div class="container-fluid">
        	<center><div class="row" >
        	    <div class="col-md-4 col-xs-12 col-sm-12">
        			<img id="myImg" class="img-fluid" src="assets/img/thumnail/newexhibits.jpg">
        		</div>
        		<div class="col-md-4 col-xs-12 col-sm-12">
        			<img id="myImg" class="img-fluid" src="assets/img/thumnail/latestposter.jpeg">
        		</div>
        		<div class="col-md-4 col-xs-12 col-sm-12">
        			<img id="myImg" class="img-fluid" src="assets/img/thumnail/PROGRAMMING.png">
        		</div>
        		
        		<!--<div class="col-md-4 col-xs-12 col-sm-12">
        			<img id="myImg" class="img-fluid" src="">
        		</div>-->
        	</div></center>
        </div>

 <!-- The Modal -->
<div id="myModal" class="modal">
  
 <span class="close">&times;</span>;
  <img id="modal-img" class="modal-content">
 
</div>
</section>
<!--Section for poster END-->

<!--Testimonial-->	
				
<section class=" ktc-testimonial tester_new text-center" >
			<div class="container">
		<div class="ktc-SecTitle">
			<h1><br>Testimonial</h1>
			
		</div>
				<img  src="assets/img/1x/Artboard 22.png" alt="logo" height="50">
  <hr>
  <div class="container">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
          <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
              <p style="color: hotpink">"My son has actively exploring things since I sent him here"</p>
              <hr >
              <h5>-Madam Zila-</h5>
           
            </div>
            <div class="col-lg-2"></div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
              <p style="color: hotpink">"Program yang bagus. Risau anak-anak menghadap gadget. sekurangnya dengan ada program ini anak-anak boleh lakukan pekara yang berfaedah."</p>
              <hr>
              <h5>-Puan Amalina-</h5>
              
            </div>
            <div class="col-lg-2"></div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
              <p style="color: hotpink">"Good tools for education. Highly recommended. Like it very much."</p>
              <hr>
              <h5 >-Madam Fathiah-</h5>
             
            </div>
            <div class="col-lg-2"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
 </div>
</section>
<section class="text-center">
</section>
		
	
	
<!--Testimonial-->
	
<!--Collaboration-->
	
	<section class="ktc-colab text-center" style="padding: 30px">
			<div class="container">
		<div class="ktc-SecTitle">
			<h1><br>Collaboration</h1>
		</div>
			<img  src="assets/img/1x/Artboard 23.png" alt="logo" height="60">
			<img src="assets/img/asset-3.2.png" alt="" class="img-fluid"><br>
		</div>
	</section>

<!--Collaboration-->
	
	
</main >	
	
<!--Footer Section-->

		<p w3-include-html="template/footer.html"></p> 
		
<!--Footer Section-->

		
		<script type="text/javascript" src="assets/js/bootstrap.js"></script> 
		<script src="assets/vendor/owl-carousel/js/owl.carousel.js"></script>
	    <script src="/assets/js/jquery-3.4.1.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		<script>$(document).ready(function() {
  $('#global-modal').modal('show');
});</script>

<script>
w3.includeHTML();
</script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/642a27934247f20fefe96fb8/1gt2al6al';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
// var img = document.getElementById("myImg");
var modalImg = document.getElementById("modal-img");
var captionText = document.getElementById("caption");
// img.onclick = function(){
//   modal.style.display = "block";
//   modalImg.src = this.src;
//   captionText.innerHTML = this.alt;
// }


document.addEventListener("click", (e) => {
  const elem = e.target;
  if (elem.id==="myImg") {
    modal.style.display = "block";
    modalImg.src = elem.dataset.biggerSrc || elem.src;
    captionText.innerHTML = elem.alt; 
  }
})

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var span = document.getElementsByClassName("close")[1];


// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}




</script>

    
</body>
</html>
