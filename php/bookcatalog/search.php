<?php
$pageTitle = "Търсене";
include 'include/header.php';
require_once 'include/dbconfig.php';
mb_internal_encoding('UTF-8');
?>
<a href="./">Книги</a><br/><br/>
<form method="get">
	<label for="bookname">Име на книга: </label> <input type="text"
		value="<?php if (isset ( $_POST ['submit'] ) && $_POST ['keyword'] != '') echo $_POST ['keyword'];?>"
		name="keyword" /> <input type="submit" 
		value="Търси книга" />
</form>
<?php
if (isset ( $_GET ["keyword"] ))
	$booktitle = $_GET ["keyword"];

$booktitle = sanitizeString ( $booktitle);

// data is filtred for sql injection
$booktitle = mysqli_real_escape_string ( $connection, $booktitle );

$query = "SELECT * FROM books_authors
LEFT JOIN authors ON authors.author_id = books_authors.author_id
LEFT JOIN books ON books_authors.book_id = books.book_id
WHERE books.book_title LIKE '%$booktitle%'";

$result = mysqli_query ( $connection, $query );
if ($result) {
	if (mysqli_num_rows ( $result ) > 0) {
			$rearrangedResult = array ();
			while ( $row = mysqli_fetch_assoc ( $result ) ) {
				$rearrangedResult [$row ["book_id"]] ["book"] = $row ["book_title"];
				$rearrangedResult [$row ["book_id"]] ["authors"] [$row ["author_id"]] = $row ["author_name"];
			}
				?>
				
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
	} else {
		echo "Aвторът няма въведени книги.";
	}
} 

include 'include/footer.php';