
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>



body {
    font-family: Arial;
    padding: 20px;
    background:  #f1f1f1;
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
	<h2>Welcome to my blog</h2>
</div>

<p> Please leave a comment if you like my design</p>

<div class= "right">
	<a href= "index.php" >Home</a>&nbsp;|&nbsp;
	<a href="form.php">Admin:Sign in</a>&nbsp;|&nbsp;
	<a href="userlogin.php">user:Sign in</a>&nbsp;|&nbsp;
	<a href="newuser.php">Register</a>
</div>
<br>
<br>
<?php 
 include 'header.php';
 require 'mysql.php';

  show_posts();

?>


	

	
</body>
</html>
