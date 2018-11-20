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

    $commentquery = "SELECT * FROM program comments";
    $comments = $db->prepare($commentquery);
    $comments->execute();
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
			<?php if ($statement->rowCount()!= 0): ?>
		        <ul>
		          	<?php while($row = $statement->fetch()): ?>
		              	<div class="class">
		                	<h2><a href='program.php?programid=<?= $row['programid']?>'><?= $row['difficulty_level'] ?></a></h2>
		                	<div>
		                		<ul>
		                			<li>Amount: <?= $row['amount'] ?></li>
		                			<li>Description: <?= $row['description'] ?></li>
		                		</ul>
		                	</div>
		                	<form method="process_postprogram" action="programs.php">
						        <label for="content" ></label>
						        <input id="content" name="content" placeholder="Leave comment here...">
						        <input type="hidden" name="username" value="<?= $row['user'] ?>" />
						        <input class="submit" name="command" type="submit">
    						</form>
		                	<?php if ($comments->rowCount() != 0): ?>
							    <div>
							        <?php while ($row = $comments->fetch()): ?>
							        	<small>
							        		<?= $row['username'] ?>
				        					<?= $row['date'] ?>
				        					<a href="edit.php?id=<?= $row['commentid'] ?>">edit</a>
				        				</small>
							            <p><?= $row['content'] ?></p>
							        <?php endwhile ?>
							    </div>
							<?php endif ?>
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