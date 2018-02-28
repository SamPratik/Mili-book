<?php include_once("dbConnector.php"); ?>

<?php
	
	$postId = $_POST["postId"];
	$name = $_POST["name"];
	$comment = mysqli_real_escape_string($connection,$_POST["comment"]);
	$id = $_POST["userId"];
	
	$InsertComment = "INSERT INTO l_comment (c_name,comment,c_date,user_id) VALUES ('{$name}','{$comment}',CURRENT_DATE,{$id})";
	$ResultComment = mysqli_query($connection,$InsertComment);
	
	$InsertPIdCId = "INSERT INTO l_has_c (l_id) VALUES ({$postId})";
	$ResultPidCid = mysqli_query($connection,$InsertPIdCId);
	
	if($ResultComment && $ResultPidCid) {
		echo "success";	
	} else {
		echo "failed";	
	}
	
	//echo $comment;
	
?>