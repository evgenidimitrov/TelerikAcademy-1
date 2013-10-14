<?php
$pageTitle = "Нова книга";
include 'include/header.php';
require_once 'include/dbconfig.php';

$query = "SELECT * FROM authors ";
$result= mysqli_query($connection, $query);

//previous entered texts in form are saved on error
?>
<a href="./">Книги</a>
<form method="post">
	<label for="title">Име на книгата: </label> <input type="text"
		value="<?php if (isset ( $_POST ['submit'] ) && $_POST ['title'] != '') echo $_POST ['title'];?>"
		name="title" /> <label for="message">Автори: </label> <select
		name="authors[]" multiple="multiple">
		<?php
		while ( $row = mysqli_fetch_assoc ( $result ) ) {
			$authorid = $row ["author_id"];
			echo "<option value='$authorid'>";
			echo $row ["author_name"];
			echo "</option>";
		}
		?>
	</select> <input type="submit" name="submit" value="Добави книга" />
</form>

<?php

if (isset ( $_POST ['submit'] )) {
	$error = false;
	// data is filtred for XSS (cross site scripts)
	$title = sanitizeString ( $_POST ['title'] );
	
	// data is filtred for sql injection
	$title = mysqli_real_escape_string ( $connection, $title );
	
	$titleLength = mb_strlen ( $title );
	
	if (! isset ( $_POST ['authors'] )) {
		echo "Трябва да има избран поне един автор.<br />";
		$error = true;
	} else {
		$authors = $_POST ['authors'];
	}
	
	if ($titleLength < 3 || $titleLength > 250) {
		echo "Името на книгата трябва да е между 3 и 250 символа.<br />";
		$error = true;
	}
	
	if (! $error) {		
		$query = "INSERT INTO books (book_title) VALUES ('$title')";
		$result = mysqli_query ( $connection, $query );
		if (! $result) {
			echo "Проблем с добавянето на книга.<br />";
			exit ();
		}
		$lastInsertedId = mysqli_insert_id ( $connection );
		foreach ( $authors as $value ) {
			$values [] = "($lastInsertedId, $value)";
		}
		$query = "INSERT INTO books_authors VALUES " . implode ( ', ', $values );

		$result = mysqli_query ( $connection, $query );
		
		if ($result) {
			echo "Книгата '$title' е добавена!";
		} else {
			echo 'Проблем с добавянето на книгата и авторите.<br />';
		}
	}
}


	