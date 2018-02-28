<?php include_once("dbConnector.php"); ?>

<?php

	$id = $_GET['id'];
	
	$sql = "DELETE FROM faq WHERE id={$id}";
	$result = mysqli_query($connection,$sql);
	
	if($result) {
		echo "success";	
	} else {
		echo "failed";	
	}

?>