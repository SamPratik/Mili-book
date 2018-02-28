<?php session_start(); ?>
<?php include_once("dbConnector.php"); ?>
<!DOCTYPE html>

<?php

include_once('register.php');
include_once("login.php");

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>MiLiBooK</title>


    <link href="css/login.css" rel="stylesheet">
	
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.theme.min.css" rel="stylesheet">

<style>
*{margin:0;padding:0;outline:0}
body{
font-family:arial;
font-size:14px;
line-height:18px;
color:#000000;
background-image:url(images/arm.jpg);
background-repeat:no-repeat;
background-attachment:fixed;
background-size:cover;
/*background:url(images/arm.jpg) repeat fixed 0 0 #fff*/
}
</style>
</head>
<body>


<div class="container">
		<div class="navbar" style="background: url(images/back.png); margin-top:-20px;">
	
			<div class="row">
				<div class="col-sm-4">
					<div class="logo">
						<img class="img-responsive" src="images/logo2.png" alt="Logo"/>
						<h1 style="color:#FFFFFF;">MiLiBooK</h1>
					</div>
				</div>
				
				<div class="col-sm-8">
				
					<form action="homepage.php" method="POST" class="form-group">
						<div class="row">
							
							<div class="col-sm-4">
								<label style="margin-top:20px; color:#FFFFFF;" for="inputUserCode">Ba_no</label>
								<input name="ba_noLogin" class="form-control" placeholder="Login User_code" type="text" id="inputUserCode"/>
								
							</div>
							
							<div class="col-sm-4">
								<label style="margin-top:20px; color:#FFFFFF;" for="inputPassword">Password</label>
								<input name="passwordLogin" class="form-control" placeholder="Login User_code" type="password" id="inputPassword"/>
							</div>
						
							<div class="col-sm-4">
								<button name="login" value="login" style="margin-top:45px" type="submit" class="btn btn-primary">login</button>
							</div>
						
						</div>
					</form>
				</div>
						
						
					
			</div>
			
		</div>
	
	<div class="row">
				<div class="col-sm-6">
		
						<h2 style="text-align:center; color:#FFFFFF; font-size:20px;">Milibook helps you to connect and share with the colleague and the officers in Bangladesh Army</h2>
				
						<img class="img" src="images/map2.png" class="img-responsive" alt="show_map"/>

				
				</div>
		
				<div class="col-sm-6">
		
						<h1 style="color:#FFFFFF;">Sign Up</h1>
			
						<div class="row">
							<div class="col-sm-8">
								<form method="post" action="homepage.php">
									<div class="form-group">
										<label style="color:#FFFFFF" for="inputUserCode">BA_No</label>
										<input name="ba_no" class="form-control" placeholder="Login User_BA_NO" type="text" id="inputUserCode"/><br>
									
										<label style="color:#FFFFFF" for="inputBAno">Name</label>
										<input name="name" class="form-control" placeholder="Login User_Name" type="text" id="inputName"/><br>
										
										
										<label style="color:#FFFFFF" for="inputBAno">Rank</label>
										<input name="rank" class="form-control" placeholder="Login User_Rank" type="text" id="inputRank"/><br>
										
										<label style="color:#FFFFFF" for="inputBAno">Course</label>
										<input name="course" class="form-control" placeholder="Login User_course" type="text" id="inputCourse"/><br>
										
										<label style="color:#FFFFFF" for="inputBAno">Email</label>
										<input name="email" class="form-control" placeholder="Login User_email" type="email" id="inputEmail"/><br>
										
										<label style="color:#FFFFFF" for="inputBAno">Password</label>
										<input name="password" class="form-control" placeholder="Login User_Password" type="Password" id="inputPassword"/><br>
										
										
										<button name="signUp" type="submit" class="btn btn-primary">Sign Up</button>
										
									</div>
					
								</form>
							</div>
						</div>
		
					</div>

	
			</div>
	
	
</div>

	<script src="js/jquery-3.2.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</body>
</html>
