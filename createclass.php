<?php
	session_start();

	require('connect.php');
	
	// If unauthorized user tries to access the page, they are redirected to the home page.
	if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];

		if ($user["username"] == 'admin') {
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
	if (isset($_POST['new_class'])) {

		// Filter and sanitize the inputs.
		$amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
		$style = filter_input(INPUT_POST, 'style', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$instructor = filter_input(INPUT_POST, 'instructor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT);

		$userid = $_SESSION['user']['userid'];
		
		if (!empty($style) && !empty($instructor) && !empty($amount)){
			$query = "INSERT INTO classes (userid, style, instructor, amount) VALUES (:userid, :style, :instructor, :amount)";
			$statement = $db->prepare($query);
			$statement->bindValue(':userid', $userid);
		    $statement->bindValue(':style', $style);
		    $statement->bindValue(':instructor', $instructor);
		    $statement->bindValue(':amount', $amount);

			if ($statement->execute()) {
			 	header('Location: createclass.php');
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
			<a href="index.php"><h2>JSON</h2><h3> Urban Dance Studio</h3></a><h1>.</h1>
			<?php include('nav.php') ?>
		</header>
		<div id="content">
			<div class="header">
  				<h2>Create A Class</h2>
  			</div>
	
		  	<form method="post" action="createclass.php">
		  		<div">
		  	  		<label>Style</label>
		  	  		<input type="text" name="style">
		  		</div>
		  		<div>
		  	  		<label>Instructor</label>
		  	  		<input type="text" name="instructor">
		  		</div>
		  		<div>
		  	  		<label>Amount</label>
		  	  		<input type="number" name="amount">
		  		</div>
		  		<div>
		  	  		<button type="submit" class="btn" name="new_class">Create</button>
		  		</div>
		</form>
		<?php if ($success == true): ?>
			<h5>Class has been added.</h5>
		<?php endif	?>
		</div>
		<footer>
			<nav id="navfooter">
				<ul>
					<li><a href="index.php">Home</a></li><!--
				 --><li><a href="aboutus.html">About Us</a></li><!--
				 --><li><a href="formpage.html">Contact Us</a></li>
				</ul>
				<div id="bottomrow">Copyright &copy; <a href="#">2018 JSON Urban Dance Studio</a></div>
			</nav>
		</footer>
	</div>
</body>
</html>