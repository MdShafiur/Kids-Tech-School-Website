 <!doctype html>
<html>
<head>
<meta charset="UTF-8">
<TITLE>Education | KidzTechCentre</TITLE><link rel="shortcut icon" href="assets/img/logo.svg" type="image/svg">


	
<link href="assets/css/styles.css" rel="stylesheet" type="text/css">
<link href="assets/css/bootstrap/bootstrap.css" rel="stylesheet" type="text/css">
<link href="assets/vendor/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css">
<link href="assets/vendor/owl-carousel/css/owl.carousel.css" rel="stylesheet" type="text/css">
<link href="assets/vendor/owl-carousel/css/owl.theme.default.css" rel="stylesheet" type="text/css">
<script src="https://www.w3schools.com/lib/w3.js"></script>
</head>

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
    
</style>

	<body>

<!--Navbar-->
		
	<!--<section class = "header-navbar"><p w3-include-html="template/navbar.html"></p> </section>-->
		
<!--Navbar-->

<!--Header-->

<main role="main" class="flex-shrink-0">
    	<section class = "header-navbar"><div id="navbar-container"></div>		
</section>
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

<!--START POPUP-->
<div class="modal fade" id="global-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" style="padding: 0;">
                <button type="button" class="close" style="font-size: 28px;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <a href="#"><img class="img-full img-responsive" src="assets/img/thumnail/OmusubiPoster.jpg" style="width:1200px;"></a>
            </div>
        </div>
    </div>
</div>
<!--END POPUP-->

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
<script>
	// Function to include the navbar using JavaScript
	function includeNavbar() {
	  var xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		  document.getElementById("navbar-container").innerHTML = this.responseText;
		}
	  };
	  xhttp.open("GET", "template/navbar.html", true);
	  xhttp.send();
	}
  
	// Call the function to include the navbar
	includeNavbar();
  </script>
		</body>		
</html>
	



