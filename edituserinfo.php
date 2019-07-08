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

/* Header/Blog Title */
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
<h1>Update Details</h1>
</div>

</div>
<div class= "right">
<a href= "index.php" >Home</a>
<a href= "user.php" >My Account</a>


</div>
<?php
  session_start();
require 'secureauthentication.php';
 //include 'header.php';
 //require 'mysql.php';
$username = $_SESSION['username'];
echo $username;
$sql= "SELECT * FROM users where username='$username'";

	$result = $mysqli->query($sql);
$row= $result->fetch_assoc();

?>
<?php

function handle_update_info () {
 //echo "username= $username";
 $email = $_POST['email'];
$phone = $_POST['phone'];
$name = $_POST['name'];
$username= $_POST['username'];
 //echo $name;
 	$nocsrftoken = $_POST["nocsrftoken"];
    $sessionnocsrftoken = $_SESSION["nocsrftoken"];

 	
  if (isset($email) and isset($name) and isset($name) and isset($username) ){
if(!isset($nocsrftoken) or ($nocsrftoken!=$sessionnocsrftoken)){
	echo "Cross-site request forgery is detected!";
	die();
        }

     if(update_info($email,$phone,$name,$username))
        echo "info has been updated ";
      else
	 echo "cannot update the info";
   } 

}
handle_update_info();
$rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;


?>

<form action="edituserinfo.php?username=<?php echo $username;?>" method="POST" class="form post">
	<input type="hidden" name="nocsrftoken" value="<?php echo $rand;?>"/>
	<input type="hidden" name="username" value="<?php echo $username;?>"/>
Email: <input type='text' name='email' value="<?php echo $row['email']?>"/> <br>

	Phone: <input type='text' name='phone' value="<?php echo $row['phone']?>"/> <br>
name: <input type='text' name='name' value="<?php echo $row['name']?>"/> <br>


	<button class="button" type="submit">
        Update
	</button>
</form>

