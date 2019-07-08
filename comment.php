
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

body {
    font-family: Arial;
    padding: 20px;
    background: #f1f1f1;
}
.header {
    padding: 30px;
    font-size: 40px;
    text-align: center;
    background: white;
}
.rightcol
umn {   
    float:right;
    width: 100%;
}

.right {
    text-align: right;
    float: right;
}
@media screen and (max-width: 800px) {
    .leftcolumn, .rightcolumn {   
        width: 100%;
        padding: 0;
    }
}
</style>
</head>
<body>

<div class="header">
  <h2>My Blog</h2>
</div>
  
<div class= "left">
<h1>Comments</h1>
</div>

</div>
<div class= "right">
<a href= "index.php" >Home</a>


</div>
<?php  
  session_start();
  require 'mysql.php';
  $postid = $_REQUEST['postid'];
  if(!isset($postid)){
    echo "Bad Request";
    die();
  }
  function handle_new_comment($postid){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $commenter = $_POST['commenter'];
    $nocsrftoken = $_POST["nocsrftoken"];
    $sessionnocsrftoken = $_SESSION["nocsrftoken"];
    if (isset($title) and isset($content) ){
	if(!isset($nocsrftoken) or ($nocsrftoken!=$sessionnocsrftoken)){
	echo "Cross-site request forgery is detected!";
	die();
        }
    if(new_comment($postid,$title,$content,$commenter))
	echo "New comment added";
    else
	echo "Cannot add the comment";
    }
  }
  handle_new_comment($postid);
  display_singlepost($postid);
  display_comments($postid);
  $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;
?>
<form action="comment.php?postid=<?php echo $postid; ?>" method="POST" class="form login">
  <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />
  Your Name : <input type="text" name="commenter" /><br>
  Title:    :<input type="text" name="title" required/><br>
  Content : <textarea name="content" required cols="100" rows="10"></textarea><br>
  <button class="button" type="submit">Post New Comment</button>
</form>

