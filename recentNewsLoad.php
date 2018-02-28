<?php session_start(); ?>
<?php include_once("dbConnector.php"); ?>

<!----------Retrieving News------------>
<?php
	$SelectNews = "SELECT id,heading,body FROM recent_news ORDER BY id DESC";
	$ResultNews = mysqli_query($connection,$SelectNews);
?>

<?php while($RowNews = mysqli_fetch_assoc($ResultNews)) { ?>
<a href="fullNews.php?newsId=<?php echo $RowNews['id']; ?>" class="list-group-item">
	<h4 class="list-group-item-heading"><?php echo $RowNews["heading"]; ?></h4>
	<p class="list-group-item-text"><?php echo substr($RowNews["body"],0,400) . "..."; ?></p>
</a>
<?php } ?>