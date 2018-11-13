<?php

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
		<?php while ($row = $statement->fetch()): ?>
			<?php if ($_GET['programid'] == $row['programid']): ?>
				<form action="program.php" method="post">
					<fieldset>
					    <p></p>
					    	<label>Difficulty Level</label>
					    	<input type="difficulty_level" name="difficulty_level" value="<?= $row['difficulty_level'] ?>" />
					    </p>
					    <p>
					    	<label>Amount</label>
					    	<input type="amount" name="amount" value="<?= $row['amount'] ?>" />
					    </p>
					    <p>
					    	<label>Description</label>
					    	<textarea name="description" id="description"><?= $row['description'] ?></textarea>
					    </p>
					    <?php if ($admin == true): ?>
					    	<input type="hidden" name="programid" value='<?php echo $row['programid']?>'/>
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
