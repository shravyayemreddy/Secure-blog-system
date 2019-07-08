
<?php
	require 'secureauthentication.php';
	$postid= $_GET['id'];
	if(delete_post($postid))
		echo "<script>alert('Post deleted successfully.');</script>";
	else
		echo "<script>alert('Unable to delete post');</script>";
	header("Refresh:0; url=user.php");
	die();
?>
