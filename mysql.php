<?php
 // echo "->mysql.php"; //for debug only; delete this line after the complete development
  //Security principle: Never use the root database account in the web application
  $mysqli = new mysqli('localhost', 'sp2018secad' /*Database username*/,
                                    'p4ss@w@d'  /*Database password*/, 
                                    'sp2018secad' /*Database name*/);

  if ($mysqli->connect_error) {
      die('Connect Error (' . $mysqli->connect_errno . ') '
              . $mysqli->connect_error);
  }
 // echo "->mysql.php:Debug>Connected to the database"; //for debug only; delete this line after the complete development

  function mysql_checklogin_insecure($username, $password) {
    global $mysqli;
    echo "->mysql.php:Debug>->mysql_checklogin_insecure"; //for debug only; delete this line after the complete development
    $sql = "SELECT * FROM users where username=\"" . $username . "\"";
    $sql.= " and password=password(\"". $password . "\");";
    echo "->mysql.php:Debug>sql=$sql"; //for debug only; delete this line after the complete development
    $result = $mysqli->query($sql);
    if ($result->num_rows == 1) {
    	echo "->mysql.php:Debug>:username/password found"; //for debug only; delete this line after the complete development
      return TRUE;
    } else {
      echo "->mysql.php:Debug>:username/password NOT found"; //for debug only; delete this line after the complete development
    }
    return FALSE;

  }
function mysql_checklogin_secure ($username, $password)
{
global $mysqli;
$prepared_sql = "SELECT * FROM users where Enable = '1' and  Approved= '1' and username= ? and password=password(?)";
if(!$stmt = $mysqli->prepare($prepared_sql))
echo "Prepared Statement Error";
$stmt->bind_param("ss",$username,$password);
if(!$stmt->execute()) echo "Execute Error";
if(!$stmt->store_result()) echo "Store_result Error";
if ($stmt->num_rows == 1) return TRUE;
return FALSE;
}

	/*global $mysqli;
	//for super user athentication
	$prepared_sql = "SELECT * FROM users where username= ?"
	. " and password=password(?)";
	if(!$stmt = $mysqli->prepare($prepared_sql))
		echo "Prepared Statement Error";
	//$stmt->bind_param("ss", $username,$password);
	if(!$stmt->execute()) echo "Execute Error";
	if(!$stmt->store_result()) echo "Store_result Error";
	if ($stmt->num_rows > 0) {
		  while ($row = $stmt->fetch()) {
				//echo  $row ;
				echo $stmt;

			if ($row["Approved"] == 1 and $row["Enable"]== 1) {
				$_SESSION["isAdmin"] = FALSE;
				$_SESSION["username"] = $username;
				return TRUE;
			}
			else {
				echo "<script>alert('Approval process is in pending contact admin. Try again later');</script>";	
				header("Refresh:0; url=userlogin.php");
				die();
			}
		}*/

/*$sql = "SELECT * FROM users where username='$username' and password=password('$password');";
echo $sql;
$result = $mysqli->query($sql);

if($result->num_rows > 0){
while($row = $result->fetch_assoc()){
if ($row["Approved"] == 1 and $row["Enable"]== 1) {
$_SESSION["isAdmin"] = FALSE;
$_SESSION["username"] = $username;
//$_SESSION["enable"] = $row["Enable"];
return TRUE;
}
else {
echo "<script>alert('Approval process is in pending contact admin. Try again later');</script>";	
    header("Refresh:0; url=form.php");
    die();
}
return FALSE;
}
	}
}*/



