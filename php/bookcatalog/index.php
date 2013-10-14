<?php
$pageTitle = "Книги";
include 'include/header.php';
require_once 'include/dbconfig.php';
mb_internal_encoding('UTF-8');
?>

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

$query = " SELECT * FROM `books_authors`
LEFT JOIN authors ON authors.author_id = books_authors.author_id
LEFT JOIN books ON books_authors.book_id = books.book_id ORDER BY books.book_title $order";

$result = mysqli_query ( $connection, $query );
$rearrangedResult = array ();
while ( $row = mysqli_fetch_assoc ( $result ) ) {
	$rearrangedResult [$row ["book_id"]] ["book"] = $row ["book_title"];
$rearrangedResult [$row ["book_id"]] ["authors"] [$row ["author_id"]] = $row ["author_name"];
} 
?>
<a href="newbook.php">Нова книга</a>
<a href="authors.php">Нов автор</a>
<a href="search.php">Търси книга</a>
<form method=get>
Сортирай книгите
	<select name="sort">
		<option value="asc">Низходящо</option>
		<option value="desc">Възходящо</option>
	</select> 
	<input type="submit" value="Сортирай" />
</form>
<table>
	<tr>
		<td>Книга</td>
		<td>Автори</td>
	</tr>
<?php 

	foreach ( $rearrangedResult as $value ) {
					echo "<tr><td>";
					echo $value ["book"];
					echo "</td>";
					echo "<td>";
					$authors= array();
					foreach ( $value ["authors"] as $key=>$innervalue )
						$authors[]= "<a href='getbooks.php?authorid=$key'>" . $innervalue . "</a>";
					echo implode(',&nbsp;&nbsp;', $authors);    
					echo "</td></tr>";
					}
	?>
</table>


<?php
include 'include/footer.php';