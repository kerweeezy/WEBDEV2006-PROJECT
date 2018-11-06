<?php

	require('connect.php');

	
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Error</title>
</head>
<body>
    <div id="container">
        <header id="header">
			<a href="h.php"><h2>JSON</h2><h3> Urban Dance Studio</h3></a><h1>.</h1>
			<nav id="navigation">
				<ul>
					<li><a href="h.php">Home</a></li><!--
				 --><li><a href="classes.php">Classes</a></li><!--
				 --><li><a href="login.php">Sign In</a></li><!--
				 --><li><a href="aboutus.html">About Us</a></li><!--
				 --><li><a href="formpage.html">Contact Us</a></li>
				</ul>
			</nav>
		</header>
		<div id="content">
	        <?php if ($error_string): ?>
				<h1>An error occured while creating your account.</h1>
			  	<p>Please try <a href="login.php">again.</a></p>
				<a href="h.php">Return Home</a>
			<?php endif ?>
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
