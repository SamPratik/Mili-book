<?php session_start(); ?>

<?php include_once("dbConnector.php"); ?>
<!-----------START: Retirieving Letters------------->
<?php
	
	$SelectLetter = "SELECT id,title,date,file_name FROM letters WHERE type='{$_GET['type']}' ORDER BY id DESC";
	$ResultLetter = mysqli_query($connection,$SelectLetter);
	
?>

<?php while($RowLetter = mysqli_fetch_assoc($ResultLetter)) { ?>

<li class="list-group-item list-group-item-success">
	

	<!----------START: main media object------------> 
	<div class="media">
	
		<div class="media-left">
			<img src="images/blankImage.gif" class="media-object" style="width:45px">
		</div>
		
		<!---------START: Media Body-------->
		<div class="media-body">
			<h4 class="media-heading">Sakib Mahmud <small><i>Posted on <?php echo $RowLetter['date']; ?></i></small></h4>
			<p>
				<a href="uploads/<?php echo $RowLetter["file_name"]; ?>"><?php echo $RowLetter["title"]; ?></a>
				<!--------START: Show Comments & Delete Button------------>
				<span class="pull-right">
					<button class="btn btn-primary btn-xs" onClick="showComments(<?php echo $RowLetter['id']; ?>)"><i class="fa fa-comment" aria-hidden="true"></i> Show Comments</button>
				</span>                                  
			</p>

			<div style="clear:both;"></div> 
			
			<!----------Retrieving c_id for corresponding p_id------------>
			<?php
				$SelectCId = "SELECT c_id FROM l_has_c WHERE l_id={$RowLetter['id']}";
				$ResultCId = mysqli_query($connection,$SelectCId);
			?> 
			
			<!--------START: Comments------------>
			<div class="comments" id="commentId<?php echo $RowLetter['id']; ?>">
			
            	<!--------START: AppendId DIV------------>
                <div id="appendId<?php echo $RowLetter['id']; ?>">
                
					<?php while($RowCId = mysqli_fetch_assoc($ResultCId)) { ?>
                    
                    <!----------Retrieving comment for corresponding c_id------------>
                    <?php  
                        $SelectComment = "SELECT id,c_name,comment,c_date,user_id FROM l_comment WHERE id={$RowCId['c_id']}";
                        $ResultComment = mysqli_query($connection,$SelectComment);
                        
                        $RowComment = mysqli_fetch_assoc($ResultComment);
                    ?>
                
                    <!-- START: Nested media object -->
                    <div class="media" id="removeCommentId<?php echo $RowComment['id']; ?>">
                        <div class="media-left">
                            <img src="images/blankImage.gif" class="media-object" style="width:45px">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $RowComment["c_name"]; ?> <small><i>Posted on <?php echo $RowComment["c_date"]; ?></i></small></h4>
                            <p>
                                <?php echo nl2br($RowComment["comment"]); ?>
                                <!--------START: Delete Button for comments------------>
                                <?php if($_SESSION["id"] == $RowComment["user_id"]) { ?>
                                <span class="pull-right">
                                    <button class="btn btn-danger btn-xs" onClick="deleteComment(<?php echo $RowComment['id']; ?>)">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                    </button>
                                </span>
                                <?php } ?>
                                <!--------END: Delete Button for comments------------>
                                <div style="clear:both;"></div>
                            </p>
                        
                        </div>
                    </div>
                    <!-- END: Nested media object -->
                    
                    <?php } ?>
                    
                </div>
                <!--------END: AppendId DIV------------>
                
                <!--------START: form for comment------->
                <form id="commentFormId<?php echo $RowLetter['id']; ?>">
                    <div class="form-group">
                        <textarea class="form-control" rows="2" id="Reply<?php echo $RowLetter['id']; ?>"></textarea>
                    </div>
                    <button id="commentBtnId" type="button" class="btn btn-primary btn-xs pull-right" onClick="commentSubmit(<?php echo $RowLetter['id']; ?>,'<?php echo $_SESSION["name"]; ?>',<?php echo $_SESSION["id"]; ?>)">Comment</button>
                </form>
                <!--------END: form for comment------->
			
			</div>
			<!--------END: Comments------------>
		
		</div>
		<!---------END: Media Body-------->
		
	</div>
	<!----------END: main media object------------> 
	
</li>

<?php } ?>