function mysql_checklogin_secureadmin ($username, $password) {
global $mysqli;
//for super user athentication
$prepared_sql = "SELECT * FROM superusers where username= ?"
. " and password=password(?)";
if(!$stmt = $mysqli->prepare($prepared_sql))
echo "Prepared Statement Error";
$stmt->bind_param("ss", $username,$password);
if(!$stmt->execute()) echo "Execute Error";
if(!$stmt->store_result()) echo "Store_result Error";
if ($stmt->num_rows == 1) {
	
	$_SESSION["isAdmin"] = TRUE;	
	return TRUE;
}
//return FALSE;
}
//for user athentication
/*$sql = "SELECT * FROM users where username='$username' and password=password('$password');";
echo $sql;
$result = $mysqli->query($sql);

if($result->num_rows > 0){
while($row = $result->fetch_assoc()){
if ($row["Approved"] == 1 and $row["Enable"]== 1) {
$_SESSION["isAdmin"] = FALSE;
$_SESSION["username"] = $username;
//$_SESSION["enable"] = $row["Enable"];
return TRUE;
}
else {
echo "<script>alert('Approval process is in pending contact admin. Try again later');</script>";	
    header("Refresh:0; url=form.php");
    die();
}
}}
return FALSE;
}
*/

 function mysql_change_users_password($username, $newpassword) {
	global $mysqli;
	$tablename = $_SESSION['isAdmin'] ? 'superusers' : 'users';
	$prepared_sql = "UPDATE $tablename SET password=password(?) WHERE username= ?;";
	
	if(!$stmt = $mysqli->prepare($prepared_sql))
	echo "Prepared Statement Error";
	$stmt->bind_param("ss", $newpassword,$username);//consider as string bind username and password

	if(!$stmt->execute()) 
         {
        echo "Execute Error:UPDATE $tablename SET password=password(?) where username= ?;"; 
         return FALSE;}

	echo "<script>alert('Password updated successfully.');</script>";		
	header("Refresh:0; url=user.php");
	die();	
	return TRUE;
}


function show_posts(){
 global $mysqli;
 $sql = "SELECT * FROM posts where Enable = '1'";
  $result = $mysqli->query($sql);
  if($result->num_rows > 0){
  while($row = $result->fetch_assoc()){
  $postid = $row["id"];

  echo "<h3>post " . $postid . " - " . $row["title"]. "</h3>";
  echo $row["text"] . "<br>";
  echo "<a href='comment.php?postid=$postid'>";
  $sql = "SELECT * FROM comments WHERE postid='$postid';";
  $comments = $mysqli->query($sql);
  if($comments->num_rows > 0){
 echo $comments->num_rows . " comments </a>";
}
 else{
  echo "<br> posts your first comment </a>";
 }
}
} else{ 
echo "<br> no post in this blog yet <br>";
}
}

function display_singlepost($postid) {
global $mysqli;
echo " Post for id = $postid";
   $sql = "SELECT * FROM posts WHERE id=?";
}


function display_comments($postid){
   global $mysqli;
   echo "Comments for Postid= $postid <br>";
   $prepared_sql = "select title, content from comments where postid=?;";
   if(!$stmt = $mysqli->prepare($prepared_sql))
	echo "Prepared Statement Error";
   $stmt->bind_param('i', $postid);
   if(!$stmt->execute()) echo "Execute failed ";
   $title = NULL;
   $content = NULL;
   if(!$stmt->bind_result($title,$content)) echo "Binding failed ";
   $num_rows = 0;
   while($stmt->fetch()){ 
	echo "Comment title:" . htmlentities($title) . "<br>";
	echo htmlentities($content) . "<br>";
	$num_rows++;
   } 
   if($num_rows==0) echo "No comment for this post. Please post your comment";
}

function new_comment($postid,$title,$content,$commenter){
	global $mysqli;
	$prepared_sql = "INSERT into comments (title,content,commenter,postid) VALUES (?,?,?,?);";
	if(!$stmt = $mysqli->prepare($prepared_sql))
	echo "Prepared Statement Error";
	$stmt->bind_param("sssi", htmlspecialchars($title),
				  htmlspecialchars($content),
				  htmlspecialchars($commenter),$postid);
	if(!$stmt->execute()) {echo "Execute Error"; return FALSE;}
return TRUE;
}

/*function new_comment( $postid,$title,$content,$commenter ) {
	global $mysqli;
	$prepared_sql = "insert into comments(title,content,commenter,postid) VALUES (?,?,?,?)";
		
	$stmt = $mysqli->prepare(prepared_sql);

	 if(!$stmt = $mysqli->prepare($prepared_sql))
		echo "Error";
	$stmt->bind_param("sssi",htmlspecialchars($title),$content,$commenter,$postid);

	if(!$stmt->execute())  {
	   echo "Executing Error"; 
	   return FALSE;
        }
        return TRUE;

}*/
function new_post( $owner,$title,$text) {
	global $mysqli;
	$prepared_sql = "insert into posts(title,text,owner) VALUES (?,?,?)";
		
	$stmt = $mysqli->prepare(prepared_sql);

	 if(!$stmt = $mysqli->prepare($prepared_sql))
		echo "Error";
        $stmt->bind_param("sss", htmlspecialchars($title), htmlspecialchars($text), htmlspecialchars($owner));
	if(!$stmt->execute())  {
	   echo "Executing Error"; 
	   return FALSE;
        }
	echo "<script>alert('post created successfully.');</script>";		
    header("Refresh:0; url=user.php");
    die();
	
        return TRUE;

}

