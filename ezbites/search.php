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
<?php session_start();
include "login.php"; ?>
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
            <?php if(isset($_SESSION['username'])){
					
					echo '<a href ="'.(($_SESSION['username']=="admin") ? 'admin.php"' : 'member.php"').'>'.$_SESSION['username'].'</a> | <a href="logout.php">Log out</a>';
                    }
                   ?>
            </div>
            <!--Log in and register are ends here-->
            </div>
	</div>
    <!--Head ends here-->
        
        <div id="contentSearch">
        <!--Search are begins here-->
       	  <div id="searchArea">
        	<div id="ingSearch">
        <form action="search.php" method="get" id="ingForm">
                                <label>Enter Ingredients!</label>
                                <input type="text"  name="ingSearchfield" id="ingSearchfield"  value="<?php echo $_GET['ingSearchfield']?>" />
                        
          
          <!--Ingredient Search begins here-->
             
			<button type="submit" id="searchButton">
				<span>Search</span></button>
                
                </form>

			
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
        
   		    </div>
        	<!--Search are ends here-->
            <!--Introduction text begins here-->
            
            <!--Introduction text ends here-->
            <!--Search results begins here-->
            <div id="dishfilter">
            <h4>Filter by Dish:</h4>
            <?php
				require_once "dbconfig.php";
				$filter = mysql_query("SELECT * FROM dish ");
				 while ($row=mysql_fetch_assoc($filter)) {
					 echo '<a href="search.php?ingSearchfield='.$_GET['ingSearchfield'].((isset($_GET['page'])) ? ' &page='.$_GET['page'].'' : '').((isset($_GET['sort'])) ? ' &sort='.$_GET['sort'].'' : '').'&filter='.$row['dish'].'" id ="button"><span>'.$row['dish'].'</span></a><br />';
				 }
			
			?>
            </div>
          </div>
       	  <div id="searchResults" class="results">
            <?php
				include "data.php";
				
				
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

