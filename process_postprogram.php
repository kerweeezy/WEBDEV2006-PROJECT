<?php
	session_start();
	require('connect.php');

	// If logout is clicked, logs the user out.
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header('Location: index.php');
	}

	$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$user = ($_SESSION['username']);
	$username = $user['username'];
	$error_string = false;

	if ($_POST && !empty($content)) {
		$commentid = filter_input(INPUT_POST,'commentid', FILTER_SANITIZE_NUMBER_INT);
		
		if ($_POST['command']=='Update')
		{
			$query = "UPDATE program comments SET content = :content WHERE commentid=:commentid";
			$statement = $db->prepare($query);
		    $statement->bindValue(':content',$content);
		    $statement->bindValue(':commentid', $commentid, PDO::PARAM_INT);
		}
		else if ($_POST['command']=='Delete')
		{
			$query = "DELETE FROM program comments WHERE commentid = :commentid";
			$statement = $db->prepare($query);
			$statement->bindValue(':commentid', $commentid, PDO::PARAM_INT);
		}
		else
		{
			$query = "INSERT INTO program comments (content) VALUES (:content)";
			$statement = $db->prepare($query);
        	$statement->bindValue(':content',$content);
		}
	    if ($statement->execute()) {
	 	    header('Location: index.php');   
	  	}
	    exit;
	}
	else {
		$error_string=true;
	}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Error</title>
    <link rel="stylesheet" href="http://stungeye.com/school/blog/style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php"></a></h1>
        </div>

        <?php if ($error_string): ?>
			<h1>An error occured while processing your post.</h1>
		  	<p>Both the title and content must be at least one character.  </p>
			<a href="index.php">Return Home</a>
		<?php endif ?>

		<div id="footer">
	        Something about legal stuff
	  	</div> 
    </div>
</body>
</html>
