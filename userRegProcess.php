<?php include_once("dbConnector.php"); ?>

<?php

	$name = $_POST["name"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$ba_no = $_POST["ba_no"];
	$course = $_POST["course"];
	$rank = $_POST["rank"];
	$uniqueId = uniqid();
	$seErrArr = array();
	$flag = 1;
	
	  //---------Name Validation Check--------------
	  if (empty($_POST["name"])) {
		$seErrArr[0] = "* Name is required";
	  } else {
		$name = test_input($_POST["name"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
		  $seErrArr[0] = "* Only letters and white space allowed"; 
		} else {
			$seErrArr[0] = "";	
		}
	  }
	  
	  //---------Email Validation Check--------------
	  if (empty($_POST["email"])) {
		$seErrArr[1] = "* Email is required";
	  } else {
		$email = test_input($_POST["email"]);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $seErrArr[1] = "* Invalid email format"; 
		} else {
			$seErrArr[1] = "";	
		}
	  }
	  
	  //---------password Validation Check--------------
	  if (empty($_POST["password"])) {
		$seErrArr[2] = "* Password is required!";
	  } else {
		$password = test_input($_POST["password"]);
		$seErrArr[2] = "";
	  }
	  
	  //---------ba_no Validation Check--------------
	  if (empty($_POST["ba_no"])) {
		$seErrArr[3] = "* BA No is required!";
	  } else {
		$ba_no = test_input($_POST["ba_no"]);
		$seErrArr[3] = "";
	  }
	  
	  //---------Course Validation Check--------------
	  if (empty($_POST["course"])) {
		$seErrArr[4] = "* Course Name is required";
	  } else {
		$course = test_input($_POST["course"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$course)) {
		  $seErrArr[4] = "* Only letters and white space allowed"; 
		} else {
			$seErrArr[4] = "";	
		}
	  }
	  
	  //---------Rank Validation Check--------------
	  if (empty($_POST["rank"])) {
		$seErrArr[5] = "* Rank is required";
	  } else {
		$rank = test_input($_POST["rank"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$rank)) {
		  $seErrArr[5] = "* Only letters and white space allowed"; 
		} else {
			$seErrArr[5] = "";	
		}
	  }
	  
	  foreach($seErrArr  as $each) {
		  if($each == "") {
			 $flag = 0;
			 continue;
		  } else {
			  $flag = 1;
			  break;
		  }
	  }	
	  
	  if($flag == 1) {
		  echo json_encode($seErrArr);  
	  }
	
	if($flag == 0) {
		$enc_password = md5($password);
		$insertUser = "INSERT INTO register (ba_no,name,rank,course,email,password,code,verified) VALUES ('{$ba_no}','{$name}','{$rank}','{$course}','{$email}','{$enc_password}','{$uniqueId}',0)";
		$resultUser = mysqli_query($connection,$insertUser);
		
		if($resultUser) {
			$message = "The code is: " . $uniqueId;
			$headers = "From: pratik.anwar@gmail.com" . "\r\n";;
			
			mail($email,"Mili-Book",$message,$headers);
			
			echo "success";	
		} 
	
	}

?>

<?php
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
?>