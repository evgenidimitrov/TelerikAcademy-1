<?php
$pageTitle = "Търсене";
include 'include/header.php';
require_once 'include/dbconfig.php';

?>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-body">
				<form method="get">
					<div class="form-group">
						<label for="bookname">Име на книга: </label> <input type="text"
							value="<?php if (isset ( $_POST ['submit'] ) && $_POST ['keyword'] != '') echo $_POST ['keyword'];?>"
							name="keyword" class="form-control" />
					</div>
					<input type="submit" class="btn btn-primary btn-md"
						value="Търси книга" />

				</form>
			</div>
		</div>
	</div>
</div>
<?php
if (isset ( $_GET ["keyword"] ))
	$booktitle = $_GET ["keyword"];
else
	$booktitle = '';

$booktitle = sanitizeString ( $booktitle );

// data is filtred for sql injection
$booktitle = mysqli_real_escape_string ( $connection, $booktitle );
$result = findBook ( $connection, $booktitle );

if ($result) {
	if (count ( $result ) > 0) {
		$rearrangedResult = array ();
		foreach ( $result as $value ) {
			$rearrangedResult [$value ["book_id"]] ["book"] = $value ["book_title"];
			$rearrangedResult [$value ["book_id"]] ["authors"] [$value ["author_id"]] = $value ["author_name"];
		}
	}
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
	echo "<div class='alert alert-danger'>Няма такава книга.</div>";
}

include 'include/footer.php';