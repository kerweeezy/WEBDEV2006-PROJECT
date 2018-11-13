<?php
	session_start();

	require('connect.php');
	
	// If unauthorized user tries to access the page, they are redirected to the home page.
	if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];

		if ($user["username"] != 'admin') {
			header('Location: index.php');
		}
	}

	// If logout is clicked, logs the user out.
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header('Location: index.php');
	}

	// Declare variables
	$success = false;

	// Registering a new user
	if (isset($_POST['new_program'])) {

		// Filter and sanitize the inputs.
		$amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
		$difficulty_level = filter_input(INPUT_POST, 'difficulty_level', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT);

		$userid = $_SESSION['user']['userid'];
		
		if (!empty($difficulty_level) && !empty($amount) && !empty($description)){
			$query = "INSERT INTO programs (userid, difficulty_level, amount, description) VALUES (:userid, :difficulty_level, :amount, :description)";
			$statement = $db->prepare($query);
			$statement->bindValue(':userid', $userid);
		    $statement->bindValue(':difficulty_level', $difficulty_level);
		    $statement->bindValue(':amount', $amount);
		    $statement->bindValue(':description', $description);

			if ($statement->execute()) {
			 	header('Location: createprogram.php');
			 	$success = true;
			}
			exit;
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
			<a href="h.php"><h2>JSON</h2><h3> Urban Dance Studio</h3></a><h1>.</h1>
			<?php include('nav.php') ?>
		</header>
		<div id="content">
			<div class="header">
  				<h2>Create A Program</h2>
  			</div>
	
		  	<form method="post" action="createprogram.php">
		  		<div">
		  	  		<label>Difficulty Level</label>
		  	  		<input type="text" name="difficulty_level">
		  		</div>
		  		<div>
		  	  		<label>Amount</label>
		  	  		<input type="text" name="amount">
		  		</div>
		  		<div>
		  	  		<label>Description</label>
		  	  		<input type="text" name="description">
		  		</div>
		  		<div>
		  	  		<button type="submit" class="btn" name="new_program">Create</button>
		  		</div>
		  	</form>
		  	<?php if ($success == true): ?>
		  		<h5>Program successfully added.</h5>
		  	<?php endif	?>
		</div>
		<footer>
			<nav id="navfooter">
				<ul>
					<li><a href="h.php">Home</a></li><!--
				 --><li><a href="aboutus.html">About Us</a></li><!--
				 --><li><a href="formpage.html">Contact Us</a></li>
				</ul>
				<div id="bottomrow">Copyright &copy; <a href="#">2018 JSON Urban Dance Studio</a></div>
			</nav>
		</footer>
	</div>
</body>
</html>