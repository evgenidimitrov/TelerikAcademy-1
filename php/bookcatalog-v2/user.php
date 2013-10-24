<?php
$pageTitle = "Потребител";
include 'include/header.php';
require_once 'include/dbconfig.php';

if (isset ( $_GET ['userid'] )) {
	$userid = ( int ) $_GET ['userid'];
	
	$userComments = getUserComments ( $connection, $userid );
	
	if ($userComments) {
		$username = getUsername($connection, $userid);
		$rearrangedResult = array ();
		foreach ( $userComments as $value ) {
			$rearrangedResult [$value ["book_id"]] ["title"] = $value ["book_title"];
			$rearrangedResult [$value ["book_id"]] ["comments"] [$value ["comment_id"]] ["comment"] = $value ["comment"];
			$rearrangedResult [$value ["book_id"]] ["comments"] [$value ["comment_id"]] ["date"] = $value ["date"];
		}
	} else {
		echo "<div class='alert alert-danger'>Потребителят няма коментари.</div>";
		exit ();
	}
	
	// print_r($rearrangedResult,false);exit;
	echo "<h3>Потребителят ". $username["username"]. " има следните коментари:</h3>";	
	?>

<div class="row">
	<div class="col-md-6">
			<?php
				foreach ( $rearrangedResult as $key => $value ) { ?>
			<div class='panel panel-default'><div class="panel-body">
				<?php
					echo "<h3> <a href='book.php?bookid=" . $key . "'>" . $value ["title"] . "</a></h3>";
					foreach ( $value ["comments"] as $vv ) {	?>
						<div class="panel-body">
								<div class="panel panel-default ">
									<div class="panel-body">
							<?php
							echo "<p><strong>Date:</strong> " . $vv ["date"] . "</p>";
							echo "<p>" . $vv ["comment"] . "</p>";
							echo "</div></div></div>";
						}
			 echo "</div></div>";
			  }
		?>
	</div>
</div>
<?php
} else {
	echo "<div class='alert alert-danger'>Няма въведeно ID.</div>";
}
include 'include/footer.php';