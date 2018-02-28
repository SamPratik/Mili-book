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
<title>Login(Admin-Panel)</title>

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
	
</style>

</head>

<body style="background-image:url(images/arm.jpg);background-size:cover;background-repeat:no-repeat;">
    
	<h2 class="text-center" style="color:white;">Admin Login</h2>
    
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
            	<label><input type="checkbox"> Remember me</label>
            </div>
        	<button type="submit" class="btn btn-primary btn-block">Sign in</button>
        </form>
    </div>
    
    
    <!------------Matching username & password using PHP----------->
    <?php
	
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			$email = $_POST["email"];
			$password = $_POST["password"];
			
			$login = "SELECT id,username,email,password FROM admin";
			$result = mysqli_query($connection,$login);
			
			while($row = mysqli_fetch_assoc($result)) {
				if($email == $row["email"] && $password == $row["password"]) {
					$_SESSION["adminName"] = $row["username"];
					$_SESSION["adminId"] = $row["id"];
					$_SESSION["adminVerified"] = 1;
					$_SESSION["adminEmail"] = $email;
					$_SESSION['last_login_timestamp'] = time(); 
					header("location: index.php");	
				}
			}
			
		}
	
	?>

</body>
</html>