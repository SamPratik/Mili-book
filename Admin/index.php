<?php session_start(); ?>
<?php 
	if($_SESSION["adminVerified"] != 1) {
		header("location: logout.php");	
	}
?>

<?php  
	if(isset($_SESSION["email"]))  
	{  
	   if((time() - $_SESSION['last_login_timestamp']) > 900) // 900 = 15 * 60  
	   {  
			header("location:logout.php");  
	   }  
	   else  
	   {  
			$_SESSION['last_login_timestamp'] = time();  
	   }  
	}  
?> 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/contact.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>Admin Panel</title>

<style>

	@-webkit-keyframes slideAnim {
		0%{-webkit-transform:translateY(400px);opacity:0;}
		100%{-webkit-transform:translateY(0px);opacity:1;}
	}	
	
	@keyframes slideAnim {
		0%{transform:translateY(400px);opacity:0;}
		100%{transform:translateY(0px);opacity:1;}
	}
	
* {
	padding:0px;
	margin:0px;
	box-sizing:border-box;
}

body {
	font: 400 15px Lato, sans-serif;
	line-height: 1.8;
	color: #818181;
}

/***********START: Navbar CSS ********/
.navbar {
	background-color:rgba(20, 90, 50, 0.7);
	border:0;
}

.navbar a {
	background-color:transparent !important;
	color:#fff !important;
	letter-spacing:0px;
	text-transform:uppercase;
	-webkit-transition:color .5s, background-color .5s;
	transition:color .5s, background-color .5s;
}

.navbar li.active a, .navbar li.active {
	background-color:#fff !important;
	color:#145A32 !important;
}

.navbar li:hover a, .navbar li a:hover {
	background-color:white !important;
	color:#145A32 !important;
}

.navbar span,.navbar i {
	-webkit-transition:color .5s;
	transition:color .5s;
	color:#fff;
	font-size:16px;
}

.navbar li:hover span, .navbar li a:hover span,.navbar li:hover i, .navbar li a:hover i {
	color:#145A32;
}

