<?php
  session_start();
  //echo "->auth.php";
  require 'mysql.php';
  if (isset($_POST["username"]) and isset($_POST["password"]) ){
    //echo "->auth.php:Debug>has username/password";
    if (mysql_checklogin_secureadmin($_POST["username"],$_POST["password"])) 
      $_SESSION["adminlogged"] = TRUE;
    else{
	     echo "<script>alert('Invalid username/password');</script>";
	     unset($_SESSION["adminlogged"]); 
    }
  }
  if (!isset($_SESSION["adminlogged"] ) or $_SESSION["adminlogged"] != TRUE) {
    echo "<script>alert('You have not login. Please login first');</script>";
    //echo "->auth.php:Debug>You have not login. Please login first";
    header("Refresh:0; url=form.php");
    //header( 'Location: form.php' ) ;
    die();
  }
?>

