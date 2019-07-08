
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


.rightcolumn {   
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
  <h2>My blog</h2>
</div>
  
<div class= "left">
<h2>New Post</h2>
</div>

</div>
<div class= "right">
<a href= "index.php" >Home</a> |
<a href= "user.php" >My Account</a>


</div><?php
  session_start();
// include 'header.php';
require 'secureauthentication.php';
function handle_new_post() {
 //echo "I am here";
  $title = $_POST['title'];
  $text = $_POST['text'];
  $owner = $_SESSION['username'];
$nocsrftoken = $_POST["nocsrftoken"];
    $sessionnocsrftoken = $_SESSION["nocsrftoken"];

 	
  if (isset($title) and isset($text) ){
if(!isset($nocsrftoken) or ($nocsrftoken!=$sessionnocsrftoken)){
	echo "Cross-site request forgery is detected!";
	die();
        }
     if(new_post($owner, $title,$text))
        echo "New post added";
      else
	 echo "cannot add the new";
   } else {
	echo " no title / content";
	}
}
handle_new_post();
$rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;
?>
<form action="newpost.php" method="POST" class="form post">
	<input type="hidden" name="nocsrftoken" value="<?php echo $rand;?>"/>
	Title:<input type="text" name="title" /> <br>
	text: <textarea name= "text" required cols="100" rows="10"></textarea><br>
	<button class="button" type="submit">
		Add Post
	</button>
</form>
