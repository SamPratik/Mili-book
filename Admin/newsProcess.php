<?php include_once("dbConnector.php"); ?>

<?php
	//echo $_POST["newsTitle"] . "\n" . $_POST["newsBody"];
	$newsTitle = mysqli_real_escape_string($connection,$_POST["newsTitle"]);
	$newsBody = mysqli_real_escape_string($connection,$_POST["newsBody"]);
	
	$InsertNews = "INSERT INTO recent_news (heading,body) VALUES ('{$newsTitle}','{$newsBody}')";
	$ResultNews = mysqli_query($connection,$InsertNews);
	
	if($ResultNews) {
		echo "success";
	} else {
		echo "failed";
	}
?>