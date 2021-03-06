<?php
    session_start();
    require('connect.php');

	// If logout is clicked, logs the user out.
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header('Location: index.php');
	}

    // SQL is written as a String.
    $query = "SELECT * FROM programs ORDER BY programid DESC"; 
    $statement = $db->prepare($query);
    $statement->execute();

    $programid = $_GET['programid'];

    $commentquery = "SELECT * FROM programcomments, programs WHERE programcomments.programid = :programid AND programcomments.programid = programs.programid ORDER BY commentid DESC";
    $comments = $db->prepare($commentquery);
    $comments->bindValue(':programid', $programid, PDO::PARAM_INT);
    $comments->execute();

    $count = 0;		

    //This section is to insert comments
    if ($_POST) {

	    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$user = ($_SESSION['user']);
		
		if (empty($user)) {
			$username = $name;
		}
		else {
			$username = $user['username'];
		}

		$programid = filter_input(INPUT_POST,'programid', FILTER_SANITIZE_NUMBER_INT);
		$commentid = filter_input(INPUT_POST,'commentid', FILTER_SANITIZE_NUMBER_INT);

		if ($_POST) {
			$query = "INSERT INTO programcomments (programid, content, username) VALUES (:programid, :content, :username)";
			$commented = $db->prepare($query);
			$commented->bindValue(':programid', $programid);
	        $commented->bindValue(':content', $content);
	        $commented->bindValue(':username', $username);
	        $commented->execute();

	        header('Location: showprogram.php?programid'.$programid);
		}
		else {
			$_SESSION['comment_error'] = 'There was an error submitting your comment';
		}
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
		<?php while ($row = $statement->fetch()): ?>
			<?php if ($_GET['programid'] == $row['programid']): ?>
				<div>
		            <h2><a href='showprogram.php?programid=<?= $row['programid']?>'><?= $row['difficulty_level'] ?></a></h2>
		               	<div>
		                	<ul>
		                		<li>Amount: <?= $row['amount'] ?></li>
		                		<li>Description: <?= $row['description'] ?></li>
		                	</ul>
		                </div>
		                <form method="post" action="showprogram.php">
						    <label for="content" ></label>
						    <textarea id="content" name="content" placeholder="Leave comment here..." ></textarea>
						    <?php if (!isset($_SESSION['user'])): ?>
						    	<input type="text" name="name" placeholder="Insert Name" required="Please fill out this field">
						    <?php endif ?>
						    <input type="hidden" name="programid" value='<?= $row['programid'] ?>'/>
						    <!--<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA" />-->
						    <input class="submit" name="command" type="submit" value="Comment">
    					</form>
    						<!-- Show comments per program -->
		                <?php if ($comments->rowCount() != 0): ?>
							<?php while ($comment = $comments->fetch()): ?>
								<?php $count++; ?>
            					<?php if($count < 6): ?>
										<div>
									        <small>
									        	<?= $comment['username'] ?>
						        				<?= date('F d, Y, h:i a',strtotime($comment['date']))?>
						        				<?php if (isset($_SESSION['user'])): ?>
						        					<?php if ($user['username'] == 'admin' || $user['username'] == $username): ?>
						        						<a href="editprogram.php?commentid=<?= $comment['commentid'] ?>">edit</a>
						        					<?php endif ?>
						        				<?php endif ?>
						        			</small>
									        <p><?= substr($comment['content'],0,200) ?></p>
									        <?php if(strlen($comment['content']) > 200) : ?>
                  								...<a href='post.php?commentid=<?php echo $row['commentid']?>'>Read more</a>
                  							<?php endif ?> 
									    </div>
								<?php endif ?>
							<?php endwhile ?>
						<?php endif ?>
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
