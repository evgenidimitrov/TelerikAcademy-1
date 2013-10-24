<?php
$pageTitle = "Добави книга";
include 'include/header.php';

if (isset ( $_POST ['submit'] )) {
	$error = false;
	// data is filtred for XSS (cross site scripts)
	$title = sanitizeString ( $_POST ['title'] );
	
	// data is filtred for sql injection
	$title = mysqli_real_escape_string ( $connection, $title );
	
	$titleLength = mb_strlen ( $title );
	
	if (! isset ( $_POST ['authors'] )) {
		echo "<div class='alert alert-danger'>Трябва да има избран поне един автор.</div>";
		$error = true;
	} else {
		$authors = $_POST ['authors'];
	}
	
	if ($titleLength < 3 || $titleLength > 250) {
		echo "<div class='alert alert-danger'>Името на книгата трябва да е между 3 и 250 символа.</div>";
		$error = true;
	}
	
	if (isBookExists ( $connection, $title )) {
		echo "<div class='alert alert-danger'>Книгата вече въведена.</div>";
		$error = true;
	}
	
	if (! $error) {
		$result = addBook ( $connection, $title, $authors );
		if (! $result) {
			echo "<div class='alert alert-danger'>Проблем с добавянето на книга.</div>";
			exit ();
		}
		if ($result) {
			echo "<div class='alert alert-success'>Книгата '$title' е добавена</div>";
		} else {
			echo "<div class='alert alert-danger'>Проблем с добавянето на книгата и авторите.</div>";
		}
	}
}

$authors = getAuthors ( $connection );
?>
<div class="row">
	<div class="col-md-6">
		<form method="post" role="form">
			<div class="form-group">
				<label for="title">Име на книгата: </label> <input type="text"
					class="form-control" name="title"
					value="<?php if (isset ( $_POST ['submit'] ) && $_POST ['title'] != '') echo $_POST ['title'];?>" />
			</div>
			<div class="form-group">
				<label for="message">Автори: </label> <select name="authors[]"
					multiple="multiple" size='15' class="form-control">
		<?php
		foreach ( $authors as $value ) {
			$authorid = $value ["author_id"];
			echo "<option value='$authorid'>";
			echo $value ["author_name"];
			echo "</option>";
		}
		?>
	</select>
			</div>
			<button type="submit" name="submit" class="btn btn-default">Добави
				книга</button>
		</form>
	</div>
</div>
<?php
include 'include/footer.php';
