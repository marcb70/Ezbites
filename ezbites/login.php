<?php
session_start();
if(isset($_POST['username']))
{
	
$username = $_POST['username'];
$password = $_POST['password'];

if ($username && $password)
{
	include "dbconfig.php";
	$loginquery = mysql_query("SELECT * FROM users WHERE UserName = '$username'");
	
	$numrows = mysql_num_rows($loginquery);	
	
	if ($numrows !=0)
	{
		//Log in code
		while ($row = mysql_fetch_assoc($loginquery))
		{
			$dbusername = $row['UserName'];
			$dbpassword = $row['Password'];
			$activated = $row['activated'];
			
			if ($activated=='0')
			{
				echo "<h2>Your account is not yet active. Please check your email</h2><br />Redirecting in 5 seconds...";
				echo '<meta http-equiv="refresh" content="5" />';
				die();
				exit();
			
			}
			
		}
		
		//Check to see if they match
		if($username==$dbusername&&md5($password)==$dbpassword)
		{
			
			$_SESSION['username'] = $username;
			
			if($_SESSION['username'] == "admin")
			{
				header("Location: admin.php");
				exit;
			}
			else 
			header("Location: member.php");
			exit;
			
		}
		else
		echo '<script type="text/javascript"> alert("Incorrect Password!");</script>';
	}
	else
	echo '<script type="text/javascript"> alert("That user doesnt exist!");</script>';	
	
	
}
else 
	
echo '<script type="text/javascript"> alert("Please enter Username and Password");</script>';	




}

?>