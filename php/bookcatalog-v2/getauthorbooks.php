<?php
$pageTitle = "Книги от автор";
include 'include/header.php';
require_once 'include/dbconfig.php';

?>
<?php

if (isset ( $_GET ["authorid"] ))
	$authorid = ( int ) $_GET ["authorid"];
else {
	header ( 'Location:  .' );
	exit ();
}

if ($author = getAuthorById ( $connection, $authorid )) {
	
	$books = getBooksByAuthorId ( $connection, $authorid );
	if (count ( $books ) > 0) {
		$rearrangedResult = array ();
		foreach ( $books as $value ) {
			$rearrangedResult [$value ["book_id"]] ["book"] = $value ["book_title"];
			$rearrangedResult [$value ["book_id"]] ["authors"] [$value ["author_id"]] = $value ["author_name"];
		}
		
		echo "<h3>Автор " . $author ["author_name"] . " участва във следните книги:</h3>";
		?>


<div class="table-responsive">
	<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th>Книга</th>
			<th>Автори</th>
		</tr>
<?php
		foreach ( $rearrangedResult as $key => $value ) {
			echo "<tr><td>";
			echo "<a href='book.php?bookid=$key'>" . $value ["book"] . "</a>";
			echo "</td>";
			echo "<td>";
			$authors = array ();
			foreach ( $value ["authors"] as $key => $innervalue )
				$authors [] = "<a href='getauthorbooks.php?authorid=$key'>" . $innervalue . "</a>";
			echo implode ( ',&nbsp;&nbsp;', $authors );
			echo "</td></tr>";
		}
		?>
</table>
</div>

<?php
	} else {
		echo "<div class='alert alert-danger'>Aвторът няма въведени книги.</div>";
	}
} else
	echo "<div class='alert alert-danger'>Няма такъв автор</div>";

include 'include/footer.php';