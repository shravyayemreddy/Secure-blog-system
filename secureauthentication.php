<?php

  ini_set("session.cookie_httponly", True); 
  ini_set("session.cookie_secure", True); 

  session_start();

  require 'mysql.php';

  if (isset($_POST["username"]) and isset($_POST["password"]) ){
    
    if (mysql_checklogin_secure($_POST["username"],$_POST["password"])){ 
      $_SESSION["logged"] = TRUE;
      $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
      $_SESSION["username"] = $_POST["username"];
    }
    else{
	     echo "<script>alert('Invalid username/password');</script>";
	     unset($_SESSION["logged"]); 
    }
  }

  if (!isset($_SESSION["logged"] ) or $_SESSION["logged"] != TRUE) {
    echo "<script>alert('You have not login. Please login first');</script>";
    
    header("Refresh:0; url=form.php");
    

    die();
  }

 if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){//for browser hijack prevention
 echo "<script>alert('Session hijacking is detected!');</script>";
 header("Refresh:0; url=form.php");
  die();
  }

?>
