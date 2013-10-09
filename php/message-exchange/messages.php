<?php
$pageTitle = "Messages";
include 'include/header.php';
require_once  'include/dbconfig.php';

if (isset ( $_SESSION ['userId'] )) {
	$username=$_SESSION ['userName'];
				echo "Hello  $username. <br /><br /><hr/>";

				$query="SELECT * FROM messages ORDER BY date DESC ";
				$result= mysqli_query($connection, $query);
				while ($row = mysqli_fetch_assoc($result))
				{
					//simple html formating
					echo '<strong>Message Title:  </strong><br />'.$row['title'];
					echo '</br></br>';
					echo '<strong>Message:  </strong><br />'.$row['message'];
					echo '</br></br>';
					$date = strtotime($row['date']);
					echo "<strong>Date: </strong> " .date( 'd-m-Y H:i:s' , $date);
					echo '</br>';
					echo "<strong>Username: </strong> " .$row['username'];
					echo '</br><hr />';					
				}
} else {
	header("Location: .");
	exit ();
}

