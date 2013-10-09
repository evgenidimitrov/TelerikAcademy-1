<?php
$pageTitle = "New message";
include 'include/header.php';
require_once 'include/dbconfig.php';

if (! isset ( $_SESSION ['userId'] )) {
	header ( "Location: ." );
	exit ();
}

//previous entered texts in form are saved on error
?>
<form method="post">
	<label for="title">Message title: </label>
	<input type="text" value="<?php if (isset ( $_POST ['submit'] ) && $_POST ['title'] != '') echo $_POST ['title'];?>"name="title" /> 
	<label for="message">Message: </label>
	<textarea name="message"/><?php if (isset ( $_POST ['submit'] ) && $_POST ['message'] != '') echo $_POST ['message'];?></textarea>
	<input type="submit" name="submit" value="Post" />
</form>
<?php

if (isset ( $_POST ['submit'] )) {
	$error = false;
	//data is filtred for XSS (cross site scripts)
	$title = sanitizeString ( $_POST ['title'] );
	$message = sanitizeString ( $_POST ['message'] );

	//data is filtred for sql injection
	$title = mysqli_real_escape_string ( $connection, $title );
	$message = mysqli_real_escape_string ( $connection, $message );
	$titleLength = mb_strlen ( $title );
	$messageLength = mb_strlen ( $message );
	
	if ($titleLength < 1 || $titleLength > 50) {
		echo "Message title should be between 1 and  50 chars.<br />";				
		$error = true;
	}
	if ($messageLength < 1 || $messageLength > 250) {
		echo "Message should be between 1 char and 250 chars.<br />";				
		$error = true;
	}
	if (! $error) {
		$today = date ( 'Y-m-d H:i:s' );
		$username=$_SESSION ['userName'];
		$query = "INSERT INTO messages (title,message, date, username) VALUES ('$title','$message', '$today', '$username')";
		
		$result = mysqli_query ( $connection, $query );
		
		if ($result) {
			echo 'inserted!';
			header ( "Location: messages.php" );
			exit ();
		} else {
			echo 'There is error when inserting data. ';
		}
	}
}
	

