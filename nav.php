<?php
	
?>

<nav id="navigation">
	<!-- Changes sign in/logout nav option depending if a user is signed in. -->
	<?php if (isset($_SESSION['username'])): ?>
		<?php if ($_SESSION['username'] == 'admin'): ?>
			<ul>
				<li><a href="h.php">Home</a></li><!--
			 --><li><a href="classes.php">Classes</a></li><!--
			 --><li><a href="programs.php">Programs</a></li><!--
			 --><li><a href="admintools.php">Admin Tools</a></li><!--
			 --><li><a href="h.php?logout='1'">Logout</a></li>
			</ul>
		<?php else: ?>
			<ul>
				<li><a href="h.php">Home</a></li><!--
			 --><li><a href="classes.php">Classes</a></li><!--
			 --><li><a href="programs.php">Programs</a></li><!--
			 --><li><a href="h.php?logout='1'">Logout</a></li><!--
			 --><li><a href="aboutus.html">About Us</a></li><!--
			 --><li><a href="formpage.html">Contact Us</a></li>
			</ul>
		<?php endif ?>
	<?php else: ?>
		<ul>
			<li><a href="h.php">Home</a></li><!--
		 --><li><a href="classes.php">Classes</a></li><!--
		 --><li><a href="programs.php">Programs</a></li><!--
		 --><li><a href="login.php">Sign In</a></li><!--
		 --><li><a href="aboutus.html">About Us</a></li><!--
		 --><li><a href="formpage.html">Contact Us</a></li>
		</ul>
	<?php endif ?>
</nav>