<?php
	session_start();

	require('connect.php');

	// If logout is clicked, logs the user out.
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header('Location: index.php');
	}

	// Declare error variables
	$username_error = false;
	$email_error = false;
	$password_error = false;
	$username_empty = false;
	$password_empty = false;
	$login_error = false;
	$register_error = false;

	// Registering a new user
	if (isset($_POST['new_user'])) {

		// Filter and sanitize the inputs.
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password_1 = filter_input(INPUT_POST, 'password_1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password_2 = filter_input(INPUT_POST, 'password_2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		/* // Grabs data from the database so we can check if username and email have been taken already.
		$query = "SELECT username, email FROM users";
	    $statement = $db->prepare($query);
	    $statement->execute(); 

	    $row = $statement->fetch();
	  	
	  	
	   	if ($row['username'] == $username){
	      	$username_error = true;
	    }

	    if ($row['email'] == $email){
	      	$email_error = true;
	    }
		*/

	    // Checks to see if both passwords typed in are matching.
	  	if ($password_1 != $password_2) {
	  		$password_error = true;
	  	}
		
		// If password is valid, add user to the database.
	  	if (/*$username_error == false && $email_error == false && */$password_error == false){
			if (isset($_POST['new_user']) && !empty($name) && !empty($email) && !empty($username) && !empty($password_1)){

				//Hashes the password and inserts it into the database.
				$passwordHash = password_hash($password_1, PASSWORD_DEFAULT);

				$query = "INSERT INTO users (name, email, username, password) VALUES (:name, :email, :username, :password)";
				$statement = $db->prepare($query);
		        $statement->bindValue(':name', $name);
		        $statement->bindValue(':email', $email);
		        $statement->bindValue(':username', $username);
		        $statement->bindValue(':password', $passwordHash);

			    if ($statement->execute()) {
			 	    header('Location: login.php');
			 	    $_SESSION['registersuccess'] = "Registration Completed";
			  	}
			    exit;
			}
			else {
				$register_error = true;
			}
		}
	}

	// Logging in a user
	if (isset($_POST['login_user'])) {
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		// Checks to see if username is empty.
		if (empty($username)) {
			$username_empty = true;
		}

		// Checks to see if password is empty.
		if (empty($password)) {
			$password_empty = true;
		}

		// If password and password are not empty, check if they are found in the database.
		if ($username_empty != true && $password_empty != true) {
			
			// Grab rows where username and password match with the username and password entered.
			$query = "SELECT * FROM users WHERE username='$username'";
			$statement = $db->prepare($query);
			$statement->execute();
			$user = $statement->fetch();

			//Grabs the hashed password.
			$userPassHash = $user['password'];

			// Only one row should be returned and therefore username will be stored in a session variable.
			if ($statement->rowCount() == 1) {
				//Checks if the password the user entered and the hashed password matches.
				if (password_verify($password, $userPassHash)) {
					$_SESSION['user'] = $user;
					$_SESSION['success'] = "You are now logged in";

					// Send back to main page after logging in successfully.
					header('Location: index.php');
				}
			}
			else {
				$login_error = true;
			}
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
  				<h2>Login</h2>
  			</div>
		  	<form method="post" action="login.php">
		  		<div>
		  	  		<input type="text" name="username" placeholder="Username">
		  	  		<?php if ($username_empty == true): ?>
		  	  			<p>Username is required</p>
		  	  		<?php endif ?>
		  		</div>
		  		<div>
		  	  		<input type="password" name="password" placeholder="Password">
		  	  		<?php if ($password_empty == true): ?>
		  	  			<p>Password is required</p>
		  	  		<?php elseif ($login_error == true): ?>
		  	  			<p>Username and password invalid. Please try again.</p>
		  	  		<?php endif ?>
		  		</div>
		  		<div>
		  	  		<button type="submit" name="login_user">Login</button>
		  		</div>
		  	</form>
		  	<div class="header">
  				<h2>Create An Account</h2>
  			</div>
		  	<form method="post" action="login.php">
		  		<?php if ($register_error == true): ?>
		  	  			<p>Please fill in the fields.</p>
		  	  		<?php endif ?>
		  		<div>
		  	  		<input type="text" name="name" id="name" placeholder="Name">
		  		</div>
		  		<div>
		  	  		<input type="text" name="email" id="email" placeholder="Email">
		  	  		<?php if ($email_error == true): ?>
		  	  			<p>Email already exists.</p>
		  	  		<?php endif ?>
		  		</div>
		  		<div>
		  	  		<input type="text" name="username" id="username" placeholder="Username">
		  	  		<?php if ($username_error == true): ?>
		  	  			<p>Username already exists.</p>
		  	  		<?php endif ?>
		  		</div>
		  		<div>
		  	  		<input type="password" name="password_1" id="password_1" placeholder="Password">
		  		</div>
		  		<div>
		  	  		<input type="password" name="password_2" id="password_2" placeholder="Re-enter Password">
		  	  		<?php if ($password_error == true): ?>
		  	  			<p>Password does not match.</p>
		  	  		<?php endif ?>
		  		</div>
		  		<div>
		  	  		<button type="submit" name="new_user">Register</button>
		  		</div>
		  	</form>
		  	<?php if (isset($_SESSION['registersuccess'])): ?>
				<h4>
					<?php
						echo $_SESSION['registersuccess'];
						unset($_SESSION['registersuccess']);
					?>
				</h4>
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