<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Ez-Bites - Easy to make recipes</title>

<link href="css/styles.css" rel="stylesheet" type="text/css" />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>

<script src="js/login.js"></script>
<script src="js/search.js"></script>


<script>

     $(document).ready(function(){

       $(".results").hide();

       });

   </script>




</head>



<body>
<?php session_start(); session_destroy(); ?>
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
                <a href="#login" id="loginButton" onclick="submitform();"><span>Login</span><em></em></a>
                <a href="register.php" id="registerButton"><span>Register</span><em></em></a>
                <div style="clear:both"></div>
          <div id="loginBox">    
          	           
                    <form id="loginForm" method ="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
                        <fieldset id="body">
                       
                            <fieldset>
                                <label for="email">Username</label>
                                <input type="text" name="username" id="username" />
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
            
                    
        </div>
            <!--Log in and register are ends here-->
            </div>
	</div>
    <!--Head ends here-->
        
        <div id="content">
        <!--Search are begins here-->
       	  <div id="searchArea">
        	<div id="ingSearch">
        <form action="search.php" method="get" id="ingForm">
                                <label>Enter Ingredients!</label>
                                <input type="text"  name="ingSearchfield" id="ingSearchfield" />
                        
          
          <!--Ingredient Search begins here-->
             
			 
			<button type="submit" id="searchButton">
				<span>Search</span></button>
                
                 <!--Javascrip to detect if user presses the "Enter" key in the form-->
                 <script type="text/javascript">
				 $('#ingSearchfield').keypress(function(e) {
					 if ((e.keyCode || e.which) == 13) {
						  // Enter key pressed
						  $('#searchButton').click();{
							  e.preventDefault();
							  }
							}
					});
                   </script>

			</form>
            </div>
        <!--Ingredient Search ends here-->
       	  </div>
            <!--Search are ends here-->
            <!--Introduction text begins here-->
            <div id="intro">
            <?php
		  			
					include "login.php";
					
					
		  
		  	?>	  
            <h2>You Have now been logged out</h2>
            <p></p> 
            </div>
            <!--Introduction text ends here-->
            <!--Search results begins here-->
            <div id="searchResults" class="results">
            
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

