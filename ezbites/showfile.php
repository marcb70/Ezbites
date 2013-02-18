<?php

if (empty($_GET['id'])&&(empty($_GET['pic']))) {
	die("No id specified.");
}
else{
	
require_once 'dbconfig.php';
if(isset($_GET['id']))
{
$query = "SELECT * FROM Recipes WHERE recipeID=" . intval($_GET['id']);
$result = mysql_query($query)
or die("Query failed: $query " . mysql_error());
$line = mysql_fetch_assoc($result)
or die("Retrieve failed: id " . $_GET['id'] . " not found.");

header('Pragma: cache');
header('Cache-Control: cache');
header('Content-Type: image/jpeg');
echo $line['image'];
}
else
{
	$query = "SELECT * FROM profile b JOIN users a ON b.username= a.UserName WHERE userID =" . intval($_GET['pic']);
$result = mysql_query($query)
or die("Query failed: $query " . mysql_error());
$line = mysql_fetch_assoc($result)
or die("Retrieve failed: id " . $_GET['id'] . " not found.");

header('Pragma: cache');
header('Cache-Control: cache');
header('Content-Type: image/jpeg');
echo $line['pic'];
}
}

