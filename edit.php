<?php
	session_start();
	require('connect.php');

	// If logout is clicked, logs the user out.
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
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
			<?php while ($row = $statement->fetch()): ?>
				<?php if ($_GET['id'] == $row['id']): ?>
				    <div id="all_blogs">
				      	<form action="process_postprogram.php" method="post">
				        	<fieldset>
					          	<legend>Edit Comment</legend>
					          	<p>
					            	<label for="title">Title</label>
					            	<input name="title" id="title" value="<?= $row['title'] ?>" />
					          	</p>
					          	<p>
					            	<label for="content">Content</label>
					            	<textarea name="content" id="content"><?= $row['content'] ?></textarea>
					          	</p>
					          	<p>
					            	<input type="hidden" name="id" value="<?= $row['id'] ?>" />
					            	<input type="submit" name="command" value="Update" />
					            	<input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
					          	</p>
				        	</fieldset>
				      	</form>
				    </div>
				<?php endif ?>
			<?php endwhile ?>
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