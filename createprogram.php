<?php
	session_start();
	
	// If unauthorized user tries to access the page, they are redirected to the home page.
	if (($_SESSION['username']) != 'admin') {
		header('Location: h.php');
	}

	// If logout is clicked, logs the user out.
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header('Location: h.php');
	}
?>
<!DOCTYPE html>
<html lang="EN">
<head>
	<meta charset="utf-8">
	<title>JSON Urban Dance Studio</title>
	<link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
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
	
		  	<form method="post" action="createclass.php">
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
		  	  		<button type="submit" class="btn" name="reg_user">Create</button>
		  		</div>
		  </form>
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