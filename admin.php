
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

<a href= "changepasswordform.php">change password</a> | 
<a href= "adminlogout.php">logout</a>

</div>




<?php
require 'secureauthenticationadmin.php';
//require 'mysql.php';
?>






<br>

<?php
$isAdmin = $_SESSION["isAdmin"];
$username = $_SESSION["username"];
$enable = $_SESSION["enable"];

echo $Enable;
if ($isAdmin == 1) {
	echo '<br><br><h3 align="center">USERS</h3><br>';
	$sql= "SELECT * FROM users";
	$result = $mysqli->query($sql);
	if ($result->num_rows>0)
	{
		echo '<div align="center"><br><br><table border="1">';
		echo "<tr><td>UserName </td><td>Name</td><td>Action</td></tr>";
		while($dis =  $result->fetch_assoc())
		{
			$userName = $dis["username"];
			$name = $dis["name"];
			$Approved = $dis["Approved"];
			$Enable = $dis["Enable"];
			echo "<tr><td>$userName</td><td>$name</td>";
			echo '<td><a href= "edituser.php?id='.$dis['username'].'"><p style="text-align:center">'. "Edit".'</a></td>';//editing
		
		}
		echo "</table>";
		echo '</div>';
	}
}


?>

