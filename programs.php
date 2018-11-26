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

    $commentquery = "SELECT * FROM programcomments ORDER BY commentid DESC";
    $comments = $db->prepare($commentquery);
    $comments->execute();

    $count = 0;						
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
		                	<h2><a href='program.php?programid=<?= $row['programid']?>'><?= $row['difficulty_level'] ?></a></h2>
		                	<div>
		                		<ul>
		                			<li>Amount: <?= $row['amount'] ?></li>
		                			<li>Description: <?= $row['description'] ?></li>
		                		</ul>
		                	</div>
		                	<form method="post" action="process_postprogram.php">
						        <label for="content" ></label>
						        <input id="content" name="content" placeholder="Leave comment here...">
						        <input type="hidden" name="programid" value='<?= $row['programid'] ?>'/>
						        <input class="submit" name="command" type="submit" value="Comment">
    						</form>
    						<!-- Show comments per program -->
		                	<?php if ($comments->rowCount() != 0): ?>
								<?php while ($comment = $comments->fetch()): ?>
									<?php $count++; ?>
            						<?php if($count < 6): ?>
            							<?= $count ?>
										<?php if ($comment['programid'] == $row['programid']): ?>
											<div>
									        	<small>
									        		<?= $comment['username'] ?>
						        					<?= date('F d, Y, h:i a',strtotime($comment['date']))?>
						        					<a href="edit.php?id=<?= $comment['commentid'] ?>">edit</a>
						        				</small>
									            <p><?= substr($comment['content'],0,200) ?></p>
									            <?php if(strlen($comment['content']) > 200) : ?>
                  									...<a href='post.php?id=<?php echo $row['commentid']?>'>Read more</a>
                  								<?php endif ?> 
									    	</div>
									    <?php endif ?>
									<?php endif ?>
								<?php endwhile ?>
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