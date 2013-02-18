<?php
session_start();
if ($_SESSION['username']=='admin')
{
	$user = $_SESSION['username'];
	include "dbconfig.php";
	$userselect = mysql_query("SELECT userID FROM users WHERE UserName ='$user'");
	
	$userline = mysql_fetch_assoc($userselect);
	$userid = $userline['userID'];
	
}
else
{
	header("location: index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Ez-Bites - Easy to make recipes</title>

<link href="css/styles.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>

<script type="text/javascript" src="js/login.js"></script>
<script type="text/javascript" src="js/search.js"></script>


<script>

     $(document).ready(function(){

       $("#warning").hide();

       });

   </script>




</head>



<body>
<?php session_start(); ?>
<div id="container">


	<!--Tile bg starts here-->
  <div id="admintile">
    	<div id="top">
        </div>
        
        <!--Head are with logo and login stuff starts here-->
	<div id="head">
        <div id="logo"> <a href="index.php"><img src="images/logo.png" alt="logo" width="280" height="114" border="0" /></a>
          </div> 
          
          <!--Log in and register are starts here-->
      <div id="righthead">
      <div id="loginContainer">
                <a href="#" id="loginButton"><span>Login</span><em></em></a>
                <a href="register.php" id="registerButton"><span>Register</span><em></em></a>
                <div style="clear:both"></div>
          <div id="loginBox">                
                    <form id="loginForm">
                        <fieldset id="body">
                            <fieldset>
                                <label for="email">Email Address</label>
                                <input type="text" name="email" id="email" />
                            </fieldset>
                            <fieldset>
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" />
                            </fieldset>
                            <input type="submit" id="login" value="Sign in" />
                            <label for="checkbox"><input type="checkbox" id="checkbox" />Remember me</label>
                        </fieldset>
                        <span><a href="#">Forgot your password?</a></span>
                    </form>
                </div>
            </div>
            <div id="userLinks">
            <?php if(isset($_SESSION['username'])){
					
					echo '<a href ="'.(($_SESSION['username']=="admin") ? 'admin.php"' : 'member.php"').'>'.$_SESSION['username'].'</a> | <a href="logout.php">Log out</a>';
                    }
                   ?>
            </div>
            <!--Log in and register are ends here-->
            </div>
	</div>
    <!--Head ends here-->
        
        <div id="content">
        <!--Search are begins here-->
       	  
       	  <div id="allRecipes" class="warning">
          
          <?php		  
				if($_SESSION['username']=='admin')
				{
				if(isset($_GET['id'])){
					$id = $_GET['id'];
					
					//connect to db
					include 'dbconfig.php';
					$dquery = "DELETE FROM Recipes WHERE recipeID = '$id'";
					mysql_query($dquery);
					echo '<b> Recipe has been deleted</b><br /><a href="admin.php">Click Here</a> to return to the admin page';
					
					
				}
				else {
				echo "That record does not exist!";	
				}
				}
?>
            
            </div>
            <!--Search results ends here-->
        
		</div>
	</div>
	<!--Tile bg ends here-->
    
    <div id="bottom">
    
  	</div>
    

</div>

</body>

</html>

