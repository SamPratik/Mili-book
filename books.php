<?php session_start(); ?>
<?php include_once("dbConnector.php"); ?>
<?php 
	if($_SESSION["verified"] != 1) {
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
<title>Books</title>

<style>
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

<body>

	<!---------START: Retrieving Books-------->
    
    <?php
		
		$selectBooks = "SELECT id,images_file_name,book_file_name,book_title,description FROM books";
		$resultBooks = mysqli_query($connection,$selectBooks);
		
	?>
    

    
    <!---------END: Retrieving Books-------->

	<!--------START: Header----------->
    <?php include_once("header.php"); ?>
    <!--------END: Header----------->

    <!-----------START: content----------->
    <div class="content">
    
    	<div class="container">
        
            <div class="search-bar-container row">
            	<h2 class="col-xs-5 pull-left">Books</h2>
                <div class="col-xs-4 pull-right input-group" style="right:12px;padding-top:20px;">
                	<span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                    <input class="form-control" id="searchBarId" type="text" placeholder="search by Book name" onKeyUp="searchProcess(this.value,<?php echo $_SESSION["id"]; ?>,'<?php echo $_SESSION["name"]; ?>')">
                </div>
            </div>
            
            <ul class="list-group" style="position:relative;top:20px;">
            
            	<?php while($rowBooks = mysqli_fetch_assoc($resultBooks)) { ?>
            
            
				<?php  
                
					$flag = 0;
                    $selectRating = "SELECT avg(rating) AS rating,id FROM books_rating WHERE book_id={$rowBooks['id']}";
                    $resultRating = mysqli_query($connection,$selectRating);
					
					$rowRating = mysqli_fetch_assoc($resultRating);
					$count = 0;
					
					/*$selectUserId = "SELECT user_id FROM books_rating";
					$resultUserId = mysqli_query($connection,$selectUserId);
					
					while($rowUserId = mysqli_fetch_assoc($resultUserId)) {
						
						if($rowUserId['user_id'] == $_SESSION['id']) {
							$flag = 1;
							break;
						} else {
							continue;	
						}
						
					}*/
                
                ?>
                
            
                <li class="list-group-item list-group-item-success row">
                	
                    <img style="display:block;margin:auto;" src="Admin/book cover images/<?php echo $rowBooks['images_file_name']; ?>" class="img-rounded col-md-2 text-center img-thumbnail">
                    <div class="text-justify pull-left col-md-10" style="padding:0px 50px;">
                    	<strong><?php echo $rowBooks['book_title']; ?></strong>
                        <p><?php echo nl2br($rowBooks['description']); ?></p>
                        <p>
                        	<?php for($i=1; $i<=$rowRating['rating']; $i++) { ?>
                        		<i class="fa fa-star" aria-hidden="true"></i>&nbsp;
                                <?php $count++; ?>
                            <?php } ?>
                            <?php if(ceil($rowRating['rating']) == ($count+1)) { ?>
								<i class="fa fa-star-half" aria-hidden="true"></i>
							<?php } ?>
							<?php echo round($rowRating['rating'],1); ?>/5
                        	<a href="Admin/uploads/<?php echo $rowBooks['book_file_name']; ?>" class="btn btn-primary pull-right"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                            <?php //if($flag == 0) { ?>
                            <button style="margin-right:10px;" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal<?php echo $rowBooks['id']; ?>"><i class="fa fa-star" aria-hidden="true"></i> Rating</button>
                            <?php //} ?>
                            <div style="clear:both;"></div>
                        </p> 
                    </div>
                    <div style="clear:both;"></div>
                    
                </li>
                
                
              <!-- START: Modal -->
              <div class="modal fade" id="myModal<?php echo $rowBooks['id']; ?>" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Rating</h4>
                    </div>
                    <div class="modal-body">
                    
                        <div class="form-group">
                          <label for="sel1">Give a rating:</label>
                          <select class="form-control" id="sel<?php echo $rowBooks['id']; ?>">
                          	<option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                          </select>
                        </div> 
                        
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-success" onClick="rating(<?php echo $rowBooks['id'] ?>,<?php echo $_SESSION['id']; ?>)">Submit</button>
                    </div>
                  </div>
                </div>
              </div> 
              <!-- END: Modal -->
              
              <?php } ?>

                
            </ul>
        
        </div>
    
    </div>
    <!-----------END: content----------->
    
    <script>
		
		function rating(bookId,userId) {
			
			var selVal = document.getElementById("sel" + bookId).value;
			
			$.post(
			
				"bookRatingProcess.php",
				{
					bookId: bookId,
					selVal: selVal,
					userId: userId
				},
				function(e) {
					
					if(e.indexOf("success") != -1) {
						alert("Rated Successfully!");
						window.location = "books.php";	
					}
					if(e.indexOf("failed") != -1) {
						alert("Failed to rate!");	
					}
					
				}
				
			);
			
		}
		
	</script>
    
    
    <!---------Adding .active class---------->
    <script>
        document.getElementsByClassName("navBtn")[5].classList.add("active");
    </script> 
    
</body>
</html>