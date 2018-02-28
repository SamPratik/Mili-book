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

<!------------Retrieving all posts from post table---------->
<?php

	$SelectPost = "SELECT id,p_name,post,p_date,user_id,user_type FROM post ORDER BY id DESC";
	$ResultPost = mysqli_query($connection,$SelectPost);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/navbar.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>Forum</title>

<style>
	.content {
		position:relative;
	}

	.comments {
		display:none;
	}

	.dropdown-menu li a {
		background-color:#fff !important;
		color:#145A32 !important;
		-webkit-transition:background-color .5s, color .5s;
		transition:background-color .5s, color .5s;
	}

	.dropdown-menu li {
		background-color:#fff !important;
		-webkit-transition:background-color 1s;
		transition:background-color .5s;
	}


	.dropdown-menu li:hover {
		background-color:#145A32 !important;
		color:#fff;
	}

	.dropdown-menu li a:hover {
		background-color:#145A32 !important;
	}

</style>
</head>

<body>

	<!--------START: Header----------->
    <?php include_once("header.php"); ?>
    <!--------END: Header----------->


    <!-----------START: content----------->
    <div class="content">

        <div class="container"><br/>
        	<h2 class="text-center">Forum</h2>

            <!-----------START: Post Form----------->
            <form>
                <div class="form-group">
                    <label for="comment">Post:</label>
                    <textarea id="postId" class="form-control" rows="5"></textarea>
                </div>
                <button id="postBtnId" type="button" class="btn btn-success pull-right" onClick="postSubmit('<?php echo $_SESSION["adminName"]; ?>',<?php echo $_SESSION["adminId"]; ?>)">Submit</button>
            </form><br/><br/>
            <!-----------END: Post Form----------->


			<?php while($RowPost = mysqli_fetch_assoc($ResultPost)) { ?>
            <!-----------START: media----------->
            <div id="deletePostId<?php echo $RowPost['id']; ?>" class="media" style="box-shadow:0px 0px 1px black; padding:32px; border-radius:8px;">
                <div class="media-left">
                <img src="images/blankImage.gif" class="media-object" style="width:45px">
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $RowPost["p_name"]; ?> <?php if($RowPost["user_type"] == 'admin') { ?>(Admin)<?php } ?> <small><i>Posted on <?php echo $RowPost["p_date"]; ?></i></small></h4>
                    <p><?php echo nl2br($RowPost["post"]); ?></p>

                    <!--------START: Show Comments & Delete Button------------>
                    <span class="pull-right">
                        <button class="btn btn-primary btn-xs" onClick="showComments(<?php echo $RowPost['id']; ?>)"><i class="fa fa-comment" aria-hidden="true"></i> Show Comments</button>
                        <button class="btn btn-danger btn-xs" onClick="deletePost(<?php echo $RowPost['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                    </span><br/>
                    <!--------END: Show Comments & Delete Button------------>

                    <!----------Retrieving c_id for corresponding p_id------------>
                    <?php
                        $SelectCId = "SELECT c_id FROM p_has_c WHERE p_id={$RowPost['id']}";
                        $ResultCId = mysqli_query($connection,$SelectCId);
                    ?>
                    <!--------START: Comments------------>
                    <div class="comments" id="commentId<?php echo $RowPost['id']; ?>">

            			<div id="appendId<?php echo $RowPost['id']; ?>">
                        <?php while($RowCId = mysqli_fetch_assoc($ResultCId)) { ?>

                            <!----------Retrieving comment for corresponding c_id------------>
                            <?php
                                $SelectComment = "SELECT id,c_name,comment,c_date,user_id,user_type FROM comment WHERE id={$RowCId['c_id']}";
                                $ResultComment = mysqli_query($connection,$SelectComment);

                                $RowComment = mysqli_fetch_assoc($ResultComment);
                            ?>

                            <!-- START: All Comments -->
                            <div class="media" id="removeCommentId<?php echo $RowComment['id']; ?>">
                                <div class="media-left">
                                <img src="images/blankImage.gif" class="media-object" style="width:45px">
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $RowComment["c_name"]; ?> <?php if($RowComment["user_type"] == 'admin') { ?>(Admin)<?php } ?> <small><i>Posted on <?php echo $RowComment["c_date"]; ?></i></small></h4>
                                    <p>
										<?php echo nl2br($RowComment["comment"]); ?>
                                        <!--------START: Delete Button for comments------------>
                                        <span class="pull-right">
                                            <button class="btn btn-danger btn-xs" onClick="deleteComment(<?php echo $RowComment['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                        </span><br/>
                                        <!--------END: Delete Button for comments------------>
                                    </p>

                                </div>
                            </div>
                            <!-- END: All Comments -->

                        <?php } ?>
                        </div>

                        <br/>
                        <!--------START: form for comment------->
                        <form id="commentFormId<?php echo $RowPost['id']; ?>">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" id="Reply<?php echo $RowPost['id']; ?>"></textarea>
                            </div>
                            <button id="commentBtnId" type="button" class="btn btn-primary btn-xs pull-right" onClick="commentSubmit(<?php echo $RowPost['id']; ?>,'<?php echo $_SESSION["adminName"]; ?>',<?php echo $_SESSION["adminId"]; ?>)">Comment</button>
                        </form>
                        <!--------END: form for comment------->

                    </div>
                    <!--------END: Comments------------>


                </div>
            </div>
            <!-----------END: media----------->

            <div style="clear:both;"></div>
            <?php } ?>


        </div>

    </div>
	<!-----------START: content----------->



<!-----------Slide toggle comments------------->
<script>

    function showComments(id) {

        $("#commentId" + id).slideToggle("fast");

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

<!---------Send Post to Database---------->
<script>

	function postSubmit(postName,userId) {

		postJS = document.getElementById("postId").value;

		$.post(
			"postProcess.php",
			{
				post: postJS,
				name: postName,
				userId: userId
			},
			function(e) {
				if(e.indexOf("success") != -1) {
					//alert("Successfully Posted!");
					window.location = "forum.php";
				}
				if(e.indexOf("failed") != -1) {
					alert("Failed to post!");
				}
			}
		);//alert(postName+"\n"+userId);

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
			"commentProcess.php",
			{
				comment: commentJS,
				postId: postIdJs,
				name: '<?php echo $_SESSION["adminName"]; ?>',
				userId: <?php echo $_SESSION["adminId"]; ?>
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

					var h4Text = document.createTextNode(commentName + " (Admin) ");
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
					buttonElement.setAttribute("onClick","deleteCommentByNewBtn(<?php echo $_SESSION["adminId"]; ?>,"+count+")");

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
			"deleteCommentProcess.php",
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

<!----------Delete Post------------>
<script>
	function deletePost(postIdJs) {
		$.get(
			"deletePostProcess.php",
			{
				postId: postIdJs
			},
			function(e) {
				if(e.indexOf("success") != -1) {
					//alert("Successfully Deleted!");
					$("#deletePostId" + postIdJs).remove();
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
			"deleteCommentByNewBtnProcess.php",
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

<!---------Adding .active class---------->
<script>
	document.getElementsByClassName("navBtn")[2].classList.add("active");
</script>


</body>
</html>
