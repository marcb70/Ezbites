<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

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
        
        <div id="content">
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
             <div id="mypro">
            
            <?php
			
			include 'dbconfig.php';
					$memberquery = "SELECT * FROM profile b JOIN users a ON b.username= a.UserName WHERE userID = '$userid'";
					$result = mysql_query($memberquery);
					$line = mysql_fetch_assoc($result);
					$gen = $line['gender'];
					$loc = $line['location']; 
					$bio = $line['bio'];
					
					echo '<div id="myprobox"><h4>My Profile:</h4><img src="showfile.php?pic='.$userid.' width="140" height="140"><br />
					<h4>'.$user.'</h4><b>Location:</b> '.$loc.'<br />
					<b>Bio:</b> '.$bio.'<br />';
					
			echo '<a href="profile.php?id='.$userid.'" id="button"><span>Edit Profile</span></a><br /></div><br />
			<a href="update.php" id ="button"><span>Add Recipe</span></a>';
				
			
			?>
            </div>
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



include 'dbconfig.php';

$favequery = "SELECT * 
FROM Recipes b
JOIN cookingmethod a ON b.cookingmethodID = a.methodID
JOIN dish c ON b.dishID = c.dishID
JOIN myfavorite d ON b.recipeID = d.recipeID
WHERE d.userID =  '$userid' ";

	$sort = $_GET['sort'];
	
	$filter = $_GET['filter'];
					if ($filter != NULL)
		
			$favequery .= "AND dish = '$filter' ";
			
	
	
	if ($sort != NULL)
		$favequery .= "ORDER by $sort, title";
		else {
		$favequery .= "ORDER by title";
		}
		
		$result = mysql_query($favequery);
		$resultrows = mysql_num_rows($result);
		
		$perpage = 4;
		$pages = ceil($resultrows / $perpage);
		$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
		$start = ($page -1) * $perpage; 
	
		$favequery .= " LIMIT $start, $perpage  ";
	

		$result = mysql_query($favequery);
		$resultrows = mysql_num_rows($result);
	
	
	

	if ($resultrows==0)
			if ($filter != NULL){
					echo "No results found with this filter: $filter";
					}
			else
						echo "You do not have not added any recipes yet.";
				
	else
		{ 
		
		$LineNum=0;
		echo '<div class="pageBox">'.((isset($_GET['sort']))? '<a id ="button" href="search.php?ingSearchfield='.$ingredient.'&page='.$page.'"><span>Unsort</span></a>' : '');
		echo '<h4>My Favorites</h4></div>';
		while ($line=mysql_fetch_assoc($result)) {
			$rating = ($line['rating']) *20; 
		echo '<div' .(($LineNum++ & 1) ? ' class="resultBox"' : ' class="resultBoxalt"'). '><div class="img"><img src="showfile.php?id='.$line['recipeID'] . '" width="100" height="100"><p><b>Dish: </b>'.$line['dish'].'</p></div><div class="instructions"><a id="recipeTitle" href="recipe.php?ingSearchfield='.$ingredient.'&recipeid='.$line['recipeID'].'"><h3><span>' .$line['title']. '</span></h3></a><ul class="star-rating">
		<li class="current-rating" style="width:'.$rating.'%;">Currently 3/5 Stars.</li>
		<li title="1 star out of 5" class="one-star"></li>
		<li title="2 stars out of 5" class="two-stars"></li>
		<li title="3 stars out of 5" class="three-stars"></li>
		<li title="4 stars out of 5" class="four-stars"></li>
		<li title="5 stars out of 5" class="five-stars"></li>
	</ul><p>'.substr($line['instructions'], 0, 80) . '...</p></div><div class="ingredients"> <p><b>Ingredients:</b>' . substr($line['ingredients'], 0, 80) . '</p></div><div class="cost"><p> <a id ="sort" href="search.php?ingSearchfield='.$ingredient.'&page='.$page.'&sort=cost"><span>Cost:<span></a> $'.$line['cost'].'</p></div><div class="preptime"><p><a id ="sort" href="search.php?ingSearchfield='.$ingredient.'&page='.$page.'&sort=preptime"> <span>Prep Time:</span></a>'.$line['preptime'].' </p> </div><div class="cookmethod"><p><a id ="sort" href="search.php?ingSearchfield='.$ingredient.'&page='.$page.'&sort=method"><span>Method:</span></a>'.$line['method'].'</p></div></div>';
		
				}
				
				
	
	
	
	}
	if ($pages >= 1 && $page <= $pages) {
		echo '<div class="pageBox"> <b>Pages:</b> ';
	for ($x=1; $x<=$pages; $x++) {
		echo ($x == $page) ? '<b><a href="member.php?page='.$x.'">'.$x.'</a></b> ' : '<a href="member.php?page='.$x.((isset($_GET['sort'])) ? ' &sort='.$sort.'' : '').((isset($_GET['filter'])) ? ' &filter='.$filter.'' : '').'">'.$x.'</a> ';
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

