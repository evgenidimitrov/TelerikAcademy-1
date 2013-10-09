<?php 
$pageTitle = "Register new user";
include 'include/header.php';
require_once 'include/dbconfig.php';
?>
<form method="post">
	<label for="username">Username: </label> <input type="text"
		name="username" /> <label for="password">Password: </label> <input
		type="text" name="password" /> <label for="passwordRepeat">Repeat
		Password: </label> <input type="text" name="passwordRepeat" /> <input
		type="submit" name="submit" value="Register" />
</form>
<?php
					$error = false;
					if (isset ( $_POST ['submit'] )) {
						$username = trim ( $_POST ['username'] );
						$password = trim ( $_POST ['password'] );
						$repeatedPassword = trim ( $_POST ['passwordRepeat'] );
					
						if ($password != $repeatedPassword) {
							$error = true;
							echo "Passwords do not match. <br />";
						}
						
						$usernameLength = mb_strlen ( $username );
						$passwordLength = mb_strlen ( $password );
						
						if ($usernameLength < 5) {
							echo "Username  should be at least 5 chars.<br />";
							$error = true;
						}
						if ($usernameLength < 5) {
							echo "Password  should be at least 5 chars.<br />";
							$error = true;
						}
						
						$username = mysqli_real_escape_string ( $connection, $username );
						$query = "SELECT *  FROM users WHERE username='$username'";
						$result = mysqli_query ( $connection, $query );
						if ($result) {
							if (mysqli_num_rows ( $result ) > 0) {
								while ( $row = mysqli_fetch_assoc ( $result ) ) {
									$storedUsername = $row ["username"];
									if ($username == $storedUsername) {
										echo 'Username is taken. Please try with other username!';
										$error = true;
									}
								}
							} else {
								// message for missing username. It says wrong, because no one should know that such user does not exists.
								if (! $error) {
									$query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
									$result = mysqli_query ( $connection, $query );
									if ($result) {
										 header ( "Location: ." );
										 exit ();
									} else {
										echo "There is error when registering new user";
									}
								}
							}
						}
					}