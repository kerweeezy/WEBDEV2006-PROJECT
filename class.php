<?php
    session_start();
    require('connect.php');

	// If logout is clicked, logs the user out by destroying current session and unsetting the session variable.
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header('Location: index.php');
	}
    
     // Selects all classes.
     $query = "SELECT * FROM classes ORDER BY classid DESC"; 

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);

     // Execution on the DB server is delayed until we execute().
     $statement->execute();
?>
<!DOCTYPE html>
<html>
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
		<!-- Fetchs all rows from the statement object -->
		<?php while ($row = $statement->fetch()): ?>
			<?php if ($_GET['classid'] == $row['classid']): ?>
				<div class="class">
				    <h2><?= $row['style'] ?></a></h2>
				    <p>Instructor: <?= $row['instructor'] ?></p>
				    <p>Amount: <?= $row['amount'] ?></p>
				</div>
			<?php endif ?>
		<?php endwhile ?>
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
