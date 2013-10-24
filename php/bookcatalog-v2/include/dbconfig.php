<?php
$DBhost ='';
$DBuser='';
$DBpassword='';
$DB='books';
$connection=mysqli_connect($DBhost, $DBuser, $DBpassword, $DB);
if (!$connection)
	{
	die("Error with database");	
	}
mysqli_set_charset($connection, "utf8");