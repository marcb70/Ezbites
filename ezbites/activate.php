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
            <!--Log in and register are ends here-->
            </div>
	</div>
    <!--Head ends here-->
        
        <div id="content">
        <!--Search are begins here-->
       	  
        	<!--Search are ends here-->
            <!--Introduction text begins here-->
            
            <!--Introduction text ends here-->
            <!--Search results begins here-->
         
       	  <div id="registerform">
	       
	       <?php
	include 'dbconfig.php';

	$id =$_GET['id'];
	$code = $_GET['code'];

	if($id&&$code)
	{
		//check
		$check = mysql_query("SELECT * FROM users WHERE userID ='$id' AND random='$code'");
		$checknum = mysql_num_rows($check);
	
		//if exist
	
		if($checknum==1)
		{
			//run query to activate account
			$acti = mysql_query("UPDATE users SET activated='1' WHERE userID ='$id'");	
			echo '<h2>Your account has now been activated!</h2> You may now log in. <br /> Redirecting to the homepage...<meta http-equiv="refresh" content="5; url=index.php" />';
			die();
			
		}
		else
		{
			echo '<h2>Invalid id or activation code</h2> <br />Redirecting to the homepage... <meta http-equiv="refresh" content="3; url=index.php" />';
			die();
		}
	
	}
	else
		echo '<h2>Data missing!</h2> Redirecting to the homepage... <meta http-equiv="refresh" content="3; url=index.php" />';
			die();


			?>
	       
	       
	       ?>
            <h2>Registration</h2><br />

<form action="" method="post">
     <p><b>Full Name:</b><br /> <input type="text" name="fullname" size="20" maxlength="25" value="<?php if (isset($fullname)) echo $fullname; ?>" /></p>
	
	<p><b>Username:</b><br /> <input type="text" name="username" size="20" maxlength="25" value="<?php if (isset($username)) echo $username; ?>" /></p>

	<p><b>Email:</b><br /> <input type="text" name="email" size="30" maxlength="30" value="<?php if (isset($email)) echo $email; ?>" /></p>
		
	<p><b>Password:</b><br /> <input type="password" name="password1" size="20" maxlength="25" /></p><p></p>
	<p><b>Confirm password:</b><br /> <input type="password" name="password2" size="20" maxlength="25" /> <br /></p><br />

	<p><b>Phone number</b><i>(optional)</i><br /> <input type="text" size="20" maxlength="10" name="phone" value="<?php if (isset($phone)) echo $phone; ?>"/>
	
	<p><b>Carrier</b><i>(optional)</i><br /> <select name="carrier">
		<option value=""></option>
		<option value="@txt.att.net">AT&T</option>
		<option value="@mymetropcs.com">Metro PCS</option> 
		<option value="@messaging.sprintpcs.com">Sprint</option> 
		<option value="@tomomail.net">T-mobile</option>
		<option value="@vtext.com">Verizon</option>
		<option value="@vmobl.com">Virgin</option>
	</select>
	

	

	<div align="center"><input type="submit" name="submit" id ="updatebtn" value="Register" /></div>
	

</form></div>
            <!--Search results ends here-->
        
		</div>
	</div>
	<!--Tile bg ends here-->
    
    <div id="bottom">
    
  	</div>
    

</div>

</body>

</html>

