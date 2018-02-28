<?php session_start(); ?>
<?php 
	if($_SESSION["verified"] == 0) {
		header("location: login.php");	
	}
?>

<?php  
	if(isset($_SESSION["name"]))  
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
<link rel="stylesheet" href="css/navbar.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>FAQ</title>

<style>
	.content {
		position:relative;
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
		color:#fff;
	}
	
	.dropdown-menu li a:hover {
		background-color:#145A32 !important;
	}
	
	.navbar a {
		letter-spacing:0px;	
	}
		
</style>
</head>

<?php include_once("dbConnector.php"); ?>

<?php

	$selectFaq = "SELECT q_date,question,a_date,answer FROM faq ORDER BY id DESC";
	$resultFaq = mysqli_query($connection,$selectFaq);	

?>

<body>

	<!--------START: Header----------->
    <?php include_once("header.php"); ?>
    <!--------END: Header----------->
    
    
    <!-----------START: content----------->
    <div class="content">
    	
        <div class="container"><br/>
        	<h2>FAQ <small>(Frequently Asked Question)</small></h2>
            
            <?php while($rowFaq = mysqli_fetch_assoc($resultFaq)) { ?>
            
            <!-----------START: media1----------->
            <div class="media" style="box-shadow:0px 0px 1px black; padding:32px; border-radius:8px;">
                <div class="media-left">
                <img src="images/blankImage.gif" class="media-object" style="width:45px">
                </div>
                <div class="media-body">
                	<h4 class="media-heading"> <small><i>Posted on <?php echo $rowFaq['q_date']; ?></i></small></h4>
                	<p><?php echo $rowFaq['question']; ?></p>
                    
                    <!--------START: Show Comments & Delete Button------------>
                    <span class="pull-right">
                        
                        <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                    </span><br/>
                	<!--------END: Show Comments & Delete Button------------>
                
                
                	<!--------START: Comments------------>
                	<div class="comments" id="commentId1">
                    
                        <!-- Nested media object -->
                        <div class="media">
                            <div class="media-left">
                            <img src="images/blankImage.gif" class="media-object" style="width:45px">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"> <small><i>Posted on <?php echo $rowFaq['a_date']; ?></i></small></h4>
                                <p><?php echo $rowFaq['answer']; ?></p>
                            
                            </div>
                        </div>
                        
                       
                    
                    </div>
                    <!--------END: Comments------------>
                    
                
                </div>
            </div>
            <!-----------END: media1----------->
            
            <?php } ?>
            
            
        </div>
        
    </div>
	<!-----------START: content----------->    
    
    
    
<!-----------Slide toggle comments------------->

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
	document.getElementsByClassName("navBtn")[3].classList.add("active");
</script>

</body>
</html>