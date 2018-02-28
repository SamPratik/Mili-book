<?php include_once("dbConnector.php"); ?>

<?php
	
	$bookId = $_POST["bookId"];
	$selVal = $_POST["selVal"];
	$userId = $_POST["userId"];
	
	$insertRating = "INSERT INTO books_rating (book_id,rating,user_id) VALUES ({$bookId},{$selVal},{$userId})";
	$resultRating = mysqli_query($connection,$insertRating);
	
	if($resultRating) {
		echo "success";
	} else {
		echo "failed";	
	}

	
	//echo $bookId . " " . $selVal;
	
?>