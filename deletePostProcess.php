<?php include_once("dbConnector.php"); ?>

<?php
	$postId = $_GET["postId"];
	
	$DeletePost = "DELETE FROM post WHERE id={$postId}";
	$ResultPost = mysqli_query($connection,$DeletePost);
	
	$DeletePHasCComment = "DELETE `comment`, `p_has_c` FROM `comment` INNER JOIN `p_has_c` ON `comment`.`id` = `p_has_c`.`c_id` WHERE p_id={$postId}";
	$ResultPHasCComment = mysqli_query($connection,$DeletePHasCComment);
	
	if($ResultPost && $ResultPHasCComment) {
		echo "success";
	} else {
		echo "failed";
	}
?>