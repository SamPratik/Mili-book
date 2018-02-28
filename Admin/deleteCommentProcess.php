<?php include_once("dbConnector.php"); ?>

<?php
	$commentid = $_GET["commentId"];
	
	$DeleteIdComment = "DELETE FROM comment WHERE id={$commentid}";
	$ResultIdComment = mysqli_query($connection,$DeleteIdComment);
	
	$DeleteCidPHasC = "DELETE FROM p_has_c WHERE c_id={$commentid}";
	$ResultCidPHasC = mysqli_query($connection,$DeleteCidPHasC);
	
	if($ResultIdComment && $ResultCidPHasC) {
		echo "success";
	} else {
		echo "failed";	
	}
?>