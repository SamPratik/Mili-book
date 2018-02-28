<?php include_once("dbConnector.php"); ?>
<?php
	
	$title = mysqli_real_escape_string($connection,$_POST["title"]);
	$cat = $_POST["cat"];

	/*--------------------------------------------------------------------------------------

	--------------------------Variables Related to Files Info-------------------------------
	
	--------------------------------------------------------------------------------------*/
	
	if($_FILES['myFile']['size'] != 0) {
	
	 //----- file er name ta pacchi-------
	 $file = $_FILES['myFile']['name'];
	 
	 //---- file er path ta pacchi--------
	 $file_loc = $_FILES['myFile']['tmp_name'];
	 
	 //----file er size ta pacchi-------
	 $file_size = $_FILES['myFile']['size'];
	 
	 //----ki dhoroner file sheta pabo-----
	 $file_type = $_FILES['myFile']['type'];
	 
	 //----jei directory te file gula save thakbe upload er pore----
	 $folder="uploads/";
	 
	 //-------PC er main location theke upload folder e move hocche file upload er pore------
	 move_uploaded_file($file_loc,$folder.$file);
	 
	 $InsertLetter = "INSERT INTO letters (title,file_name,file_type,file_size,date,type) VALUES ('{$title}','{$file}','{$file_type}',{$file_size},CURRENT_DATE,'{$cat}')";
	 $resultLetter = mysqli_query($connection,$InsertLetter);
	 
	 if($resultLetter) {
		 echo "success";
	 }
	 if(!$resultLetter) {
		 echo "failed";
	 }
	 
	}
 
?>