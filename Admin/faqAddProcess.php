<?php include_once("dbConnector.php"); ?>

<?php

	$question = mysqli_real_escape_string($connection,$_POST["question"]);
	$answer = mysqli_real_escape_string($connection,$_POST["answer"]);

	$insertFaq = "INSERT INTO faq (q_date,question,a_date,answer) VALUES (CURRENT_DATE,'{$question}',CURRENT_DATE,'{$answer}')";
	$resultFaq = mysqli_query($connection,$insertFaq);
	
	if($resultFaq) {
		echo "success";
	} else {
		echo "failed";	
	}

?>