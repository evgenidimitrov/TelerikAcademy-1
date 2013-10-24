<?php
session_start();
require_once 'include/functions.php';
require_once 'include/dbconfig.php';

if (! isset ( $_SESSION ['userId'] )) {
	header ( "Location: ." );
	exit ();
}

if (isset ( $_POST ['submit'] )) {
	$bookId = (int) $_POST['bookId'];
	$error = false;
	//data is filtred for XSS (cross site scripts)

	$comment = sanitizeString ( $_POST ['comment'] );

	//data is filtred for sql injection
	$comment = mysqli_real_escape_string ( $connection, $comment );
	$commentLength = mb_strlen ( $comment );
	
	if ($commentLength < 1 || $commentLength > 300) {
		echo "Коментарът трябва да е между 1 символ и 300.<br />";				
		$error = true;
	}

	if (! $error) {
		$today = date ( 'Y-m-d H:i:s' );
		$user=$_SESSION ['userId'];
		$query = "INSERT INTO comments ( comment, date, user_id) VALUES ('$comment', '$today', '$user')";
		
		$result = mysqli_query ( $connection, $query );
		$lastInsertedId = mysqli_insert_id ( $connection );
		if ($result) {
			echo 'Коментарът е добавен.';
			$query = "INSERT INTO books_comments ( book_id, comment_id) VALUES ('$bookId', $lastInsertedId)";
			
			$result = mysqli_query ( $connection, $query );
			header ( "Location: book.php?bookid=$bookId" );
			exit ();
		} else {
			echo 'Има проблем при добавянето на коментар. ';
		}
	}
}