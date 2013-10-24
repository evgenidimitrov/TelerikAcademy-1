<?php
require_once 'dbconfig.php';
function sanitizeString($var) {
	if (get_magic_quotes_gpc ())
		$var = stripslashes ( $var );
	$var = htmlentities ( $var, ENT_QUOTES, 'UTF-8' );
	$var = strip_tags ( $var );
	return $var;
}
function getBooks($connection, $order = "ASC") {
	$query = " SELECT * FROM books
JOIN books_authors ON books_authors.book_id = books.book_id
LEFT JOIN authors ON authors.author_id = books_authors.author_id ORDER BY books.book_title $order";
	
	$result = mysqli_query ( $connection, $query );
	if (mysqli_error ( $connection )) {
		return false;
	}
	$returnData = array ();
	while ( $row = mysqli_fetch_assoc ( $result ) ) {
		$returnData [] = $row;
	}
	return $returnData;
}
function getBooksByAuthorId($connection, $authorid) {
	$query = "SELECT * FROM books_authors AS b1, books_authors AS b2
	LEFT JOIN authors ON authors.author_id = b2.author_id
	LEFT JOIN books ON b2.book_id = books.book_id
	WHERE b1.author_id = $authorid 
	AND b2.book_id = b1.book_id";
	
	$result = mysqli_query ( $connection, $query );
	if (mysqli_error ( $connection )) {
		return false;
	}
	$returnData = array ();
	while ( $row = mysqli_fetch_assoc ( $result ) ) {
		$returnData [] = $row;
	}
	return $returnData;
}
function isBookExists($connection, $bookname) {
	$query = " SELECT * FROM books
	WHERE book_title = '$bookname'";
	
	$result = mysqli_query ( $connection, $query );
	if (mysqli_error ( $connection )) {
		return false;
	}
	if (mysqli_num_rows ( $result ) > 0)
		return true;
	else
		return false;
}
function getAuthors($connection, $authorname = null, $sort = "ASC") {
	if (is_null ( $authorname ))
		$query = "SELECT * FROM authors ORDER BY author_name $sort ";
	else
		$query = "SELECT * FROM authors WHERE author_name = '$authorname' ORDER BY author_name $sort ";
	
	$result = mysqli_query ( $connection, $query );
	if (mysqli_error ( $connection )) {
		return false;
	}
	$returnData = array ();
	while ( $row = mysqli_fetch_assoc ( $result ) ) {
		$returnData [] = $row;
	}
	return $returnData;
}
function getAuthorById($connection, $authorid) {
	$query = "SELECT * FROM authors WHERE author_id = $authorid";
	
	$result = mysqli_query ( $connection, $query );
	if (mysqli_error ( $connection )) {
		return false;
	}
	$returnData = array ();
	while ( $row = mysqli_fetch_assoc ( $result ) ) {
		$returnData = $row;
	}
	return $returnData;
}
function addAuthor($connection, $authorname) {
	$query = "INSERT INTO authors (author_name) VALUES ('$authorname')";
	$result = mysqli_query ( $connection, $query );
	
	if ($result) {
		return true;
	} else {
		return false;
	}
}
function checkSortOrder($sort) {
	$orderType = "ASC";
	if (isset ( $sort )) {
		switch ($sort) {
			case "asc" :
				$orderType = "ASC";
				break;
			case "desc" :
				$orderType = "DESC";
				break;
		}
	}
	return $orderType;
}
function addBook($connection, $title, $authors) {
	$query = "INSERT INTO books (book_title) VALUES ('$title')";
	$result = mysqli_query ( $connection, $query );
	if (! $result) {
		return false;
	}
	$lastInsertedId = mysqli_insert_id ( $connection );
	foreach ( $authors as $value ) {
		$values [] = "($lastInsertedId, $value)";
	}
	$query = "INSERT INTO books_authors VALUES " . implode ( ', ', $values );
	
	$result = mysqli_query ( $connection, $query );
	
	if ($result) {
		return true;
	} else {
		return false;
	}
}
function getBookInfo($connection, $bookid) {
	$query = "SELECT *
	FROM books
	LEFT JOIN books_authors ON books.book_id = books_authors.book_id
	LEFT JOIN authors ON authors.author_id = books_authors.author_id
	WHERE books.book_id =$bookid";
	$result = mysqli_query ( $connection, $query );
	if (mysqli_error ( $connection )) {
		return false;
	}
	$returnData = array ();
	while ( $row = mysqli_fetch_assoc ( $result ) ) {
		$returnData [] = $row;
	}
	return $returnData;
}
function getComments($connection, $bookId, $sort = "ASC") {
	$query = "SELECT comments.*, users.username
	FROM comments
	LEFT JOIN books_comments ON comments.comment_id = books_comments.comment_id
	LEFT JOIN users  ON users.user_id = comments.user_id
	WHERE books_comments.book_id =$bookId ORDER BY comments.date $sort";
	$result = mysqli_query ( $connection, $query );
	if (mysqli_error ( $connection )) {
		return false;
	}
	$returnData = array ();
	while ( $row = mysqli_fetch_assoc ( $result ) ) {
		$returnData [] = $row;
	}
	return $returnData;
}
function getBookCommentsCount($connection, $bookId) {
	$query = "SELECT COUNT(*) as count
	FROM comments
	LEFT JOIN books_comments ON comments.comment_id = books_comments.comment_id
	WHERE books_comments.book_id = $bookId";
	$result = mysqli_query ( $connection, $query );
	if (mysqli_error ( $connection )) {
		return false;
	}
	$returnData = mysqli_fetch_assoc ( $result );
	return $returnData;
}
function getUserComments($connection, $userid, $sort = "ASC") {
	$query = "SELECT * FROM books_comments
LEFT JOIN comments ON comments.comment_id = books_comments.comment_id
LEFT JOIN books ON books.book_id = books_comments.book_id
WHERE comments.user_id = $userid ORDER BY comments.date $sort";
	$result = mysqli_query ( $connection, $query );
	if (mysqli_error ( $connection )) {
		return false;
	}
	$returnData = array ();
	while ( $row = mysqli_fetch_assoc ( $result ) ) {
		$returnData [] = $row;
	}
	return $returnData;
}
function findBook($connection, $booktitle) {
	$query = "SELECT * FROM books_authors
	LEFT JOIN authors ON authors.author_id = books_authors.author_id
	LEFT JOIN books ON books_authors.book_id = books.book_id
	WHERE books.book_title LIKE '%$booktitle%'";
	$result = mysqli_query ( $connection, $query );
	if (mysqli_error ( $connection )) {
		return false;
	}
	$returnData = array ();
	while ( $row = mysqli_fetch_assoc ( $result ) ) {
		$returnData [] = $row;
	}
	return $returnData;
}
function getUsername($connection, $userid){
	$query = "SELECT * FROM users WHERE user_id = $userid";
	$result = mysqli_query ( $connection, $query );
	if (mysqli_error ( $connection )) {
		return false;
	}
	$returnData = array ();
	while ( $row = mysqli_fetch_assoc ( $result ) ) {
		$returnData = $row;
	}
	return $returnData;
}