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

.hide_class {
	display : none;
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
  <h2>Adminstration of blog</h2>
</div>
<div class= "right">
<a href= "index.php" >Home</a> | 
<a href="admin.php">My Account</a> | 
<a href= "logout.php">logout</a>

</div>

<?php
  session_start();
require 'secureauthenticationadmin.php';

$userid = $_REQUEST['id']; 
$sql= "SELECT * FROM users where username= '$userid'";
$result = $mysqli->query($sql);
if ($result->num_rows>0)
{
	while($dis =  $result->fetch_assoc())
	{
		$userName = $dis["username"];
		$name = $dis["name"];
		$Approved = $dis["Approved"] == 1 ? 'checked' : '';
		$Enable = $dis["Enable"] == 1 ? 'checked' : '';

		
	}
}

?>
<?php

function handle_update_user($userid) {
$approve = $_POST['approved'] == 'on' ? 1 : 0;  
$enable = $_POST['enable'] == 'on' ? 1 : 0;
$nocsrftoken = $_POST["nocsrftoken"];
    $sessionnocsrftoken = $_SESSION["nocsrftoken"];


 	
  if (isset($_POST['username'])){
if(!isset($nocsrftoken) or ($nocsrftoken!=$sessionnocsrftoken)){
	echo "Cross-site request forgery is detected!";
	die();
        }
     if(update_user($userid,$approve,$enable))
        echo "User has been updated ";
      else
	 echo "cannot update the User";
   }

}
handle_update_user($userid);
$rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;
?>

<form action="edituser.php?id=<?php echo $userid;?>" method="POST" class="form post">
	<input type="hidden" name="nocsrftoken" value="<?php echo $rand;?>"/>
	<input type="hidden" name="username" value="<?php echo $userName;?>"/>
	<div align="center">
	<h3 align="center">User Information </h3> <br> <br>
	<table border="1">	
	<tr> <td> Name: </td><td><b> <?php echo $name;?></td></tr>
	<tr> <td> User Name: </td><td><b> <?php echo $userName;?></td></tr>
	<tr> <td>Approved: </td><td><input type='checkbox' name='approved' <?php echo $Approved;?> /> </td></tr>
	<tr> <td>Enable: </td><td><input type='checkbox' name='enable' <?php echo $Enable;?> /> </td></tr></table>
	<br><br><button class='button' type='submit'>update User</button></div>

</form>

