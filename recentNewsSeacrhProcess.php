<?php include_once("dbConnector.php"); ?>

<?php
	
	$searchTerm = $_GET["searchTerm"];
	$out = "[";
		
	$sql = "SELECT id,heading,body FROM recent_news WHERE heading LIKE '%{$searchTerm}%' ORDER BY id DESC";
	$result = mysqli_query($connection,$sql);
	
	while($row = mysqli_fetch_assoc($result)) {
		
		if($out != "[") {
			
			$out .= ",";
				
		}
		
	/*
	
		[
		
			{"id": 1, "heading": "Some Heading", "body": "Some Body"},
			
			{"id": 2, "heading": "Some Heading", "body": "Some Body"},
			
			{"id": 3, "heading": "Some Heading", "body": "Some Body"}
			
		]
	
	*/
		
		$out .= '{"id": '. $row["id"] . ', "heading": "' . $row["heading"] . '", "body_text": "' .$row["body"] . '"}';
		
	}
	
	$out .= "]";
	
	echo $out;
	
?>