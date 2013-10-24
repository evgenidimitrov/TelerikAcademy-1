<?php
session_start ();
$pageTitle = "Книга";
include 'include/header.php';
require_once 'include/dbconfig.php';

if (isset ( $_GET ['bookid'] )) {
	$bookId = ( int ) $_GET ['bookid'];
	$_SESSION["bookid"]=$bookId;
	$bookinfo = getBookInfo ( $connection, $bookId );
	if ($bookinfo) {
		$rearrangedResult = array ();
		foreach ( $bookinfo as $value ) {
			$rearrangedResult ["book"] = $value ["book_title"];
			$rearrangedResult ["authors"] [$value ["author_id"]] = $value ["author_name"];
		}
	} else {
		echo "<div class='alert alert-danger'>Няма такава книга</div>";
		exit ();
	}
} else {
	echo "<div class='alert alert-danger'>Няма въведeно ID</div>";
	exit ();
}
?>
<div class="panel panel-default">
	<div class="panel-body">
<?php
if (! isset ( $_SESSION ['userId'] )) :
	?>
	<a href="login.php" class="btn btn-primary btn-md">Login</a> <a
			href="register.php" class="btn btn-primary btn-md">Registration</a>
				<?php else: ?>
				<a href="logout.php" class="btn btn-primary btn-md">Logout</a>
<?php endif; ?>
</div>
</div>
<?php
if (isset ( $_SESSION ["userId"] )) {
	$welcomeUsername = $_SESSION ['username'];
	echo "<div class='alert alert-success'>Welcome $welcomeUsername </div>";
}
?>

<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">Заглавие</div>
			<div class="panel-body">
				<h3><?php echo $rearrangedResult["book"]?></h3>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default ">
			<div class="panel-heading">Автори</div>
			<div class="panel-body">
		    <?php
						$authors = array ();
						foreach ( $rearrangedResult ["authors"] as $key => $innervalue )
							$authors [] = "<a href='getauthorbooks.php?authorid=$key'>" . $innervalue . "</a>";
						echo implode ( ',&nbsp;&nbsp;', $authors );
						?>
			</div>
		</div>
	</div>
</div>
<?php
if (isset ( $_SESSION ['userId'] )) :
	?>
<div class="panel panel-default ">
	<div class="panel-body">
		<form method="post" action="addcomment.php" form="role">
			<div class="form-group">
				<label for="comment">Коментар: </label>
				<textarea name="comment" class="form-control" rows="3"><?php if (isset ( $_POST ['comment'] ) && $_POST ['comment'] != '') echo $_POST ['comment'];?></textarea>
				<input type="hidden" name="bookId" value="<?php echo $bookId; ?>" />
			</div>
			<button type="submit" name="submit" class="btn btn-default">Коментирай</button>
		</form>
	</div>
</div>

<?php 
endif;
?>
<div class="panel panel-default ">
	<div class="panel-heading">Коментари</div>
	<div class="panel-body">
	    <?php
					$bookId = ( int ) $_GET ['bookid'];
					$comments = getComments ( $connection, $bookId );
					
					if ($comments) {
						if (count ( $comments ) > 0) {
							foreach ( $comments as $value ) {
								?>
						<div class="panel panel-default ">
							<div class="panel-body">
							<?php
								echo $value ['comment'] . "</div>";
								$date = strtotime ( $value ['date'] );
								echo "<div class='panel-footer'><strong>Date: </strong> " . date ( 'd-m-Y H:i:s', $date );
								echo " <strong>Username:</strong> <a href='user.php?userid=" . $value ["user_id"] . "'>" . $value ['username'] . "</a>";
								?>
							</div>
						</div>
								<?php
							}
						} else {
							echo "Няма коментари";
						}
					} else {
						echo "Няма коментари";
					}
					?>
					
		</div>
</div>
<?php
include 'include/footer.php';