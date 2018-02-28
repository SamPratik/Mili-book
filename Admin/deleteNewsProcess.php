<?php include_once("dbConnector.php"); ?>

<?php 
	
	$newsId = $_POST["newsId"];
	
	$DeleteNews = "DELETE FROM recent_news WHERE id='{$newsId}'";
	$ResultNews = mysqli_query($connection,$DeleteNews);
	
	if($ResultNews) {
		echo "success";	
	} else {
		echo "failed";	
	}
?>