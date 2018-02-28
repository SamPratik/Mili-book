<?php session_start(); ?>
<?php include_once("dbConnector.php"); ?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>Login</title>

<style>

	body {
		font: 400 15px Lato, sans-serif;
		line-height: 1.8;
		color: #818181;
	}

	h2 {
		text-transform:uppercase;
		letter-spacing:4px;
		font-weight:bold;
	}

	.login {
		position:relative;
		left:50%;
		border-radius:8px;
		width:300px;
		transform:translateX(-50%);
		background-color:#f6f6f6;
		box-shadow:0px 0px 2px black;
		padding:32px;
	}
	
	.login img {
		display:block;
		margin:auto;
	}
	
	.alert {
		width:600px;
		margin:auto;	
	}
	
	.error {
		color:red;	
	}
	
</style>

</head>

<body style="background-image:url(images/arm.jpg);background-size:cover;background-repeat:no-repeat;">
    
	<h2 class="text-center" style="color:white;">User Login</h2>
    
    <!-------------Error Message--------------->
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
    <div class="alert alert-danger alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php 
			echo "Email/Password doesn't match!"; 
		?>
    </div>
    <?php } ?><br/>
    
    
    <!------------Login DIV--------------->
    <div class="login">
    	<img src="images/blankImage.gif" class="img-circle img-responsive" alt="Profile Pic" width="120"><br/>
        <form action="login.php" method="post">
            <div class="form-group">
            	<input name="email" type="email" class="form-control" id="un" placeholder="Email" required>
            </div>
            <div class="form-group">
            	<input name="password" type="password" class="form-control" id="pwd" placeholder="Password" required>
            </div>
            <div class="checkbox">
            	<label><input type="checkbox"> Remember me</label> <a style="margin-top:-5px;" class="btn btn-link" data-toggle="modal" data-target="#regFormModalId">Register?</a>
            </div>
        	<button type="submit" class="btn btn-primary btn-block">Sign in</button>
        </form>
    </div>
    
    
    <!------------Matching username & password using PHP----------->
    <?php
	
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			$email = $_POST["email"];
			$password =md5($_POST["password"]);
			
			$login = "SELECT id,name,email,password,verified FROM register WHERE email='{$email}' AND password='{$password}'";
			$result = mysqli_query($connection,$login);
			
			while($row = mysqli_fetch_assoc($result)) {
				if($email == $row["email"] && $password == $row["password"]) {
					$_SESSION["id"] = $row["id"];
					$_SESSION["verified"] = $row["verified"];
					$_SESSION["name"] = $row["name"];
					$_SESSION["email"] = $email;
					$_SESSION["password"] = $password;
					$_SESSION['last_login_timestamp'] = time();  
					header("location: index.php");	
				}
			}
			
		}
	
	?>
    
    
    <!-- START: Registration Modal -->
    <div id="regFormModalId" class="modal fade" role="dialog">
        <div class="modal-dialog">
        
        	<!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <form id="regFormId">
                    	<div class="form-group">
                        	<label for="name">Name:</label>
                        	<input type="text" name="name" class="form-control" required>
                            <p class="error" id="nameErr"></p>
                        </div>
                        <div class="form-group">
                        	<label>Email address:</label>
                        	<input type="email" name="email" class="form-control" required>
                            <p class="error" id="emailErr"></p>
                        </div>
                        <div class="form-group">
                        	<label>Password:</label>
                        	<input type="password" name="password" class="form-control" required>
                            <p class="error" id="passErr"></p>
                        </div>
                        <div class="form-group">
                        	<label for="ba_no">BA No:</label>
                        	<input id="ba_no_id" type="text" name="ba_no" class="form-control" required>
                            <p class="error" id="baErr"></p>
                        </div>
                        <div class="form-group">
                        	<label for="course">Course:</label>
                        	<input type="text" name="course" class="form-control" required>
                            <p class="error" id="courseErr"></p>
                        </div>
                        <div class="form-group">
                        	<label for="rank">Rank:</label>
                        	<input type="text" name="rank" class="form-control" required>
                            <p class="error" id="rankErr"></p>
                        </div>
                    	<button type="button" class="btn btn-success" onClick="userReg(document.getElementById('ba_no_id').value)">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        
        </div>
    </div>
	<!-- END: Registration Modal -->
    
    
    <!-----------Sending Reg Data Using AJAX--------->
    <script>
		
		function userReg(baNoJs) {
		
			var fd = new FormData(document.querySelector("#regFormId"));
			
			$.ajax({
				
				url: "userRegProcess.php",
				data: fd,
				type: "POST",
				contentType: false,
				processData: false,
				success: function(output) {
					
					if(output.indexOf("success") != -1) {
						
						document.getElementById("nameErr").innerHTML = "";
						document.getElementById("emailErr").innerHTML = "";
						document.getElementById("passErr").innerHTML = "";
						document.getElementById("baErr").innerHTML = "";
						document.getElementById("courseErr").innerHTML = "";
						document.getElementById("rankErr").innerHTML = "";
						
						window.location = "verificationCode.php?ba_no=" + baNoJs;
					} else {
					
						var seFoo = JSON.parse(output);
						
						document.getElementById("nameErr").innerHTML = seFoo[0];
						document.getElementById("emailErr").innerHTML = seFoo[1];
						document.getElementById("passErr").innerHTML = seFoo[2];
						document.getElementById("baErr").innerHTML = seFoo[3];
						document.getElementById("courseErr").innerHTML = seFoo[4];
						document.getElementById("rankErr").innerHTML = seFoo[5];
					}
				}
				
			});
			
		}
		
	</script>
    

</body>
</html>