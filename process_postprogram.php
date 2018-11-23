<?php
	session_start();
	require('connect.php');

	// If logout is clicked, logs the user out.
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header('Location: index.php');
	}

	$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$user = ($_SESSION['user']);
	$username = $user['username'];

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
		else if ($_POST['command']=='Comment')
		{
			$query = "INSERT INTO program comments (content, username) VALUES (:content, :username)";
			$statement = $db->prepare($query);
        	$statement->bindValue(':content',$content);
        	$statement->bindValue(':username',$username);
		}

	    if ($statement->execute()) {
	 	    header('Location: programs.php');   
	  	}
	}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
</body>
</html>
