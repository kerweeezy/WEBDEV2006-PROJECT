<?php

?>
<!DOCTYPE html>
<html lang="E"N>
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
		<!-- Fetches all rows from the statement object -->
		<?php while ($row = $statement->fetch()): ?>
			<?php if ($_GET['classid'] == $row['classid']): ?>
				<form action="class.php" method="post">
					<fieldset>
					    <p></p>
					    	<label>Style</label>
					    	<input type="style" name="style" value="<?= $row['style'] ?>" />
					    </p>
					    <p>
					    	<label>Instructor</label>
					    	<input type="instructor" name="instructor" value="<?= $row['instructor'] ?>" />
					    </p>
					    <p>
					    	<label>Amount</label>
					    	<input type="amount" name="amount" value="<?= $row['amount'] ?>" />
					    </p>
					    <?php if ($admin == true): ?>
					    	<input type="hidden" name="classid" value='<?php echo $row['classid']?>'/>
					    	<input type="submit" name="command" value="Update" />
					    	<input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
					    <?php endif ?>
					</fieldset>
				</form>
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
