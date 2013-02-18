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
?>
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

       $(".results").slideDown();

       });

   </script>




</head>



<body>
<?php
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
       	  <div id="recipesearchArea">
        	<div id="ingSearch">
        <form action="search.php" method="get" id="ingForm">
                                <label>Enter Ingredients!</label>
                                <input type="text"  name="ingSearchfield" id="ingSearchfield"  value="<?php $searchterm = $_GET['ingSearchfield']; echo $searchterm; ?>" />
                        
          
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
          </div>
       	  
            <!--Search results ends here-->
           
        <div id="book">
        	<div id="leftbook">
          <?php
		  
		//get recipeid
		$recipe = $_GET['recipeid'];
		include 'dbconfig.php';
		$recipeQuery= mysql_query("SELECT * FROM Recipes b JOIN cookingmethod a ON b.cookingmethodID = a.methodID JOIN dish c ON b.dishID = c.dishID WHERE recipeID=$recipe");
		
		$recipeLine = mysql_fetch_assoc($recipeQuery);
		$rating = ($recipeLine['rating']) * 20;
		
		//Display title and rating
		echo '<div id ="recipeTitlemain"><h2>'.$recipeLine['title'].'</h2></div>';
		
		if($user)
		{
		echo '<div id="rating" class="clear"><ul class="star-rating">
		<li class="current-rating" style="width:'.$rating.'%;">Currently 3/5 Stars.</li>
		<li><a href="recipe.php?ingSearchfield='.$_GET['ingSearchfield'].'&recipeid='.$recipe.'&rate=1" title="1 star out of 5" class="one-star">1</a></li>
		<li><a href="recipe.php?ingSearchfield='.$_GET['ingSearchfield'].'&recipeid='.$recipe.'&rate=2" title="2 stars out of 5" class="two-stars">2</a></li>
		<li><a href="recipe.php?ingSearchfield='.$_GET['ingSearchfield'].'&recipeid='.$recipe.'&rate=3" title="3 stars out of 5" class="three-stars">3</a></li>
		<li><a href="recipe.php?ingSearchfield='.$_GET['ingSearchfield'].'&recipeid='.$recipe.'&rate=4" title="4 stars out of 5" class="four-stars">4</a></li>
		<li><a href="recipe.php?ingSearchfield='.$_GET['ingSearchfield'].'&recipeid='.$recipe.'&rate=5" title="5 stars out of 5" class="five-stars">5</a></li>
	</ul></div><div id="ratingfeedback"><p class="small">('; printf("%0.1f",$recipeLine['rating']); echo')';
	
		
		//if recipe is rated...
		if(isset($_GET['rate']))
		{
			$getrate = $_GET['rate'];
			if($getrate <= 5 && $getrate >0)
			{
				
			include_once "dbconfig.php";
			
			//select old rating
			$oldratingquery = mysql_query("SELECT rating FROM Recipes WHERE recipeID ='$recipe'");
			
			$oldratingquery = mysql_fetch_assoc($oldratingquery);
			
			$oldrating = $oldratingquery['rating']; 
			
			//if it has not been rated...
			if($oldrating==0)
			
			$newrating = $oldrating + $getrate;
			
			else
			
			//add old and new rating then divide by 2
			$newrating = ($getrate + $oldrating)/2;
			
			
			//update rating
			$updaterating = mysql_query("UPDATE Recipes SET rating='$newrating' WHERE recipeID='$recipe'");
			
			echo " Thanks for rating!</p>";
			}
			
		}
		else
		{
			echo " Rate!";	
		}
	}
	else{
	       echo '<div id="rating" class="clear"><ul class="star-rating">
		<li class="current-rating" style="width:'.$rating.'%;">Currently 3/5 Stars.</li>
		<li><a href="#" title="1 star out of 5" class="one-star">1</a></li>
		<li><a href="#" title="2 stars out of 5" class="two-stars">2</a></li>
		<li><a href="#" title="3 stars out of 5" class="three-stars">3</a></li>
		<li><a href="#" title="4 stars out of 5" class="four-stars">4</a></li>
		<li><a href="#" title="5 stars out of 5" class="five-stars">5</a></li>
		</ul></div><div id="ratingfeedback"><p class="small">('; printf("%0.1f",$recipeLine['rating']); echo')';
		echo " Log in to rate!";
	}
	echo'</div><div class="recipeBox clear"><div id="recipeinfo"><p class="small"><b>Cost:</b> $'.$recipeLine['cost'].'</p><p class="small"><b>Prep Time:</b> '.$recipeLine['preptime'].'</p><p class="small"><b>Method:</b> '.$recipeLine['method'].'</p><p class="small"><b>Dish:</b> '.$recipeLine['dish'].'</p>';
	
	//Add to favorites script
	$fave = $_GET['add'];
	
	if($fave)
	{
		include_once "dbconfig.php";
		//check to see if they have alredy added that recipe
		$checkfave = mysql_query("SELECT * FROM myfavorite WHERE userid ='$userid' AND recipeID='$fave'");
		$checkrows = mysql_num_rows($checkfave);
		
		if($checkrows >1)
		{
			echo '<p class="warning small"><b>Recipe already added!</b></p>';
			echo '<script type="text/javascript"> alert("Recipe already added!");</script>';
		}
		else
		{
		$addfave = "INSERT INTO myfavorite VALUES ('','$recipe','$userid')";
	
		mysql_query($addfave);
		
		echo '<p class="warning small"><b>Recipe added!</b></p>';
		echo '<script type="text/javascript"> alert("Recipe Added!");</script>';
		}
	}
	if($user)
	{
	echo '<a id="button" href="recipe.php?ingSearchfield='.$searchterm.'&recipeid='.$recipe.'&add='.$recipe.'"><span>Add to Favorites</span></a>';
	  
        //send text form
	echo '<form action="" method="post">
	       <input type="submit" id ="button" value="Send to Phone" class="button" />
	       <input type="hidden" name="sendtext" value="1" />
	       </form>';

	       if(isset($_POST['sendtext']))
	       {
		    //select users phnoe and carrier
		    include "dbconfig.php";
		    $userselect = mysql_query("SELECT * FROM users WHERE UserName ='$user'");
     
		    $userline = mysql_fetch_assoc($userselect);

		    $userpn = $userline['phonenumber'];
		    $usercarrier = $userline['carrier'];
	  
		    $to = $userline['phonenumber'].$userline['carrier'];
		    $subject = "Ingredients for: " . $recipeLine['title'];
		    $txt = "Thank you for using EZBites here are the ingredients:\r\n". $recipeLine['ingredients'];
		    $headers = "From: recipies@ezbites";

	       mail($to, $subject, $txt, $headers);

	       echo '<p class="small"><b>Recipe has been sent to your phone!</b></p>';
	       }



	  


	}
		
	
	echo '</div><div id ="recipeimage">
          <img src="showfile.php?id='.$recipeLine['recipeID'].'"  width="140" height="140"></div></div>';
		echo '<div class="clear"><b>Ingredients</b><hr style="border: 1px solid #000;" /><p class="small">'.$recipeLine['ingredients'].'</p></div>';
		
		?>
        	</div>
            <div id="rightbook">
            <?php 
		    echo '<br /><b>Instructions</b><hr style="border: 1px solid #000;" /><p class="small">'.$recipeLine['instructions'].'</p>';
			
		    
		    echo '<br /><br /> <form action="" method="post">
		    <textarea name="comment" cols="25" rows="6">Add a comment....</textarea>
		    <input type="submit"  id="button" value="Comment">
			 <input type="hidden" name="addcomment" value="1" />
		    </form>';
		    
		    if(isset($_POST['addcomment']))
		       {
			 $date = date("y-m-d");
			 $time = date("h:i:s A");
			 $comment = $_POST['comment'];
			 
		    //add comment to db
		    include "dbconfig.php";
		    $comment = mysql_query("INSERT INTO comments VALUES('','$userid','$recipe','$comment','$date','$time')");
			 
			 
		       }
		    ?>
              
            </div>
        
        </div>
        <!--<div id ="rightbook">
        
        </div>-->
       
		</div>
	 <div id="comments">
	<h4>Comments:</h4>
	
	       <?php
		    include "dbconfig.php";
		    
		    $comments = mysql_query("SELECT * FROM comments b JOIN users c ON b.userid = c.userID WHERE b.recipeid = '$recipe'");
		    $commentsrow = mysql_num_rows($comments);
			
		    
		    if($commentsrow > 0)
		    {
			 $LineNum=0;
			 while ($commentsline = mysql_fetch_assoc($comments)){
				 $datetime = strtotime($commentsline['dateC']);
				 
			
			 echo '<div' .(($LineNum++ & 1) ? ' id="comtainer" class="clear"' : ' id="comtaineralt"'). '>
			 <div class="commentbox"><img src="showfile.php?pic='.$commentsline['userid'].'" height="40" width="40"><br />
			 <p class="small"><a href="#" id="smallbutton">'.$commentsline['UserName'].'</a></p>
			 </div>
			 <div class="comment"><p class="small">'.$commentsline['comment'].'</p>
			 </div><div class="comment clear"><p class="small">'.date("l, jS F, Y", $datetime).' at '.$commentsline['time'].'';
			 
			 if($userid==$commentsline['userid'])
			 {
			 
			 echo ' <a href="#" id="smallbutton">Delete</a></p>';
			 
			 }
			 else
			 {
				 echo'</p>';
			 }
			 echo'
			 </div>
			 </div>';
			 }
		    }
		    else{
			 echo "Please leave a comment!";
		    }
	       
	       ?>
	
	</div>
	</div>
	<!--Tile bg ends here-->
    
    <div id="bottom">
  	</div>

</div>

</body>

</html>

