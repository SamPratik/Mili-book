<?php

	include_once("dbConnector.php");
	$bookId = $_GET["bookId"];
	
	$delete = "DELETE from books WHERE id={$bookId}";
	$result = mysqli_query($connection,$delete);


	$delete1 = "DELETE from books_rating WHERE book_id={$bookId}";
	$result1 = mysqli_query($connection,$delete);
	
	if($result && $result1) {
		echo "success";	
	} else {
		echo "failed";	
	}
?>