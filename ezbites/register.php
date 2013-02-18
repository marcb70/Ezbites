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
        
        <div id="contentSearch">
        <!--Search are begins here-->
       	  
        	<!--Search are ends here-->
            <!--Introduction text begins here-->
            
            <!--Introduction text ends here-->
            <!--Search results begins here-->
         
       	  <div id="registerform">
	       <?php
	       $submit = $_POST['submit'];
	       $fullname = strip_tags($_POST['fullname']);
	       $username = strtolower(strip_tags($_POST['username']));
	       $password = strip_tags($_POST['password1']);
	       $repeatpassword = strip_tags($_POST['password2']);
	       $phone = $_POST['phone'];
	       $carrier = $_POST['carrier'];
	       $email = $_POST['email'];
	       $date = date("y-m-d");
	       
	       if ($submit)
	       {
			 //connect to db
			 include 'dbconfig.php';
		    
			 $namecheck = mysql_query("SELECT UserName FROM users WHERE UserName ='$username' ");
			 $count = mysql_num_rows($namecheck);
			 
			 if($count !=0)
			 {
			      echo '<p class = "warning"><b>Username already taken. Redirecting in 3 secs...</b></p>';
			      echo '<meta http-equiv="refresh" content="3" />';
			      die();
			      
			 }
		     
		    
		    //check for existance
		    if($fullname&&$username&&$email&&$password&&$repeatpassword)
		    {
			 
			 
			if ($password==$repeatpassword)
			{
			 //check char length
			      if(strlen($username)>25 ||strlen($fullname)>25)
			      {
				   echo '<p class="warning"><b>Length of username/fullname must be less than 25 characters.</b></p>';
			      }
			      else
			      {
				//check password length
				   if(strlen($password)>25||strlen($password)<6)
				   {
					echo '<p class="warning"><b>Passwords must use only letters, numbers and underscore. Must be between 4 and 20 characters long.</b></p>';
				   }
				   else
				   {
					///register user
					//encrypt password
					$password = md5($password);
					$repeatpassword = md5($repeatpassword);
					
					//generate randon activation number
					$random = rand(23456789,98765432);
					
					$regquery = "INSERT INTO users VALUES ('','$fullname','$username','$password','$email','$phone','$carrier','$date','$random','0')";
					mysql_query($regquery);
					
					$lastid = mysql_insert_id();
					
					//send activation email
					$to = $email;
					$subject = "Avtivate your account!";
					$headers =  "From: admin@ezbiyes.com";
					
					$body = "
					
					Hello $fullname,
					You need to activate your account with the link below:
http://itcdland.csumb.edu/~cst451_yosal/ezbites/activate.php?id=$lastid&code=$random
					
					Thanks,
					ADMIN";
					mail($to,$subject,$body,$headers);
					
					echo "You have been registered! Check your email to activate your account<br />";
					die();
					
					
				   }
			      }
			 
			}
			else
			echo '<p class="warning"><b>Your passwords do not match.</b></p>';
		    }
		    else
			 echo '<p class="warning"><b>Please fill in all fields.</b></p>';
	       }
	       
	       
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
		<option value="@tmomail.net">T-mobile</option>
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

