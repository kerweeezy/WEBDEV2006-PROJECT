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

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);

     // Execution on the DB server is delayed until we execute().
     $statement->execute();

     $admin = false;

     if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];

		if ($user["username"] != 'admin') {
			header('Location: programs.php');
		}
		else {
			$admin = true;

			$amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
			$difficulty_level = filter_input(INPUT_POST, 'difficulty_level', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT);
			$error_string = false;

			if ($_POST && !empty($difficulty_level) && !empty($description)) {
				$programid = filter_input(INPUT_POST,'programid', FILTER_SANITIZE_NUMBER_INT);
				
				// Updates program info.
				if ($_POST['command']=='Update')
				{
					$query = "UPDATE programs SET difficulty_level = :difficulty_level, description = :description, amount = :amount WHERE programid = :programid";
					$statement = $db->prepare($query);
				    $statement->bindValue(':difficulty_level',$difficulty_level);
				    $statement->bindValue(':description',$description);
				    $statement->bindValue(':amount', $amount);
				    $statement->bindValue(':programid', $programid, PDO::PARAM_INT);
				}
				// Deletes the program by programid.
				else if ($_POST['command']=='Delete')
				{
					$query = "DELETE FROM programs WHERE programid = :programid";
					$statement = $db->prepare($query);
					$statement->bindValue(':programid', $programid, PDO::PARAM_INT);
				}

				if ($statement->execute()) {
	 	    		header('Location: programs.php');   
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
