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

     $admin = false;

     if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];

		if ($user["username"] != 'admin') {
			header('Location: class.php');
		}
		else {
			$admin = true;

			$amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
			$style = filter_input(INPUT_POST, 'style', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$instructor = filter_input(INPUT_POST, 'instructor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT);
			$error_string = false;

			if ($_POST && !empty($style) && !empty($instructor)) {
				$classid = filter_input(INPUT_POST,'classid', FILTER_SANITIZE_NUMBER_INT);
				
				// Updates class info.
				if ($_POST['command']=='Update')
				{
					$query = "UPDATE classes SET style = :style, instructor = :instructor, amount = :amount WHERE classid = :classid";
					$statement = $db->prepare($query);
				    $statement->bindValue(':style',$style);
				    $statement->bindValue(':instructor',$instructor);
				    $statement->bindValue(':amount', $amount);
				    $statement->bindValue(':classid', $classid, PDO::PARAM_INT);
				}
				// Deletes the class by classid.
				else if ($_POST['command']=='Delete')
				{
					$query = "DELETE FROM classes WHERE classid = :classid";
					$statement = $db->prepare($query);
					$statement->bindValue(':classid', $classid, PDO::PARAM_INT);
				}

				if ($statement->execute()) {
	 	    		header('Location: classes.php');   
	  			}
			}
		}
	}
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
