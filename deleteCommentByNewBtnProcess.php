<?php include_once("dbConnector.php"); ?>

<?php
	$userId = $_GET["userId"];
	$sql = "SELECT id FROM comment WHERE user_id={$userId} ORDER BY id DESC LIMIT 1";
	$result = mysqli_query($connection,$sql);
	
	if(mysqli_num_rows($result)) {
		$row = mysqli_fetch_assoc($result);
		//echo $row["id"];
		
		$DeleteIdComment = "DELETE FROM comment WHERE id={$row['id']}";
		$ResultIdComment = mysqli_query($connection,$DeleteIdComment);
		
		$DeleteCidPHasC = "DELETE FROM p_has_c WHERE c_id={$row['id']}";
		$ResultCidPHasC = mysqli_query($connection,$DeleteCidPHasC);
		if($ResultIdComment && $ResultCidPHasC) {
			echo "success";
		} else {
			echo "failed";	
		}
	}
?>