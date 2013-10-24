<?php
session_start ();
$pageTitle = "Login";
include 'include/header.php';
require_once 'include/dbconfig.php';

?>

<?php
if (isset ( $_SESSION ['userId'] )) {
	header ( "Location: ." );
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
						$_SESSION ['userId'] = $row ["user_id"];
						$_SESSION ['username'] = $storedUsername;
						if (isset ( $_SESSION ['bookid'] )) {
							header ( "Location: book.php?bookid=".$_SESSION['bookid'] );					
						} 
						else {
							header ( "Location: ." );
							exit ();
						}
					} else {
						echo "<div class='alert alert-danger'>Wrong  password. Please try again!</div>";
					}
				} else {
					echo "<div class='alert alert-danger'>Wrong username. Please try again!</div>";
				}
			}
		} else {
			// message for missing username. It says wrong, because no one should know that such user does not exists.
			echo "<div class='alert alert-danger'>Wrong username. Please try again!</div>";
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
						<label for="username">Username: </label> <input type="text"
							class="form-control" name="username" />
					</div>
					<div class="form-group">
						<label for="password">Password: </label> <input type="password"
							class="form-control" name="password" />
					</div>
					<input type="submit" name="submit" class="btn btn-primary btn-md"
						value="Login" />
				</form>
			</div>
			<div class="panel-footer">
				<a href="register.php">Register new user</a>
			</div>
		</div>
	</div>
</div>

<?php
include 'include/footer.php';