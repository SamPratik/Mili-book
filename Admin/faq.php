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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>FAQ</title>

<style>
	.content {
		position:relative;
	}
	
	.comments {
		/*display:none;*/	
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
</style>
</head>

<?php include_once("dbConnector.php"); ?>

<?php

	$selectFaq = "SELECT id,q_date,question,a_date,answer FROM faq ORDER BY id DESC";
	$resultFaq = mysqli_query($connection,$selectFaq);	

?>


<body>

	<!--------START: Header----------->
    <?php include_once("header.php"); ?>
    <!--------END: Header----------->
    
    
    <!-----------START: content----------->
    <div class="content">
    	
        <div class="container"><br/>
        	<h2>FAQ <small>(Frequently Asked Question)</small>  <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i> Add FAQ</button></h2>
            
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
                        
                        <button class="btn btn-danger btn-xs" onClick="deleteFaqQuestion(<?php echo $rowFaq['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
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
    
    <!-- START: Add FAQ Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add FAQ</h4>
          </div>
          <div class="modal-body">
            <form id="faqAddFormId">
            
                <div class="form-group">
                  <label for="comment">Question:</label>
                  <textarea name="question" class="form-control" rows="5" id="comment"></textarea>
                </div>
                
                <div class="form-group">
                  <label for="comment">Answer:</label>
                  <textarea name="answer" class="form-control" rows="5" id="comment"></textarea>
                </div>
                                
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" onClick="addFaq()">Add</button>
          </div>
        </div>
    
      </div>
    </div>
    <!-- END: Add FAQ Modal -->
    
    
	<script>
		function deleteFaqQuestion(id) {
			
			$.get(
			
				"faqDeleteQuestion.php",
				{
					id: id
				},
				function(e) {
					
					if(e.indexOf("success") != -1) {
						alert("Successfully deleted");	
						window.location = "faq.php";
					}
					if(e.indexOf("failed") != -1) {
						alert("Faield to delete");	
					}
					
				}
				
			);
			
		}
	</script>
	
	
	<script>
		function addFaq() {
		
			var fd = new FormData(document.querySelector("#faqAddFormId"));
			
			$.ajax({
				
				url: "faqAddProcess.php",
				type: "POST",
				data: fd,
				contentType: false,
				processData: false,
				success: function(e) {
					
					if(e.indexOf("success") != -1) {
						alert("Successfully Added!");
						window.location = "faq.php";	
					}
					if(e.indexOf("failed") != -1) {
						alert("Failed to Add!");	
					}
					
				}
				
			});
			
		}
		
	</script>    
    
<!-----------Slide toggle comments------------->
<script>
    
    /*function showComments(id) {
        
        $("#commentId" + id).slideToggle("slow");
            
    }*/
    
</script>

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