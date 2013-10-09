<?php
session_name("message-exchange");
session_set_cookie_params(3600,'/',$_SERVER["HTTP_HOST"],false, true);
session_start();
include 'functions.php';
?>
<!DOCTYPE html>
<head>
<title><?php echo $pageTitle;?></title>
<link type="text/css" href="styles/style.css" rel="stylesheet">
</head>
<body>
<div id="wrapper">
<?php 
if (isset ( $_SESSION ['userId'] )) {
echo '<a href="logout.php">Logout</a> ';
echo '<a href="newmessage.php">New Message</a> <hr />';
}