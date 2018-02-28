<?php include_once("dbConnector.php"); ?>
<?php
	
	$book_title = mysqli_real_escape_string($connection,$_POST["book_title"]);
	$desc = mysqli_real_escape_string($connection,$_POST["desc"]);

	/*--------------------------------------------------------------------------------------

	--------------------------Variables Related to Files Info-------------------------------
	
	--------------------------------------------------------------------------------------*/
	
	//if($_FILES['myFile']['size'] != 0) {
	
	 //----- file er name ta pacchi-------
	 $fileBook = $_FILES['book']['name'];

	 
	 //---- file er path ta pacchi--------
	 $file_book_loc = $_FILES['book']['tmp_name'];
	 
	 //----jei directory te file gula save thakbe upload er pore----
	 $folderBook="uploads/";
	 
	 //-------PC er main location theke upload folder e move hocche file upload er pore------
	 move_uploaded_file($file_book_loc,$folderBook.$fileBook);
	 
	 //----- file er name ta pacchi-------
	 $fileCover = $_FILES['image']['name'];

	 
	 //---- file er path ta pacchi--------
	 $file_cover_loc = $_FILES['image']['tmp_name'];
	 
	 //----jei directory te file gula save thakbe upload er pore----
	 $folderCover="book cover images/";
	 
	 //-------PC er main location theke upload folder e move hocche file upload er pore------
	 move_uploaded_file($file_cover_loc,$folderCover.$fileCover);
	 

	 
	$insert = "INSERT INTO books (book_file_name,images_file_name,book_title,description) VALUES ('{$fileBook}','{$fileCover}','{$book_title}','{$desc}')";
	$result = mysqli_query($connection,$insert);
	
 	if($result) {
		echo "success";	
	} else {
		echo "failed";	
	}
 	
?>