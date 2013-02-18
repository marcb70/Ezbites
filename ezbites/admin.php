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
       	  
       	  <div id="allRecipes">
          <?php
				include 'dbconfig.php';
				
				$query = "SELECT * FROM Recipes b JOIN cookingmethod a ON b.cookingmethodID = a.methodID JOIN dish c ON b.dishID = c.dishID ";
				
				$result = mysql_query($query);
				
				$resultrows = mysql_num_rows($result);
				
				echo '<div class="adminpageBox"><b>Total Recipes in Database: '.$resultrows.'</b> <a href="update.php" id ="button"><span>Add Recipe</span></a>'.((isset($_GET['sort']))? '<div class="cookmethod"><a id ="button" href="admin.php?page='.$_GET['page'].'"><span>Unsort</span></a></div>' : '').'</div>';
 				
				//Calculating per page
				$perpage = 5;
				$pages = ceil($resultrows / $perpage);
				$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
				$start = ($page -1) * $perpage; 
	
				$sort = $_GET['sort'];
	
				if ($sort != NULL)
					$query .= "ORDER by $sort, title";
				else {
						$query .= "ORDER by title";
					}	
		
				$query .= " LIMIT $start, $perpage  ";

				$result = mysql_query($query);
	

				if ($resultrows==0)
					echo "Sorry, we did not find any recipes with these ingredients: '$ingredient'";
				else
					{ 
						$LineNum=0;
		
						while ($line=mysql_fetch_assoc($result)) {
						$rating = ($line['rating']) *20; 
		echo '<div' .(($LineNum++ & 1) ? ' class="adminresultBox"' : ' class="adminresultBoxalt"'). '><div class="adminimg"><img src="showfile.php?id='.$line['recipeID'] . '" width="100" height="100"><div id="adminbuttons"> <a id="button" href="delete.php?id='.$line['recipeID'].'" onclick="return confirm(\'Really delete?\');"><span>Delete</span></a> <a id="button" href="update.php?id='.$line['recipeID'].'"><span>Update</span></div></a></div><div class="admintitle"><a id="recipeTitle" href="recipe.php?ingSearchfield='.$ingredient.'&recipeid='.$line['recipeID'].'"><h3><span>' .$line['title']. '</span></h3></a><ul class="star-rating">
		<li class="current-rating" style="width:'.$rating.'%;">Currently 3/5 Stars.</li>
		<li title="1 star out of 5" class="one-star"></li>
		<li title="2 stars out of 5" class="two-stars"></li>
		<li title="3 stars out of 5" class="three-stars"></li>
		<li title="4 stars out of 5" class="four-stars"></li>
		<li title="5 stars out of 5" class="five-stars"></li>
	</ul></div><div class="admininstructions"><p>'.$line['instructions']. '</p></div><div class="adminingredients"><p><b>Ingredients:</b>' . $line['ingredients'] . '</p></div><div class="cost"><p> <a id ="sort" href="admin.php?page='.$page.'&sort=cost"><span>Cost:<span></a>$'.$line['cost'].'</p></div><div class="preptime"><p><a id ="sort" href="admin.php?page='.$page.'&sort=preptime"><span>Prep Time:</span></a>'.$line['preptime'].' </p> </div><div class="cookmethod"><p><a id ="sort" href="admin.php?page='.$page.'&sort=method"><span>Method:</span></a>'.$line['method'].'</p></div><div class="cookmethod"><p><a id ="sort" href="admin.php?page='.$page.'&sort=dish"><span>Dish:</span></a>'.$line['dish'].'</p></div></div>';
		
				}
				
				
	} 
	
	
	
	if ($pages >= 1 && $page <= $pages) {
		echo '<div class="adminpageBox"> <b>Pages:</b> ';
	for ($x=1; $x<=$pages; $x++) {
		echo ($x == $page) ? '<b><a href="admin.php?page='.$x.'">'.$x.'</a></b> ' : '<a href="admin.php?page='.$x.((isset($_GET['sort'])) ? ' &sort='.$sort.'' : '').'">'.$x.'</a> ';
	}
	echo '</div>';
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

