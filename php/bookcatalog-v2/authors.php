<?php
$pageTitle = "Автори";
include 'include/header.php';
require_once 'include/dbconfig.php';

if (isset ( $_POST ['submit'] )) {
	$error = false;
	// data is filtred for XSS (cross site scripts)
	$authorname = sanitizeString ( $_POST ['authorname'] );
	
	// data is filtred for sql injection
	$authorname = mysqli_real_escape_string ( $connection, $authorname );
	$authornameLength = mb_strlen ( $authorname );
	
	if ($authornameLength < 3 || $authornameLength > 250) {
		echo "<div class='alert alert-danger'>Името на автора трябва да е между 3 и 250 символа.</div>";
		$error = true;
	}
	$result = getAuthors ( $connection, $authorname );
	if ($result) {
		if (count ( $result ) > 0) {
			echo "<div class='alert alert-danger'>Авторът вече е добавен.</div>";
			$error = true;
		}
	}
	
	if (! $error) {
		$result = addAuthor ( $connection, $authorname );
		if ($result) {
			echo "<div class='alert alert-success'>Авторът е добавен!</div>";
		} else {
			echo "<div class='alert alert-danger'> Има грешка при добавяне на автор.</div>";
		}
	}
}
// previous entered texts in form are saved on error
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
<div class="row">
<div  class="col-md-6" >
<form method="post"role="form">
	<div class="form-group">
		<label for="title">Име на автор: </label>	
			<input type="text" class="form-control"
				value="<?php if (isset ( $_POST ['submit'] ) && $_POST ['authorname'] != '') echo $_POST ['authorname'];?>"
				name="authorname" />
		</div>
		<button type="submit" name="submit" class="btn btn-default">Добави автор</button>

</form>
</div></div>
<?php
if (isset ( $_GET ['sort'] ))
	$order = checkSortOrder ( $_GET ['sort'] );
$authors = getAuthors ( $connection );
?>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th>Автори</th>
		</tr>
		<?php
		foreach ( $authors as $value ) {
			echo "<tr><td>";
			$authorid = $value ["author_id"];
			echo "<a href='getauthorbooks.php?authorid=$authorid'>" . $value ["author_name"] . "</a>";
			echo "</td></tr>";
		}
		?>
</table>
</div>
<?php
include 'include/footer.php';