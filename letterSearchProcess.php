<?php include_once("dbConnector.php"); ?>

<?php

	$searchTerm = $_GET["searchTerm"];
	$out = "[";
	
	
	$sql = "SELECT id,title,file_name,date FROM letters WHERE title LIKE '%{$searchTerm}%' AND type='{$_GET['type']}' ORDER BY id DESC";
	$result = mysqli_query($connection,$sql);
	
	
	while($row = mysqli_fetch_assoc($result)) {
		
		$selectCid = "SELECT c_id FROM l_has_c WHERE l_id={$row['id']}";
		$resultCid = mysqli_query($connection,$selectCid);
		$comments = "[";
		$cid = "[";
		$c_date = "[";
		$userId = "[";
		
		while($rowCid = mysqli_fetch_assoc($resultCid)) {
		
			if($comments != "[") {
				$comments .= ",";	
			}
			if($cid != "[") {
				$cid .= ",";	
			}
			if($c_date != "[") {
				$c_date .= ",";	
			}
			if($userId != "[") {
				$userId .= ",";	
			}
		
			$selectComments = "SELECT id,comment,c_date,user_id FROM l_comment WHERE id={$rowCid['c_id']}";
			$resultComments = mysqli_query($connection,$selectComments);
			
			$rowComment = mysqli_fetch_assoc($resultComments);
			$comments .= '"'. $rowComment["comment"] .'"';
			$cid .= $rowComment["id"];
			$userId .= $rowComment["user_id"];
			$c_date .= '"'. $rowComment["c_date"] .'"';
			
		}
		
		$comments .= "]";
		$cid .= "]";
		$c_date .= "]";
		$userId .= "]";
		
		if($out != "[") {
			
			$out .= ",";
				
		}
		
	/*
	
		[
		
			{"l_id": 1, "title": "Some Title", "file_name": "Some Name", "date": "2015-5-15", "c_name": "Pratik", "c_id": [4,6,8], "comments": ["first commnet","second commnet","third commnet"], "c_date": ["2015-5-15","2015-5-15","2015-5-15"], "user_id": [41,34,54]},
			
			{"l_id": 2, "title": "Another Title", "file_name": "Another Name", "date": "2017-7-17", "c_name": "Pratik", "c_id": [4,6,8], "comments": ["first commnet","second commnet","third commnet"], "c_date": ["2015-5-15","2015-5-15","2015-5-15"], "user_id": [41,34,54]},
			
			{"l_id": 3, "title": "Demo Title", "file_name": "Demo Name", "date": "2016-8-19", "c_name": "Pratik", "c_id": [4,6,8], "comments": ["first commnet","second commnet","third commnet"], "c_date": ["2015-5-15","2015-5-15","2015-5-15"], "user_id": [41,34,54]}
			
		]
	
	*/
		
		$out .= '{"l_id": '. $row["id"] . ', "title": "' . $row["title"] . '", "file_name": "' . $row["file_name"] . '", "l_date": "' . $row["date"] . '", "c_id": ' . $cid . ', "comments": ' . $comments . ', "c_date": ' . $c_date . ', "user_id": ' .$userId . '}';
		
	}
	
	$out .= "]";
	
	echo $out;

?>