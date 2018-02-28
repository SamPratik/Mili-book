<?php include_once("dbConnector.php"); ?>

<?php
	
	$name = $_POST['name'];
	$userId = $_POST['userId'];
	$post = mysqli_real_escape_string($connection,$_POST["post"]);

	$InsertPost = "INSERT INTO post (p_name,post,p_date,user_id) VALUES ('{$name}','{$post}',CURRENT_DATE,{$userId})";
	$ResultPost = mysqli_query($connection,$InsertPost);
	
	if($ResultPost) {
		echo "success";	
	} else {
		echo "failed";	
	}
?>