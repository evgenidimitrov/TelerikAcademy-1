<?php
include 'include/header.php';
include 'include/conf.php';
?>
<form method="post">
	<label for="username">Username: </label><input type="text" name="username" /> 
	<label for="password">Password: </label><input type="text" name="password" />
	<input type="submit" 	name="submit" value="Login" />
</form>
<?php
//checking if user has logged in - redirecting to filelist
if (isset($_SESSION['userId']))
{
	header("Location: filelist.php");
	exit;
}
// checking credentials
if (isset ( $_POST ['submit'] )) {
	$username = trim ( $_POST ['username'] );
	$password = trim ( $_POST ['password'] );
	$position = array_search ( $username, $users );
	if ($position || $position === 0) {
		if ($passwords [$position] == $password) {
			$_SESSION ['userId'] = $position;
			header("Location: filelist.php");
			exit;
		} else {
			echo 'Wrong username and password. Please try again!';
		}
	}
	else {echo 'Wrong username and password. Please try again!';
}
}

include 'include/footer.php';