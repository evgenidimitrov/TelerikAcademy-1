<?php
$pageTitle = "Автори";
include 'include/header.php';
require_once 'include/dbconfig.php';

//previous entered texts in form are saved on error
?>
<a href="./">Книги</a>
<form method=get>
	Сортирай авторите
	<select name="sort">
	<option value="asc">Низходящо</option>
		<option value="desc">Възходящо</option>
	</select> 
	<input type="submit" value="Сортирай" />
</form>
<form method="post">
	<label for="title">Име на автор: </label> <input type="text"
		value="<?php if (isset ( $_POST ['submit'] ) && $_POST ['authorname'] != '') echo $_POST ['authorname'];?>"
		name="authorname" /> <input type="submit" name="submit"
		value="Добави автор" />
</form>
<?php
$order = "ASC";
if (isset ( $_GET ['sort'] )) {
	switch ($_GET ['sort']) {
		case "asc" :
			$order = "ASC";break;
		case "desc" :
			$order = "DESC";break;
	}
}

$query = "SELECT * FROM authors ORDER BY author_name $order"; 
$result = mysqli_query ( $connection, $query );
?>
<table>
	<tr>
		<td>Автори</td>
	</tr>
		<?php 
		while ( $row = mysqli_fetch_assoc ( $result ) ) {
			$authors [] = $row;
		}
		foreach ( $authors as $value ) {
			echo "<tr><td>";
			$authorid = $value ["author_id"];
			echo "<a href='getbooks.php?authorid=$authorid'>" . $value ["author_name"] . "</a>";
			echo "</td></tr>";
		}
	?>
</table>

<?php

if (isset ( $_POST ['submit'] )) {
	$error = false;
	// data is filtred for XSS (cross site scripts)
	$authorname = sanitizeString ( $_POST ['authorname'] );
	
	// data is filtred for sql injection
	$authorname = mysqli_real_escape_string ( $connection, $authorname );
	$authornameLength = mb_strlen ( $authorname );
	
	if ($authornameLength < 3 || $authornameLength > 250) {
		echo "Името на автора трябва да е между 3 и 250 символа.<br />";
		$error = true;
	}
	
	foreach ( $authors as $value ) {
		if ($authorname == $value ['author_name']) {
			echo "Авторът вече е въведен.<br />";
			$error = true;
			break;
		}
	}
	
	if (! $error) {
		$query = "INSERT INTO authors (author_name) VALUES ('$authorname')";
		$result = mysqli_query ( $connection, $query );
		if ($result) {
			echo 'Авторът е добавен!';
			header ( 'Location: ' . $_SERVER ['PHP_SELF'] );
			exit ();
		} else {
			echo 'Има грешка при добавяне на автор. ';
		}
	}
}
