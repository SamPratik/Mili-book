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
<?php include_once("dbConnector.php"); ?>
<!doctype html>

<!----------Retrieving News------------>
<?php
	$SelectNews = "SELECT id,heading,body FROM recent_news ORDER BY id DESC";
	$ResultNews = mysqli_query($connection,$SelectNews);
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/contact.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>Recent News</title>
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

	<!--------START: Header----------->
    <?php include_once("header.php"); ?>
    <!--------END: Header----------->
    
    
    <!-----------START: content----------->
    <div class="content">
    
        <div class="container"><br/>
            <h2>Recent News <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#addLetterModalId"><i class="fa fa-plus" aria-hidden="true"></i> Add News</button></h2>
            <div class="list-group">
            
            	<?php while($RowNews = mysqli_fetch_assoc($ResultNews)) { ?>
                <li class="list-group-item">
                  <h3 class="list-group-item-heading"><?php echo $RowNews["heading"]; ?></h3>
                  <p class="list-group-item-text"><?php echo substr($RowNews["body"],0,400) . "..."; ?> </p>
                  <a  href="fullNews.php?newsId=<?php echo $RowNews['id']; ?>" class="btn btn-primary btn-sm pull-right"><i class="fa fa-folder-open" aria-hidden="true"></i> Open</a>
                  <button style="margin-right:5px;" class="btn btn-danger btn-sm pull-right" onClick="deleteNews(<?php echo $RowNews['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                  <br/>
                </li>
                <?php } ?>
                
            </div>
        </div>

    </div>
    <!-----------END: content----------->
    
	<!-----START: Contact Us------->
	<?php include_once("contact.php"); ?>
    <!-----END: Contact Us------->
    
    <!-----------START: Footer------------>
	<?php include_once("footer.php"); ?>
    <!-----------END: Footer------------>
    
    
    <!-- START: Add News Modal -->
    <div class="modal fade" id="addLetterModalId" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Recent News</h4>
                </div>
                <div class="modal-body">
                    <form id="newsFormId">
                        <div class="form-group">
                            <label for="usr">Add Title:</label>
                            <input type="text" class="form-control" name="newsTitle">
                        </div>
                        <div class="form-group">
                        	<label for="comment">News:</label>
                        	<textarea class="form-control" rows="10" name="newsBody"></textarea>
                        </div>
                        <button type="button" class="btn btn-success" onClick="storeNews()">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Add News Modal -->
    
    
    <!----------Sending Data to Database Using AJAX------->
    <script>
        
        function storeNews() {
            
            var fd = new FormData(document.querySelector("#newsFormId"));
            
            $.ajax({
                url: "newsProcess.php",
                data: fd,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(e) {
                    //alert(e);
                    if(e.indexOf("success") != -1) {
                        alert("News Added successfully!");
                        window.location = "recentNews.php";
                    }
                    if(e.indexOf("failed") != -1) {
                        alert("Failed to add news!");
                    }
                }
            });
            
        }
        
    </script>
 
    <!-----------Delete News From Database Using AJAX---------->
    <script>
        
        function deleteNews(newsIdJs) {
            
            var r = confirm("Are you sure you want to delete this news?");
            
            if(r == true) {
                $.post(
                    "deleteNewsProcess.php",
                    {
                        newsId: newsIdJs	
                    },
                    function(e) {
                        
                        if(e.indexOf("success") != -1) {
                            alert("Successfully deleted!");
                            window.location = "recentNews.php";	
                        } 
                        if(e.indexOf("failed") != -1) {
                            alert("Failed to delete!");	
                        } 
                        
                    }
                );
            } else {
                
            }
            
        }
        
    </script>
 
    <!---------Adding .active class---------->
    <script>
        document.getElementsByClassName("navBtn")[4].classList.add("active");
    </script>    
</body>
</html>