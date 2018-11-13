<?php
	$admin = false;

	if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];

		if ($user["username"] == 'admin') {
			$admin = true;
		}
	}
?>
<nav id="navigation">
	<!-- Changes sign in/logout nav option depending if a user or the admin is signed in. -->
	<?php if (isset($_SESSION['username'])): ?>
		<?php if ($admin == true): ?>
			<ul>
				<li><a href="index.php">Home</a></li><!--
			 --><li><a href="classes.php">Classes</a></li><!--
			 --><li><a href="programs.php">Programs</a></li><!--
			 --><li><a href="admintools.php">Admin Tools</a></li><!--
			 --><li><a href="index.php?logout='1'">Logout</a></li>
			</ul>
		<?php else: ?>
			<ul>
				<li><a href="index.php">Home</a></li><!--
			 --><li><a href="classes.php">Classes</a></li><!--
			 --><li><a href="programs.php">Programs</a></li><!--
			 --><li><a href="index.php?logout='1'">Logout</a></li><!--
			 --><li><a href="">About Us</a></li><!--
			 --><li><a href="">Contact Us</a></li>
			</ul>
		<?php endif ?>
	<?php else: ?>
		<ul>
			<li><a href="index.php">Home</a></li><!--
		 --><li><a href="classes.php">Classes</a></li><!--
		 --><li><a href="programs.php">Programs</a></li><!--
		 --><li><a href="login.php">Sign In</a></li><!--
		 --><li><a href="">About Us</a></li><!--
		 --><li><a href="">Contact Us</a></li>
		</ul>
	<?php endif ?>
</nav>