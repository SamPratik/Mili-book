<?php session_start(); ?>
<?php include_once("dbConnector.php"); ?>
<?php
	$selectCode = "SELECT code FROM register WHERE ba_no='{$_GET['ba_no']}'";
	$resultCode = mysqli_query($connection,$selectCode);
	
	$row = mysqli_fetch_assoc($resultCode);
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
<title>Verify Code</title>
</head>

<body>

	<div class="text-center" style="padding:100px;margin:auto;width:350px;">
    	<a href="https://mail.google.com/mail/u/0/#inbox" class="btn btn-primary"><i class="fa fa-envelope" aria-hidden="true"></i> Check Email to verify</a>
        <form>
            <div class="form-group"><br/>
                <label for="code">Verification Code:</label>
                <input name="code" type="text" class="form-control" id="codeId" required>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-success" onClick="verify('<?php echo $row['code']; ?>','<?php echo $_GET['ba_no']; ?>')">Verify</button>
            </div>
		</form>
    </div>
    
    <script>
		
		function verify(codeJs,baNoJs) {
			
			var inputCodeJs = document.getElementById("codeId").value;
			
			$.post(
				"verifyCodeProcess.php",
				{
					baNo: baNoJs,
					code: codeJs,
					inputCode: inputCodeJs
				},
				function(e) {
					if(e.indexOf("success") != -1) {
						<?php $_SESSION["verified"] = 1; ?>
						window.location = "index.php";
					}
					if(e.indexOf("failed") != -1) {
						alert("verify code is not correct!");
					}
				}
			);
			
		}
		
   	</script>

</body>
</html>