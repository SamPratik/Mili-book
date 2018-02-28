<?php include_once("dbConnector.php"); ?>
<?php
	$inputCode = $_POST["inputCode"] ;
	$baNo = $_POST["baNo"] ;
	$code = $_POST["code"];
	
	
	if($inputCode == $code) {
		$update = "UPDATE `register` SET `verified` = '1' WHERE `register`.`ba_no` = '{$baNo}'";
		$result = mysqli_query($connection,$update);
		if($result) {
			echo "success";
		}
	} else {
		echo "failed";
	}
?>