function update_post( $title,$text,$id,$enable) {
	global $mysqli;
  $prepared_sql = "update  posts set title =?, text = ?, enable= ? WHERE id = ?";
		
	$stmt = $mysqli->prepare(prepared_sql);

	 if(!$stmt = $mysqli->prepare($prepared_sql))
		echo "Error";
        $stmt->bind_param("ssii", htmlspecialchars($title), htmlspecialchars($text),$enable,$id);
	if(!$stmt->execute())  {
	   echo "Executing Error"; 
	   return FALSE;
        }
	echo "<script>alert('post updated successfully.');</script>";		
    header("Refresh:0; url=user.php");
    die();
        return TRUE;

}

function update_user( $id,$approve,$enable) {
	global $mysqli;
  $prepared_sql = "update  users set Approved = ?, Enable = ? WHERE username = ?";
	$stmt = $mysqli->prepare(prepared_sql);

	 if(!$stmt = $mysqli->prepare($prepared_sql))
		echo "Error";
        $stmt->bind_param("iis",htmlspecialchars($approve),htmlspecialchars($enable),$id);
	if(!$stmt->execute())  {
	   echo "Executing Error"; 
	   return FALSE;
        }
	echo "<script>alert('user updated successfully.');</script>";		
    header("Refresh:0; url=admin.php");
    die();
        return TRUE;

}



/*function update_post($title,$text,$id) {
echo "line 1";
	global $mysqli;
	//$prepared_sql = "update from posts(title,text,id) VALUES ('$title','$content',$id)";
	
  $prepared_sql = "update  posts set title =?, text = ? WHERE id = ?";

	$stmt = $mysqli->prepare(prepared_sql);

	 if(!$stmt = $mysqli->prepare($prepared_sql))
		echo "Error";
   $stmt->bind_param("ssi",$title,$text,$id);
         

	if(!$stmt->execute())  {
	   echo "Executing Error"; 
	   return FALSE;
        }
        return TRUE;
}

*/
function delete_post($postid) {
	global $mysqli;
	$prepared_sql = "delete from posts WHERE id = ?;";

		
	$stmt = $mysqli->prepare(prepared_sql);

	 if(!$stmt = $mysqli->prepare($prepared_sql))
		echo "Error";
    $stmt->bind_param("i",$postid);

	if(!$stmt->execute())  {
	   echo "Executing Error"; 
	   return FALSE;
        }
        return TRUE;
}

function add_user($username, $password, $email, $phone, $name) {
	global $mysqli;
	$prepared_sql = "insert into users(username,password,email,phone,name) VALUES (?,password(?),?,?,?);";
	$stmt = $mysqli->prepare(prepared_sql);
	if(!$stmt = $mysqli->prepare($prepared_sql))   
		echo "Prepare failed";
	$stmt->bind_param("sssss", htmlspecialchars($username), htmlspecialchars($password), htmlspecialchars($email), htmlspecialchars($phone), htmlspecialchars($name));
	if(!$stmt->execute()) { 
		echo "Execute failed ";
		return FALSE;
	}
	echo "<script>alert('User Registration successfully completed.');</script>";		
    	header("Refresh:0; url=index.php");
    	die();

	return TRUE;
}

function update_info( $email,$phone,$name, $username) {
	global $mysqli;
  $prepared_sql = "update  users set email = ? , phone = ?, name =?  WHERE username = ?;";
	$stmt = $mysqli->prepare(prepared_sql);

	 if(!$stmt = $mysqli->prepare($prepared_sql))
		echo "Error";
        $stmt->bind_param("siss", htmlspecialchars($email), htmlspecialchars($phone),htmlspecialchars($name),$username);
	if(!$stmt->execute())  {
	   echo "Executing Error"; 
	   return FALSE;
        }
echo "<script>alert('post updated successfully.');</script>";		
    header("Refresh:0; url=user.php");
    die();
	
        return TRUE;

}



?>
