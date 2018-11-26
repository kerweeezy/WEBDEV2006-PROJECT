<?php
	session_start();
	require('connect.php');

	// If logout is clicked, logs the user out.
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header('Location: index.php');
	}
	
	$query = "SELECT * FROM programs ORDER BY programid ASC";
    $statement = $db->prepare($query);
    $statement->execute();				
?>
<!DOCTYPE html>
<html lang="EN">
<head>
	<meta charset="utf-8">
	<title>Programs</title>
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
			<?php if ($statement->rowCount() != 0): ?>
		        <ul>
		          	<?php while($row = $statement->fetch()): ?>
		              	<div>
		                	<h2><a href='showprogram.php?programid=<?= $row['programid']?>'><?= $row['difficulty_level'] ?></a></h2>
		              	</div>
		          	<?php endwhile ?>
		      </ul>
    		<?php else: ?>
        		<p>There are no programs available.</p>
    		<?php endif ?>
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