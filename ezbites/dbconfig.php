<?php

// Connecting, selecting database
$dblink = mysql_connect("mlc104.csumb.edu", "bell2224", "ezbytes")
    or die("Could not connect to database at $dbhost: " . mysql_errno() . ": " . mysql_error());

mysql_select_db("bell2224-recipes",$dblink)
    or die("Could not select database $dbdatabase: " . mysql_errno() . ": " . mysql_error());
