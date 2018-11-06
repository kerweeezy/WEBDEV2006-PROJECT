<?php
    session_start();
    require('connect.php');

	// If logout is clicked, logs the user out.
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header('Location: h.php');
	}
    
     // SQL is written as a String.
     $query = "SELECT * FROM programs ORDER BY programid DESC"; 

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
</head>
<body>
	<div id="container">
		<header id="header">
			<a href="h.php"><h2>JSON</h2><h3> Urban Dance Studio</h3></a><h1>.</h1>
			<?php include('nav.php') ?>
		</header>
		<?php while ($row = $statement->fetch()): ?>
			<?php if ($_GET['programid'] == $row['programid']): ?>
				<div class="class">
				  	<h2><?= $row['difficulty_level'] ?></a></h2>
				  	<p><?= $row['amount'] ?></p>
				</div>
			<?php endif ?>
		<?php endwhile ?>
        <footer>
			<nav id="navfooter">
				<ul>
					<li><a href="h.php">Home</a></li><!--
				 --><li><a href="">About Us</a></li><!--
				 --><li><a href="">Contact Us</a></li>
				</ul>
				<div id="bottomrow">Copyright &copy; <a href="#">2018 JSON Urban Dance Studio</a></div>
			</nav>
		</footer>
    </div>
</body>
</html>