.navbar .active span,.navbar .active i {
	color:#145A32;
}
/***********END: Navbar CSS ********/
		
	.slide-anim {
		-webkit-animation-fill-mode: forwards; 
		animation-fill-mode:forwards;
	}
	
	.slide {
		-webkit-animation:slideAnim 2s;
		animation:slideAnim 2s;  
	}
	
	div,nav,a,li,ul,span,ol {
		margin:0px;
		padding:0px;
	}
	
	.carousel-indicators li {
		border-color:rgba(20, 90, 50, 1);
		border-width:2px;
	}
	
	.carousel-indicators li.active {
		background-color:rgba(20, 90, 50, 1);
	}
	
	.carousel-caption {
		color:#fff;
	}
	
	.carousel-caption h3 {
		font-weight:bold;
		font-size:50px;
	}
	
	.carousel-control.left, .carousel-control.right {
		background-image:none;
	}
	
	.img-responsive{
		width:100%;
		height:auto;
	}
	
	@media (min-width: 992px ) {
		.carousel-inner .active.left {
			left: -25%;
		}
		.carousel-inner .next {
			left:  25%;
		}
		.carousel-inner .prev {
			left: -25%;
		}
	}
	
	@media (min-width: 768px) and (max-width: 991px ) {
		.carousel-inner .active.left {
			left: -33.3%;
		}
		.carousel-inner .next {
			left:  33.3%;
		}
		.carousel-inner .prev {
			left: -33.3%;
		}
		.active > div:first-child {
			display:block;
		}
		.active > div:first-child + div {
			display:block;
		}
		.active > div:last-child {
			display:none;
		}
	}
	
	@media (max-width: 767px) {
		.carousel-inner .active.left {
			left: -100%;
		}
		.carousel-inner .next {
			left:  100%;
		}
		.carousel-inner .prev {
			left: -100%;
		}
		.active > div {
			display:none;
		}
		.active > div:first-child {
			display:block;
		}
	}
	

	
	h2 {
		font-weight:bold;
		letter-spacing:3px;
		color:#145A32;
	}
	
	h3 {
		font-weight:bold;
		letter-spacing:4px;
		color:#145A32;
	}
	
	span,i {
		color:#145A32;
	}
	
	.welcome {
		background-color:#E9F7EF !important;
	}
	
	.welcome p {
		line-height:1.8;
	}
	
	.list-group .active {
		background-color:#145A32;
	}
	
	.list-group .active:hover {
		background-color:#145A32;
	}
	
	div.book img {
		-webkit-transform:scale(1,1);
		transform:scale(1,1);
		-webkit-transition:-webkit-transform .5s;	
		transition:transform .5s;	
		cursor:pointer;
	}
	
	div.book img:hover {
		-webkit-transform:scale(1.5,1.5);	
		transform:scale(1.5,1.5);	
	}
	
	.carousel-indicators li {
		font-size:20px;
	}
	
	.item h3 {
		text-shadow:0px 0px 5px black;
	}
	
	/*-----------------Scroll Bar CSS----------*/
	
	::-webkit-scrollbar {
		width:15px;	
	}
	
	::-webkit-scrollbar-track {
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
		border-radius:10px;	
	}
	
	::-webkit-scrollbar-thumb {
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.8); 
		border-radius:10px;	
	}
	
	.list-group a:hover {
		background-color:#fff;
		-webkit-transition:background-color .5s;
		transition:background-color .5s;
	}
	
	.list-group a:hover {
		background-color:#145A32;
		color:white;
	}
	
	.list-group a:hover h4 {
		color:white;
	}
	
	.dropdown-menu li a {
		background-color:#fff !important;
		color:#145A32 !important;
		-webkit-transition:background-color .5s, color .5s;
		transition:background-color .5s, color .5s;
	}
	
	.dropdown-menu li {
		background-color:#fff !important;
		-webkit-transition:background-color 1s;
		transition:background-color .5s;
	}
	

	.dropdown-menu li:hover {
		background-color:#145A32 !important;
		color:#fff !important;
	}
	
	.dropdown-menu li a:hover {
		background-color:#145A32 !important;
		color:#fff !important;
	}
</style>

<!---------------script for book carousel slide------------>
<script>
jQuery(document).ready(function() {
        
	jQuery('.carousel[data-type="multi"] .item').each(function(){
		var next = jQuery(this).next();
		if (!next.length) {
			next = jQuery(this).siblings(':first');
		}
		next.children(':first-child').clone().appendTo(jQuery(this));
	  
		for (var i=0;i<2;i++) {
			next=next.next();
			if (!next.length) {
				next = jQuery(this).siblings(':first');
			}
			next.children(':first-child').clone().appendTo($(this));
		}
	});
        
});
</script>

</head>


<body id="top">

