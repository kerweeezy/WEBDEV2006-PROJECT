<?php
	session_start();

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
			<!-- Notification message, display that the user has successfully logged in. -->
			<?php if (isset($_SESSION['success'])): ?>
				<h4>
					<?php
						echo $_SESSION['success'];
						unset($_SESSION['success']);
					?>
				</h4>
			<?php endif ?>
			<p id="p1">REGISTER FOR OUR CLASSES AND PROGRAMS.</p>
			<div id="fixedbg"></div>
			<p id="p2">A VARIETY OF CLASSES. ONE STUDIO.</p>
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