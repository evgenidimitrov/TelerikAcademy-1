<?php
include 'include/header.php';
include 'include/conf.php';
if (isset ( $_SESSION ['userId'] )) {
	if ($_POST) {
		$directory = "uploads" . DIRECTORY_SEPARATOR . $users [$_SESSION ['userId']];
		if (! is_dir ( $directory ))
			mkdir ( $directory );
		if (move_uploaded_file ( $_FILES ['fileChooser'] ['tmp_name'], $directory . DIRECTORY_SEPARATOR . $_FILES ["fileChooser"] ["name"] )) {
			echo "File uploaded.\n";
			echo $_FILES ['fileChooser'] ['name'];
			header ( "Location: filelist.php" );
			exit ();
		} else {
			echo "There is problem with uploading.!\n";
		}
	}
	
	if (empty ( $_FILES ) && empty ( $_POST ) && isset ( $_SERVER ['REQUEST_METHOD'] ) && strtolower ( $_SERVER ['REQUEST_METHOD'] ) == 'post') {
		echo "<p>File is greater than limit!</p>";
	}
	?>
<form action="" method="post" enctype="multipart/form-data">
	<p>Choose file <?php echo "with size less than " . ini_get ( 'post_max_size' );?></p>
	<input type="file" name="fileChooser" /> <input type="submit"
		name="submit" value="Upload" />
</form>
<?php
} else {
	header ( "Location: index.php" );
	exit ();
}
include 'include/footer.php';