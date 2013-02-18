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
       	  
       	  
          <div id="updateform">
          <?php	
		  		$id = $_GET['id'];
		  		$submit = $_POST['submit'];
				$title = $_POST['title'];
				$method = $_POST['method'];
				$dish = $_POST['dish'];
				$cost = $_POST['cost'];
				$prep = $_POST['prep'];
				$ins = $_POST['instructions'];
				$ing = $_POST['ingredients'];
				$submitted = $_POST['submitted'];
				
				//Update has been submitted
				if($submit)
				{ 
					 //Connect to db
					 include_once "dbconfig.php";
					 
					 $update = "UPDATE Recipes SET dishID='$dish', cookingmethodID = '$method', title ='$title', cost='$cost', preptime='$prep', ingredients='$ing', instructions='".mysql_real_escape_string($ins)."', submitted='$submitted' " .
	   ((is_uploaded_file($_FILES['img']['tmp_name'])) ? 'image=\''.mysql_real_escape_string(file_get_contents($_FILES['img']['tmp_name'])).'' : '') . " WHERE recipeID ='$id'";
					 
					 
					 mysql_query($update);
					 
					 //Feedback: Record updated
					 
					echo "Recipe has been updated.<br />";
					 
					 
					}
					
					//Is user trying to add a recipe?			
					$addsubmit = $_POST['add'];
				 
				 	if($addsubmit)
				 	{
						//check to see if all fields are set
						if($title&&$dish&&$method&&$cost&&$prep&&$ing&&$ins&&$submitted)
						{
							//check to see if title has less than 25 characters
							if(strlen($title) >25)
							{
							 echo '<p class="warning"><b>Title must be less than 25 characters!</b></p><br />'; 
							}
							else{
								//check to see if cost format has more than 5 characters(00.00)
								if(strlen($cost) >5)
								{
									echo '<p class="warning"><b>Cost must be in this format: "00.00" or "0.00"</b></p><br />';
								}
								
								else
								{
									if(strlen($prep)>10)
									{
									 	echo '<p class="warning"><b>Preperation must be in this format "0 Minutes" or "0 Hours"</b></p>';	
									}
									else
									{
										//Check to see if user included an image.
					 					if(is_uploaded_file($_FILES['img']['tmp_name']))
					 					{
											//connect to db
											include_once "dbconfig.php";
					 
											$add = "INSERT INTO Recipes VALUES ('','$dish','$method', '$title','$cost','$prep','$ing','$ins','$submitted','0', '" .mysql_real_escape_string(file_get_contents($_FILES['img']['tmp_name']))."')";
	   					
					 						mysql_query($add);
					 
					 						//Feedback: new record added
											echo "New record added!<br /><br />";
					 					}
										else
										{
											echo '<p class="warning"><b>You must include an image!</b></p>';
										}
									}
								}
							}
						}
						else
						{
							echo '<p class="warning"><b>Please fill in all fields!</b></p>';
						}
								  
				 	}
				 
				 
		  	  
				if(isset($_GET['id'])){
					$id = $_GET['id'];
					
					//connect to db
					include 'dbconfig.php';
					$upquery = "SELECT * FROM Recipes b JOIN cookingmethod a ON b.cookingmethodID = a.methodID JOIN dish c ON b.dishID = c.dishID WHERE recipeID = '$id'";
					$result = mysql_query($upquery);
					$line = mysql_fetch_assoc($result);
				}
				
					
					//display form
					echo '<form action="" id="update" method="post" enctype="multipart/form-data">
					<b>Title</b> <br /><textarea name="title" cols="25" rows="1">'.$line['title'].'</textarea><br /><br />
					<b>Image</b> <br />
					<img src="showfile.php?id='.$id.'" width="100" height="100"><br /><br />
					<input type = "file" name="img" /><br /><br />
					<b>Method</b><br />
					<select name="method"><option selected value="'.$line['methodID'].'">' .$line['method'] . '</option>
        				<option value="1">Oven</option>
                        <option value="2">Grill</option>
     					<option value="3">Microwave</option>
						<option value="4">Stove-Top</option>
						<option value="5">Uncooked</option>
     					</select><br /><br />
					<b>Dish</b><br />
					<select name="dish"><option selected value="'.$line['dishID'].'">' .$line['dish'] . '</option>
        				<option value="1">Chicken</option>
                        <option value="2">Beef</option>
     					<option value="3">Pork</option>
						<option value="4">Vegan</option>
						<option value="5">Vegitarian</option>
						<option value="6">Pasta</option>
						<option value="7">Soup</option>
     					</select><br /><br />
					<b>Cost</b><i> (E.g. "00.00")</i><br /> <textarea name="cost" cols="25" rows="1">'.$line['cost'].'</textarea><br /><br />
					<b>Prep Time</b><i> (E.g. "0 Minutes/Hours")</i><br /> <textarea name="prep" cols="25" rows="1">'.$line['preptime'].'</textarea><br /><br />
					<b>Ingredients</b><br /><textarea name="ingredients" cols="50" rows="5">'.$line['ingredients'].'</textarea><br /><br />
					<b>Instructions</b><br /><textarea name="instructions" cols="50" rows="5">'.$line['instructions'].'</textarea><br /><br />
					<b>Submitted by</b><br /> <textarea name="submitted" cols="25" rows="1">'.$line['submitted'].'</textarea><br /><br />';
					if(isset($_GET['id'])){ echo '<input type="submit" name = "submit" id="updatebtn" value="Update">
					</form>';}
					else{
						echo '<input type="submit" name = "add" id="updatebtn" value="Add">
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

