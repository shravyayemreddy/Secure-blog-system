

<?php
include 'header.php';
 require 'mysql.php';

function handle_add_user() {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $name = $_POST['name'];
 	
  if (isset($username) and isset($password) ){
     if(add_user($username,$password,$email,$phone,$name))
        alert("User Registration Successful");
      else
	 alert("Something went wrong while trying to register.");;
   }
}
handle_add_user();
$rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;

?>
<form action="newuser.php" method="POST" class="form login">
	<div align="center">
		<h3> <b> New User Registration </b> </h3>
		<table>
		<tr>
		<td> Username: </td>
		<td> <input type="text" class="text_field" name="username" required pattern="\w+" title="Please enter a valid username" 
		onchange="this.setCustomValidity(this.validity.patternMismatch ?this.title :'');">
		</td>
		</tr>
		<tr>
		<td>Password: </td>
		<td>		
		<input type="password" required pattern="(?=.*[A-Z]).{6,}" name="password" onchange="form.newpassword2.pattern = this.value" /> <br>
		</td>
		</tr>
		<tr>
		<td>
		email:</td>
		<td><input type="text" class="text_field" name="email"/></td></tr>
		<tr><td>phone:</td><td><input type = "text" class = "text_field" name="phone"/></td></tr>
		<tr><td>
		name:</td><td><input type = "text" class = "text_field" name = "name"/></td></tr>
		</table>
		<button class="button" type="submit">Register</button>
	</div>
</form>
