<?php
session_start();
if (isset($_SESSION['username']))
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

       $(".results").slideDown();

       });

   </script>




</head>



<body>

<div id="container">


	<!--Tile bg starts here-->
  <div id="tile">
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
					echo ' <a href ="'.(($_SESSION['username']=="admin") ? 'admin.php"' : 'member.php"').'>'.$_SESSION['username'].'</a> | <a href="logout.php">Log out</a>';
                    }
                   ?>
            </div>
            <!--Log in and register are ends here-->
            </div>
	</div>
    <!--Head ends here-->
        
        <div id="contentSearch">
        <!--Search are begins here-->
       	  
        	<!--Search are ends here-->
            <!--Introduction text begins here-->
            
            <!--Introduction text ends here-->
            <!--Search results begins here-->
         
       	  <div id="registerform">
	       <?php
		   $user = $_SESSION['username'];
	       $submit = $_POST['submit'];
	       $gender = strip_tags($_POST['gender']);
	       $location = strtolower(strip_tags($_POST['location']));
	       $bio = strip_tags($_POST['bio']);
	       $pic = strip_tags($_POST['pic']);
	       
	       if ($submit)
	       {
			 //connect to db
			 include 'dbconfig.php';
			 
					$proquery = "INSERT INTO profile VALUES ('','" .mysql_real_escape_string(file_get_contents($_FILES['pic']['tmp_name']))."','$user','$gender','$bio','$location')";
					mysql_query($proquery);
					
					echo "Profile Updated!<br />";
					
		   }
		   
		   $updatepro = $_POST['update'];
		   if($updatepro)
		   {
			   include 'dbconfig.php';
			 
					$upproquery = "UPDATE profile SET " .
	   ((is_uploaded_file($_FILES['pic']['tmp_name'])) ? 'pic=\''.mysql_real_escape_string(file_get_contents($_FILES['pic']['tmp_name'])).'' : '') ."', gender ='$gender',bio='$bio', location='$location' WHERE username ='$user'";
					mysql_query($upproquery);
				
					
					echo "Profile Updated!<br />";
		   }
	       if(isset($_GET['id'])){
					$id = $_GET['id'];
					
					//connect to db
					include 'dbconfig.php';
					$pquery = "SELECT * FROM profile b JOIN users a ON b.username= a.UserName WHERE userID = '$id'";
					$result = mysql_query($pquery);
					$line = mysql_fetch_assoc($result);
				}
	       
	      echo '<form action="" id="profile" method="post" enctype="multipart/form-data">
					<b>Profile Picture</b> <br />
					<img src="showfile.php?pic='.$id.'" width="100" height="100"><br /><br />
					<input type = "file" name="pic" /><br /><br />
					<b>Gender</b><br />
					<select name="gender"><option selected value="'.$line['gender'].'">' .$line['gender'] . '</option>
        				<option value="M">Male</option>
                        <option value="F">Female</option>
     					<option value="O">Other</option>
     					</select><br /><br />
						<b>Location</b> <br /><textarea name="location" cols="25" rows="1">'.$line['location'].'</textarea><br /><br />
						<b>Bio</b> <br /><textarea name="bio" cols="25" rows="6">'.$line['bio'].'</textarea><br /><br />';
					if(!empty($line['gender']))
					{ 
					echo '<input type="submit" name = "update" id="updatebtn" value="Update">
					</form>';}
					else{
						echo '<input type="submit" name = "submit" id="updatebtn" value="Save">
					</form>';
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

