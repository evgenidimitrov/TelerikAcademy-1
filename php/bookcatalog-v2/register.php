<?php
session_start();
$pageTitle = "Register new user";
include 'include/header.php';
require_once 'include/dbconfig.php';
?>

<?php
$error = false;
if (isset ( $_POST ['submit'] )) {
	$username = trim ( $_POST ['username'] );
	$password = trim ( $_POST ['password'] );
	$repeatedPassword = trim ( $_POST ['passwordRepeat'] );
	
	if ($password != $repeatedPassword) {
		$error = true;
		echo "<div class='alert alert-danger'>Passwords do not match. </div>";
	}
	
	$usernameLength = mb_strlen ( $username );
	$passwordLength = mb_strlen ( $password );
	
	if ($usernameLength < 5) {
		echo "<div class='alert alert-danger'>Username  should be at least 5 chars.</div>";
		$error = true;
	}
	if ($passwordLength < 5) {
		echo "<div class='alert alert-danger'>Password  should be at least 5 chars.</div>";
		$error = true;
	}
	if (! strpos($username, " ") === false) {
		echo "<div class='alert alert-danger'>Username should not contain spaces.</div>";
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
					echo "<div class='alert alert-danger'>Username is taken. Please try with other username!</div>";
					$error = true;
				}
			}
		} else {
			// message for missing username. It says wrong, because no one should know that such user does not exists.
			if (! $error) {
				$query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
				$result = mysqli_query ( $connection, $query );
				if ($result) {
					$_SESSION ['userId'] = mysqli_insert_id($connection);
					$_SESSION ['username'] = $username;
					header ( "Location: ." );
					exit ();
				} else {
					echo "<div class='alert alert-danger'>There is error when registering new user</div>";
				}
			}
		}
	}
}

?>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-body">
				<form method="post">
					<div class="form-group">
						<label for="username">Username: </label> 
						<input type="text" class="form-control"	name="username" />
					</div>
					<div class="form-group">
						<label for="password">Password: </label> 
						<input type="password" class="form-control" name="password" />
					</div>
					<div class="form-group">
						<label for="passwordRepeat">Repeat Password: </label> <input
							type="password" class="form-control" name="passwordRepeat" />
					</div>
					<input type="submit" name="submit" class="btn btn-primary btn-md"
						value="Register" />
				</form>

			</div>
		</div>
	</div>
</div>