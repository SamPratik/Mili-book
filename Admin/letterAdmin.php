<?php session_start(); ?>
<?php 
	if($_SESSION["adminVerified"] == 0) {
		header("location: login.php");	
	}
?>

<?php  
	if(isset($_SESSION["name"]))  
	{  
	   if((time() - $_SESSION['last_login_timestamp']) > 900) // 900 = 15 * 60  
	   {  
			header("location:logout.php");  
	   }  
	   else  
	   {  
			$_SESSION['last_login_timestamp'] = time();  
	   }  
	}  
?> 

<?php include_once("dbConnector.php"); ?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="css/contact.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>Admin Letters</title>

<style>
	.comments {
		display:none;	
	}
		
</style>

</head>

<body>

	<!--------START: Header----------->
    <?php include_once("header.php"); ?>
    <!--------END: Header----------->
    
	
    <div class="content">
    
        <div class="container"><br/>
            <div class="search-bar-container row">
            	<h2 class="col-xs-5 pull-left">Letters List <button class="btn btn-primary" data-toggle="modal" data-target="#addLetterModalId"><i class="fa fa-plus" aria-hidden="true"></i> Add Letter</button></h2>
                <div class="col-xs-4 pull-right input-group" style="padding-top:10px;right:12px;">
                	<span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                    <input class="form-control" id="searchBarId" type="text" placeholder="search here by letter names" onKeyUp="searchProcess(this.value,<?php echo $_SESSION["id"]; ?>,'<?php echo $_SESSION["name"]; ?>')">
                </div>
            </div>
            
  
                
            <ul class="list-group" id="showResultsId">                
            

                
                
			</ul>
                
                
           

        </div>
        
    </div>
    
    <!-----------Contact Us-------------->
    <?php include_once("contact.php"); ?>
    
    <!-----------Footer------------>
	<?php include_once("footer.php"); ?>
    
    
    <!-- START: Add Letter Modal -->
    <div class="modal fade" id="addLetterModalId" role="dialog">
        <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                	<button type="button" class="close" data-dismiss="modal">&times;</button>
                	<h4 class="modal-title">Add Letter</h4>
                </div>
                <div class="modal-body">
                
                	<form id="addLetterFormId">
                        <div class="form-group">
                            <label for="usr">Title:</label>
                            <input name="title" type="text" class="form-control" id="titleId" required>
                        </div>
                        <div class="form-group">
                        	<label for="sel1">Select list (select one):</label>
                            <select class="form-control" id="catId" name="cat" required>
                                <option value="operational">Operational</option>
                                <option value="admin">Admin</option>
                                <option value="training">Training</option>
                                <option value="misc">MISC</option>
                            </select>
                        </div>
                        <div class="form-group">
                        	<label for="usr">Upload Letter:</label>
                        	<input type="file" name="myFile" id="myFileId" required>
                        </div>
                        <div class="form-group">
                        	<button class="btn btn-success pull-right" type="button" onClick="addLetter()">Submit</button>
                        </div>
                    </form>
                    
                </div><br/>
                <div class="modal-footer">
                	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        
        </div>
    </div>
    <!-- END: Add Letter Modal -->
    
    
    <!-------Loading post & comment list---------->
    <script>
		
		$(document).ready(function() {
            
			$("#showResultsId").load("letterSearchLoad.php?type=admin");
			
        });
		
	</script>
    
	<!-----------Add Letter From Database Using AJAX---------->
	<script>
        
        function addLetter() {
        
            var fd = new FormData(document.querySelector("#addLetterFormId"));
            
            $.ajax({
                
                url: "addLetterProcess.php",
                type: "POST",
                data: fd,
                contentType: false,
                processData: false,
                success: function(e) {
                    if(e.indexOf("success") != -1) {
                        alert("Letter has been uploaded!");
                        document.getElementById("addLetterFormId").reset();
                        window.location = "letterAdmin.php";
                    }
                    if(e.indexOf("failed") != -1) {
                        alert("Failed to upload the letter!");
                    }
                }
                
            });
        }
        
    </script>
    
    
    <!-----------showing results of search onKeyUp---------->
	<script>
        
        function searchProcess(searchTerm,userId,userName) {
        
            var x = "", y = ""; 
        
            if(searchTerm.length != 0 && searchTerm != " ") {
            
                $.get(
                
                    "letterSearchProcess.php",
                    {
                        searchTerm: searchTerm,
						type: 'admin'
                    },
                    function(output) {
						//alert(output);

						
 						var searchArr = JSON.parse(output);
                        var showResult = document.getElementById("showResultsId");
						showResult.innerHTML = "";
						
						for(i=0; i<searchArr.length; i++) {
							
							
							var listElement = document.createElement("li");
							listElement.setAttribute("class", "list-group-item list-group-item-success");
							
							/*****************START: Outer Media*****************/
							
							var outerMedia = document.createElement("div");
							outerMedia.setAttribute("class", "media");
							
							/********** START: Media Left **********/
							var outerMediaLeft = document.createElement("div");
							outerMediaLeft.setAttribute("class", "media-left");
							
							var outerImg = document.createElement("img");
							outerImg.setAttribute("class", "media-object");
							outerImg.setAttribute("src", "images/blankImage.gif");
							outerImg.setAttribute("style", "width:45px;");
							
							outerMediaLeft.appendChild(outerImg);
							/********** END: Media Left **********/
							
							/*****************START: Outer Media-Body*****************/
							
							var outerMediaBody = document.createElement("div");
							outerMediaBody.setAttribute("class", "media-body");
							
							var outerH4Element = document.createElement("h4");
							outerH4Element.setAttribute("class", "media-heading");
							
							var h4Text = document.createTextNode("Sakib Mahmud "); 
							outerH4Element.appendChild(h4Text);
							
							var smallElement = document.createElement("small");
							
							var iElement = document.createElement("i");
							var iText = document.createTextNode("Posted on " + searchArr[i].l_date);
							iElement.appendChild(iText);
							smallElement.appendChild(iElement);
							outerH4Element.appendChild(smallElement);
							
							var pElement = document.createElement("p");
							var anchorElement = document.createElement("a");
							anchorElement.setAttribute("href", "Admin/uploads/" + searchArr[i].file_name)
							var anchorText = document.createTextNode(searchArr[i].title);
							anchorElement.appendChild(anchorText);
							
							var spanElement = document.createElement("span");
							spanElement.setAttribute("class", "pull-right");
							
							var buttonElement = document.createElement("button");
							buttonElement.setAttribute("class", "btn btn-primary btn-xs");
							buttonElement.setAttribute("onClick", "showComments(" + searchArr[i].l_id + ")");
							
							var buttonIElement = document.createElement("i");
							buttonIElement.setAttribute("class", "fa fa-comment");
							buttonIElement.setAttribute("aria-hidden", "true");
							
							buttonElement.appendChild(buttonIElement);
							
							var buttonText = document.createTextNode(" Show Comments");
							buttonElement.appendChild(buttonText);
							
							spanElement.appendChild(buttonElement);
							
							pElement.appendChild(anchorElement);
							pElement.appendChild(spanElement);
							
							var clear = document.createElement("div");
							clear.setAttribute("style", "clear:both;");
							
							var commentsElement = document.createElement("div");
							commentsElement.setAttribute("class", "comments");
							commentsElement.setAttribute("id", "commentId" + searchArr[i].l_id);
							
							var appendElement = document.createElement("div");
							appendElement.setAttribute("id", "appendId" + searchArr[i].l_id);
							
							/*******START: Have to use another for loop for c_id property******/
							for(j=0; j<searchArr[i].c_id.length; j++) {
								var nestedMediaDiv = document.createElement("div");
								nestedMediaDiv.setAttribute("class", "media");
								nestedMediaDiv.setAttribute("id", "removeCommentId" + searchArr[i].c_id[j]);
								
								var innerMediaLeft = document.createElement("div");
								innerMediaLeft.setAttribute("class", "media-left");
								var innerImgMedia = document.createElement("img");
								innerImgMedia.setAttribute("class", "media-object");
								innerImgMedia.setAttribute("src", "images/blankImage.gif");
								innerImgMedia.setAttribute("style", "width:45px;");
								
								innerMediaLeft.appendChild(innerImgMedia);
								nestedMediaDiv.appendChild(innerMediaLeft);
								
								var nestedMediaBody = document.createElement("div");
								nestedMediaBody.setAttribute("class", "media-body");
								
								var innerH4Element = document.createElement("h4");
								innerH4Element.setAttribute("class", "media-heading");
								
								var innerh4Text = document.createTextNode(userName + " ");
								innerH4Element.appendChild(innerh4Text);
								
								var innerSmallElement = document.createElement("small");
								
								var innerIElement = document.createElement("i");
								var innerIText = document.createTextNode("Posted on " + searchArr[i].c_date[j]);
								innerIElement.appendChild(innerIText);
								innerSmallElement.appendChild(innerIElement);
								innerH4Element.appendChild(innerSmallElement);
								
								nestedMediaBody.appendChild(innerH4Element);
								
								var innerPElement = document.createElement("p");
								var innerPText = document.createTextNode(searchArr[i].comments[j]);
								innerPElement.appendChild(innerPText);
								
								/*********	START: optional**********/
								
								if(userId == searchArr[i].user_id[j]) {
									var innerSpanElement = document.createElement("span");
									innerSpanElement.setAttribute("class", "pull-right");
									
									var innerButtonElement = document.createElement("button");
									innerButtonElement.setAttribute("class", "btn btn-danger btn-xs");
									innerButtonElement.setAttribute("onClick", "deleteComment(" + searchArr[i].c_id[j] + ")");
									
									var innerButtonIElement = document.createElement("i");
									innerButtonIElement.setAttribute("class", "fa fa-trash-o");
									innerButtonIElement.setAttribute("aria-hidden", "true");
									
									var innerButtonText = document.createTextNode(" Delete");
									
									var innerClear = document.createElement("div");
									innerClear.setAttribute("style", "clear:both;");
									
									innerButtonElement.appendChild(innerButtonIElement);
									innerButtonElement.appendChild(innerButtonText);
									innerSpanElement.appendChild(innerButtonElement);
									innerPElement.appendChild(innerSpanElement);
									innerPElement.appendChild(innerClear);
								
								}
								
								/*********END: optional**********/
								
								nestedMediaBody.appendChild(innerPElement);
								
								nestedMediaDiv.appendChild(nestedMediaBody);
								
								appendElement.appendChild(nestedMediaDiv);
								
							}
							/*******END: Have to use another for loop for c_id property******/
							
							commentsElement.appendChild(appendElement);
							
							var formElement = document.createElement("form");
							formElement.setAttribute("id", "commentFormId" + searchArr[i].l_id);
							
							var formGroup = document.createElement("div");
							formGroup.setAttribute("class", "form-group");
							
							var textArea = document.createElement("textarea");
							textArea.setAttribute("class", "form-control");
							textArea.setAttribute("rows", "2");
							textArea.setAttribute("id", "Reply" + searchArr[i].l_id);
							
							formGroup.appendChild(textArea);
							formElement.appendChild(formGroup);
							
							var formButton = document.createElement("button");
							formButton.setAttribute("id", "commentBtnId");
							formButton.setAttribute("type", "button");
							formButton.setAttribute("class", "btn btn-primary btn-xs pull-right");
							formButton.setAttribute("onClick", "commentSubmit(" + searchArr[i].l_id + ",'<?php echo $_SESSION["name"]; ?>'," + userId + ")");
							var formButtonText = document.createTextNode(" Comment");
							formButton.appendChild(formButtonText);
							
							formElement.appendChild(formButton);
							
							commentsElement.appendChild(formElement);
							
							/***********START: Appending to outer media-body***********/
							outerMediaBody.appendChild(outerH4Element);
							outerMediaBody.appendChild(pElement);
							outerMediaBody.appendChild(clear);
							outerMediaBody.appendChild(commentsElement);
							/***********END: Appending to outer media-body***********/
							
							
							/*****************END: Outer Media-Body*****************/
							
							outerMedia.appendChild(outerMediaLeft);
							outerMedia.appendChild(outerMediaBody);
							
							listElement.appendChild(outerMedia);
							
							/*****************END: Outer Media*****************/
							
							
							
							showResult.appendChild(listElement);
						}

                    }                       

                
                );
                
            } else {
				
				$("#showResultsId").load("letterSearchLoad.php?type=admin");	
				
			}
            
        }
        
    </script>  
    
    
    <!-----------Slide toggle comments------------->
    <script>
        
        function showComments(id) {
            
            $("#commentId" + id).slideToggle("fast");
                
        }
        
    </script>
    
    
    <!---------Send Comment to Database---------->
    <script>
    
        var count = 0;
    
        function commentSubmit(postIdJs,commentName,userId) {
            
            //-----START: Create Current Date-------
            
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();
            
            if(dd<10) {
                dd='0'+dd
            } 
            
            if(mm<10) {
                mm='0'+mm
            } 
            
            today = yyyy+'-'+mm+'-'+dd;
            
            //-----END: Create Current Date-------
            
            commentJS = document.getElementById("Reply" + postIdJs).value;
            count++; 
            
            $.post(
                "letterCommentProcess.php",
                {
                    comment: commentJS,
                    postId: postIdJs,
                    name: '<?php echo $_SESSION["name"]; ?>',
                    userId: <?php echo $_SESSION["id"]; ?>
                },
                function(e) {
                    if(e.indexOf("success") != -1) {
                        //alert("Successfully Commented!");	
                        
                        document.getElementById("commentFormId" + postIdJs).reset();
                        
                        //------Dynamically creating the Media Div----
                        var mediaDiv = document.createElement("div");
                        mediaDiv.setAttribute("class","media");
                        mediaDiv.setAttribute("id", "removeNewComment" + count);
                        
                        var mediaLeftDiv = document.createElement("div");
                        mediaLeftDiv.setAttribute("class", "media-left");
                        
                        var img = document.createElement("img");
                        img.setAttribute("src", "images/blankImage.gif");
                        img.setAttribute("class", "media-object");
                        img.setAttribute("style", "width:45px");
                        
                        mediaLeftDiv.appendChild(img);
                        
                        mediaDiv.appendChild(mediaLeftDiv);
                        
                        var mediaBody = document.createElement("div");
                        mediaBody.setAttribute("class","media-body");
                        
                        var h4Element = document.createElement("h4");
                        h4Element.setAttribute("class","media-heading");
                        
                        var h4Text = document.createTextNode(commentName);
                        h4Element.appendChild(h4Text);
                        
                        var smallElement = document.createElement("small");
                        
                        var iElement = document.createElement("i");
                        
                        var iText = document.createTextNode(" Posted on " + today);
                        
                        iElement.appendChild(iText);
                        
                        smallElement.appendChild(iElement);
                        
                        h4Element.appendChild(smallElement);
                        
                        mediaBody.appendChild(h4Element);
                        
                        var pElement = document.createElement("p");
                        var pText = document.createTextNode(commentJS);
                        pElement.appendChild(pText);
                        
                        /*******************************************/
                        var spanElement = document.createElement("span");
                        spanElement.setAttribute("class","pull-right")
                        
                        var buttonElement = document.createElement("button");
                        buttonElement.setAttribute("class", "btn btn-danger btn-xs");
                        buttonElement.setAttribute("onClick","deleteCommentByNewBtn(<?php echo $_SESSION["id"]; ?>,"+count+")");
                        
                        var iElement1 = document.createElement("i");
                        iElement1.setAttribute("class","fa fa-trash-o");
                        
                        buttonElement.appendChild(iElement1);
                        
                        var buttonText = document.createTextNode(" Delete");
                        buttonElement.appendChild(buttonText);
                        
                        spanElement.appendChild(buttonElement);
                        
                        pElement.appendChild(spanElement);
                        /*******************************************/
                        
                        mediaBody.appendChild(pElement);
                        
                        mediaDiv.appendChild(mediaBody);
                        
                        document.getElementById("appendId" + postIdJs).appendChild(mediaDiv);
                        
                
                    }
                    if(e.indexOf("failed") != -1) {
                        alert("Failed to Comment!");	
                    }
                }
            );
            
        }
        
    </script>
    
    
    <!----------Delete Comment------------>
    <script>
        function deleteComment(commentIdJs) {
            
            $.get(
                "letterDeleteCommentProcess.php",
                {
                    commentId: commentIdJs
                },
                function(e) {
                    if(e.indexOf("success") != -1) {
                        //alert("Successfully Deleted!");
                        $("#removeCommentId" + commentIdJs).remove();
                    }
                    if(e.indexOf("failed") != -1) {
                        alert("Failed to Delete!");
                    }
                }
            );
            
        }
    </script>
    
	<script>
        function deleteCommentByNewBtn(userId,count) {
            
            $.get(
                "letterDeleteCommentByNewBtnProcess.php",
                {
                    userId: userId
                },
                function(e) {
                    if(e.indexOf("success") != -1) {
                        //alert("Successfully Deleted!");
                        $("#removeNewComment" + count).remove();
                        //window.location = "forum.php";
                    }
                    if(e.indexOf("failed") != -1) {
                        alert("Failed to Delete!");
                    }
                }
            );//alert(userId+"\n"+count);
            
        }
    </script>


    <!--------------Scrolling Animation----------->
    <script>
    
    $(document).ready(function() {
        
      // Add smooth scrolling to all links in navbar + footer link
      $(".navbar a, div a[href='#top']").on('click', function(event) {
        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
          // Prevent default anchor click behavior
          event.preventDefault();
    
          // Store hash
          var hash = this.hash;
    
          // Using jQuery's animate() method to add smooth page scroll
          // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
          $('html, body').animate({
            scrollTop: $(hash).offset().top
          }, 900, function(){
       
            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
          });
        } // End if
      });
        
      $(window).scroll(function() {
        $(".slide-anim").each(function(){
          var pos = $(this).offset().top;
    
          var winTop = $(window).scrollTop();
            if (pos < winTop + 600) {
              $(this).addClass("slide");
            }
        });
      });    
    });
    
    </script>
    
    <!---------Adding .active class---------->
    <script>
        document.getElementsByClassName("navBtn")[1].classList.add("active");
    </script>
   
    

</body>
</html>