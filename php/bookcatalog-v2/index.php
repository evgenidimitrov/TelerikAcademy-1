<?php
$pageTitle = "Книги";
include 'include/header.php';

if (isset ( $_GET ['sort'] ))
	$order = checkSortOrder ( $_GET ['sort'] );
$books = getBooks ( $connection, $order );

$rearrangedResult = array ();
foreach ( $books as $value ) {
	$rearrangedResult [$value ["book_id"]] ["book"] = $value ["book_title"];
	$rearrangedResult [$value ["book_id"]] ["authors"] [$value ["author_id"]] = $value ["author_name"];
}

?>

<form method="get" class="form-inline" role="form"><label>Сортирай книгите</label>
<div class="form-group">
	<select name="sort" class="form-control">
		<option value="asc">Низходящо</option>
		<option value="desc">Възходящо</option>
	</select>
</div>
<input type="submit" class="btn btn-primary btn-sm" value="Сортирай" />
</form>

<div class="table-responsive">
	<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th>Книга</th>
			<th>Автори</th>
		</tr>
<?php
foreach ( $rearrangedResult as $key => $value ) {
	echo "<tr><td>";
	$commentsCount = getBookCommentsCount ( $connection, $key );
	echo "<a href='book.php?bookid=$key'>" . $value ["book"] . "</a> [" . $commentsCount ["count"] . "]";
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
include 'include/footer.php';