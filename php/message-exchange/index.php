<?php
$pageTitle = "Login";
include 'include/header.php';
require_once 'include/dbconfig.php';

?>

<?php
// checking if user has logged in - redirecting to messages
if (isset ( $_SESSION ['userId'] )) {
	header ( "Location: messages.php" );
	exit ();
}
// checking credentials
if (isset ( $_POST ['submit'] )) {
	$username = trim ( $_POST ['username'] );
	$password = trim ( $_POST ['password'] );
	
	$username = mysqli_real_escape_string ( $connection, $username );
	$query = "SELECT *  FROM users WHERE username='$username'";
	$result = mysqli_query ( $connection, $query );
	if ($result) {
		if (mysqli_num_rows ( $result ) > 0) {
			while ( $row = mysqli_fetch_assoc ( $result ) ) {
				$storedPassword = $row ["password"];
				$storedUsername = $row ["username"];
				if ($username == $storedUsername) {
					if ($password == $storedPassword) {
						$_SESSION ['userId'] = $row ["userid"];
						$_SESSION ['userName'] = $storedUsername;
						echo "logged";
						header ( "Location: messages.php" );
						exit ();
					} else {
						echo 'Wrong  password. Please try again!';
					}
				} else {
					echo 'Wrong username. Please try again!';
				}
			}
		} else {
			//message for missing username. It says wrong, because no one should know that such user does not exists.
			echo 'Wrong username. Please try again!';
		}
	}
}

?>
<form method="post">
	<label for="username">Username: </label>
	<input type="text" name="username" /> 
	<label for="password">Password: </label>
	<input type="text" name="password" /> 
	<input type="submit" name="submit" 	value="Login" />
</form>
<a href="register.php">Register new user</a>

<?php
include 'include/footer.php';