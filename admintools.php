<?php
    session_start();
    
	require('connect.php');

	// If logout is clicked, logs the user out.
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header('Location: index.php');
	}

?>
<!DOCTYPE html>
<html lang="EN">
<head>
	<meta charset="utf-8">
	<title>JSON Urban Dance Studio</title>
	<link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	<div id="container">
		<header id="header">
			<a href="index.php"><h2>JSON</h2><h3> Urban Dance Studio</h3></a><h1>.</h1>
			<?php include('nav.php') ?>
		</header>
		<div id="content">
			<ul>
				<li><a href="createclass.php">Add New Class</a></li>
				<li><a href="createprogram.php">Add New Program</a></li>
				<li><a href="">Modify Class</a></li>
				<li><a href="">Modify Program</a></li>
				<li><a href="">Delete Class</a></li>
				<li><a href="">Delete Program</a></li>
			</ul>
		</div>
		<footer>
			<nav id="navfooter">
				<ul>
					<li><a href="index.php">Home</a></li><!--
				 --><li><a href="">About Us</a></li><!--
				 --><li><a href="">Contact Us</a></li>
				</ul>
				<div id="bottomrow">Copyright &copy; <a href="#">2018 JSON Urban Dance Studio</a></div>
			</nav>
		</footer>
	</div>
</body>
</html>