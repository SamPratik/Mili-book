<?php include_once("dbConnector.php"); ?>

<?php
	
	$postId = $_POST["postId"];
	$name = $_POST["name"];
	$comment = mysqli_real_escape_string($connection,$_POST["comment"]);
	$id = $_POST["userId"];
	
	$InsertComment = "INSERT INTO comment (c_name,comment,c_date,user_id,user_type) VALUES ('{$name}','{$comment}',CURRENT_DATE,{$id},'admin')";
	$ResultComment = mysqli_query($connection,$InsertComment);
	
	$InsertPIdCId = "INSERT INTO p_has_c (p_id) VALUES ({$postId})";
	$ResultPidCid = mysqli_query($connection,$InsertPIdCId);
	
	if($ResultComment && $ResultPidCid) {
		echo "success";	
	} else {
		echo "failed";	
	}
	
	//echo $comment;
	
?>