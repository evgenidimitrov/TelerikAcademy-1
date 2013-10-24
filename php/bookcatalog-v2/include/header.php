<?php

mb_internal_encoding ( 'UTF-8' );
require_once  'const.php';
require_once  'functions.php';
?>
<!DOCTYPE html>
<head>
<title><?php echo $pageTitle;?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="css/styles.css" rel="stylesheet" media="screen">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
		      <script src="../../assets/js/html5shiv.js"></script>
		      <script src="../../assets/js/respond.min.js"></script>
		    <![endif]-->

</head>
<body>
	<div class="container">
		<h1>Book Catalog</h1>

		<nav class="navbar navbar-default" role="navigation">

			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse"
						data-target=".navbar-responsive-collapse">
						<span class="sr-only">Toggle navigation</span> <span
							class="icon-bar"></span> <span class="icon-bar"></span> <span
							class="icon-bar"></span>
					</button>

				</div>
				<div class="navbar-responsive-collapse">
					<ul class="nav navbar-nav">
						<li><a href="./">Home</a></li>
						<li><a href="./">Книги</a></li>
						<li><a href="addbook.php">Нова книга</a></li>
						<li><a href="authors.php">Нов автор</a></li>
						<li><a href="search.php">Търси книга</a></li>
					</ul>
				</div>

			</div>

		</nav>
		