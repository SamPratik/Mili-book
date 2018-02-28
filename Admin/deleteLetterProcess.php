<?php include_once("dbConnector.php"); ?>

<?php 
	
	$letterId = $_POST["letterId"];
	
	$DeleteLetter = "DELETE FROM letters WHERE id={$letterId}";
	$ResultLetter = mysqli_query($connection,$DeleteLetter);
	
	if($ResultLetter) {
		echo "success";	
	} else {
		echo "failed";	
	}
?>