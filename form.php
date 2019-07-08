
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





      <h1>Admin Login</h1>
</div>
<?php
 
  echo "Current time: " . date("Y-m-d h:i:sa")
?>
          <form action="admin.php" method="POST" class="form login">
               Username <input type="text" class="text_field" name="username" required pattern="\w+"
               title="Please enter a valid username"
               onchange="this.setCustomValidity(this.validity.patternMismatch ?this.title :'');"> <br>

              
                Password: <input type="password" class="text_field" name="password" /> <br>
                <button class="button" type="submit" name="login_btn">Login</button>
<p>
			Not yet a member? <a href="newuser.php">Sign up</a>
</p>
                  

                  
                </button>
          </form>
</body>
  </html>