<div>

    <!---------------Navigation Bar---------------->
	<?php include_once("navbar.php"); ?>

    <!--------------------Carousel Slider-------------------->
    
    <div>
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
          <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>
    
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
    
          <div class="item active">
            <img class="img-responsive" src="images/slider1.jpg" alt="Chania" height="635">
            <div class="carousel-caption">
              <h3>MILI-BOOK</h3>
              <p style="color:red;text-shadow:0px 0px 5px black;font-weight:bold;font-size:20px;">This is a website specifically dedicated for the Officers of Bangladesh Army.</p>
            </div>
          </div> 
    
          <div class="item">
            <img class="img-responsive" src="images/slider2.jpg" alt="Chania" height="635">
            <div class="carousel-caption">
              <h3>MILI-BOOK</h3>
              <p style="color:red;text-shadow:0px 0px 5px black;font-weight:bold;font-size:20px;">This is a website specifically dedicated for the Officers of Bangladesh Army.</p>
            </div>
          </div>
        
          <div class="item">
            <img class="img-responsive" src="images/slider3.jpg" alt="Flower" height="635">
            <div class="carousel-caption">
              <h3>MILI-BOOK</h3>
              <p style="color:red;text-shadow:0px 0px 5px black;font-weight:bold;font-size:20px;">This is a website specifically dedicated for the Officers of Bangladesh Army.</p>
            </div>
          </div>
      
        </div>
    
        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev" style="color:rgba(20, 90, 50, 1);">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next" style="color:rgba(20, 90, 50, 1);">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    
    
    <!---------------Welcome Jumbotron--------------->
    <div class="jumbotron container-fluid welcome text-center slide-anim" style="padding:80px 100px;">
        <h2>WELCOME</h2>
        <p>This is a website specifically dedicated for the Officers of Bangladesh Army. The entire correspondences regarding the officers, The open forum for each individual with anonymous user facility with detail FAQ is present here. Are you a proud officer of Bangladesh Army! Here are the recent news and other necessary things you need to know with sincere assistance. Register yourself. </p>
    </div>
    
    
    <!---------------Book Carousel Slide--------------->
    <div class="container-fluid row book slide-anim" style="padding:80px 100px;">
 
        <div class="carousel slide col-md-8" data-ride="carousel" data-type="multi" data-interval="2000" id="fruitscarousel">
        
        	<h2 style="padding-bottom:20px;">BOOKS SUGGESTIONS</h2>
        
            <div class="carousel-inner">
                <div class="item active">
                    <img src="book cover images/img1.jpg" class="col-md-3 col-sm-4 col-xs-12">
                </div>
                <div class="item">
                    <img src="book cover images/img2.jpg" class="col-md-3 col-sm-4 col-xs-12">
                </div>
                <div class="item">
                    <img src="book cover images/img3.jpg" class="col-md-3 col-sm-4 col-xs-12">
                </div>
                <div class="item">
                    <img src="book cover images/img4.jpg" class="col-md-3 col-sm-4 col-xs-12">
                </div>
                <div class="item">
                    <img src="book cover images/img5.jpg" class="col-md-3 col-sm-4 col-xs-12">
                </div>
                <div class="item">
                    <img src="book cover images/img6.jpg" class="col-md-3 col-sm-4 col-xs-12">
                </div>
            </div>
        
            <a class="left carousel-control" href="#fruitscarousel" data-slide="prev" style="color:rgba(20, 90, 50, 1);"><i class="glyphicon glyphicon-chevron-left"></i></a>
            <a class="right carousel-control" href="#fruitscarousel" data-slide="next" style="color:rgba(20, 90, 50, 1);"><i class="glyphicon glyphicon-chevron-right"></i></a> 
        
        </div>
        <div class="col-md-4" id="recentNewsId">
            <h2 style="padding-bottom:20px;">RECENT NEWS</h2>
            <div class="list-group" style="height:235px;overflow-y:scroll;">
                <a href="#" class="list-group-item active">
                  <h4 class="list-group-item-heading">First List Group Item Heading</h4>
                  <p class="list-group-item-text">List Group Item Text</p>
                </a>
                <a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading">Second List Group Item Heading</h4>
                  <p class="list-group-item-text">List Group Item Text</p>
                </a>
                <a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading">Third List Group Item Heading</h4>
                  <p class="list-group-item-text">List Group Item Text</p>
                </a>
                <a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading">First List Group Item Heading</h4>
                  <p class="list-group-item-text">List Group Item Text</p>
                </a>
                <a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading">Second List Group Item Heading</h4>
                  <p class="list-group-item-text">List Group Item Text</p>
                </a>
                <a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading">Third List Group Item Heading</h4>
                  <p class="list-group-item-text">List Group Item Text</p>
                </a>
            </div>
        </div>
        
    </div>
    
    
    <!-------------Contact us-------------->
	<?php include_once("contact.php"); ?>
    
    
    <!-----------START: Footer------------>
	<?php include_once("footer.php"); ?>
    <!-----------END: Footer------------>
      
</div>

<!--------------Scrolling Animation----------->

<script>

$(document).ready(function() {
	
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, div a[href='#top']").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
	
  $(window).scroll(function() {
    $(".slide-anim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });    
});

</script>

<!---------Adding .active class---------->
<script>
	document.getElementsByClassName("navBtn")[0].classList.add("active");
</script>

</body>
</html>