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

<?php include_once("dbConnector.php"); ?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="css/contact.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>Recent News</title>

<style>
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

<body>

	<!--------START: Header----------->
    <?php include_once("header.php"); ?>
    <!--------END: Header----------->
    
    
    <!-----------START: content----------->
    <div class="content">
    
        <div class="container">
        
            <div class="search-bar-container row" style="padding:30px 0px;">
            	<h2 class="col-xs-5 pull-left">News List</h2>
                <div class="col-xs-4 pull-right input-group" style="padding-top:10px;right:12px;">
                	<span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                    <input class="form-control" id="searchBarId" type="text" placeholder="search here by News Title" onKeyUp="searchProcess(this.value)">
                </div>
            </div>
            
            <div id="showResultsId" class="list-group">
				
                
                
            </div>
            
            <div style="clear:both;"></div>
            
        </div>

    </div>
    <!-----------END: content----------->
    
    <!------------START: Contact us-------->
    <?php include_once("contact.php"); ?>
    <!------------END: Contact us-------->
    
    <!------------START: footer-------->
    <?php include_once("footer.php"); ?>
    <!------------END: footer-------->
    
 
    <!---------Adding .active class---------->
    <script>
        document.getElementsByClassName("navBtn")[4].classList.add("active");
    </script> 
    
    <script>
		
		$(document).ready(function() {
            
			$("#showResultsId").load("recentNewsLoad.php");
			
        });
		
	</script>   
    
    <!-------------Search Process------------->
    <script>
		
		function searchProcess(searchTerm) {
		
			if(searchTerm.length > 0 && searchTerm != " ") {
				var x = "";
				var showResult = document.getElementById("showResultsId");
				showResult.innerHTML = "";
				
				$.get(
				
					"recentNewsSeacrhProcess.php",
					{
						searchTerm: searchTerm
					},
					function(e) {
						//alert(e);
						
						var newsArr = JSON.parse(e);
						
						for(i=0; i<newsArr.length; i++) {
						
							var anchorElement = document.createElement("a");
							anchorElement.setAttribute("href", "fullNews.php?newsId=" + newsArr[i].id);
							anchorElement.setAttribute("class", "list-group-item");
							
							var h4Element = document.createElement("h4");
							h4Element.setAttribute("class", "list-group-item-heading");
							var h4Text = document.createTextNode(newsArr[i].heading);
							h4Element.appendChild(h4Text);
							
							anchorElement.appendChild(h4Element);
							
							
							var pElement = document.createElement("p");
							pElement.setAttribute("class", "list-group-item-text");
							var pElementText = document.createTextNode(newsArr[i].body_text.slice(0,400));
							pElement.appendChild(pElementText);
							
							anchorElement.appendChild(pElement);
							
							
							showResult.appendChild(anchorElement);
						
						} 
						
					}
				
				);
			
			} else {
				$("#showResultsId").load("recentNewsLoad.php");
			}
			
		}
		
	</script>
    

</body>
</html>