<?php
$pageTitle = "Книги от автор";
include 'include/header.php';
require_once 'include/dbconfig.php';
mb_internal_encoding('UTF-8');
?>
<a href="./">Книги</a><br/><br/>

<?php
if (isset ( $_GET ["authorid"] ))
	$authorid = $_GET ["authorid"];
else {	
	header ( 'Location:  .' );
	exit ();
}

$query = "SELECT * FROM books_authors AS b1, books_authors AS b2
LEFT JOIN authors ON authors.author_id = b2.author_id
LEFT JOIN books ON b2.book_id = books.book_id
WHERE b1.author_id = $authorid 
AND b2.book_id = b1.book_id";

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
} else
	echo "няма такъв автор";

include 'include/footer.php';