<?php
include 'include/header.php';
include 'include/conf.php';

if (isset ( $_SESSION ['userId'] )) {
	echo '<a href="logout.php">Logout</a> ';
	echo '<a href="upload.php">Upload</a> <hr />';
	$username = $users [$_SESSION ["userId"]];
	$directoryName = "uploads" . DIRECTORY_SEPARATOR . $users [$_SESSION ['userId']];
	if (realpath ( $directoryName )) {
		$files = scandir ( $directoryName );
		
		if ($files) {
			echo "Hello $username. Your files are:";
			foreach ( $files as $value ) {
				if ($value == ".." || $value == ".")
					continue;
				$link = $directoryName . "/" . $value;
				if (realpath ( $link ))
					echo "<div class='filelink'> <a href='$link'> $value</a>  " . human_filesize ( filesize ( $link ) ) ."</div>";
			}
		}
	} else {
		echo 'No files uploaded';
	}
} else {
	header("Location: .");
	exit ();
}
function human_filesize($bytes, $decimals = 2) {
	$sz = ' KMGTP';
	$factor = floor ( (strlen ( $bytes ) - 1) / 3 );
	return sprintf ( "%.{$decimals}f", $bytes / pow ( 1024, $factor ) ) . " " . @$sz [$factor] . "bytes";
}