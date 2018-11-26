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
	$programid = filter_input(INPUT_POST,'programid', FILTER_SANITIZE_NUMBER_INT);
	$commentid = filter_input(INPUT_POST,'commentid', FILTER_SANITIZE_NUMBER_INT);

	
	if ($_POST['command'] == 'Update') {
		$query = "UPDATE programcomments SET content = :content WHERE commentid = :commentid";	
		$updated = $db->prepare($query);	
		$updated->bindValue(':content',$content);
		$updated->bindValue(':commentid', $commentid, PDO::PARAM_INT);
		$updated->execute();

		header('Location: classes.php');
	}
	else {
		$_SESSION['comment_error'] = 'There was an error updating your comment';  
	}	
	
	if ($_POST['command'] == 'Delete') {
		$query = "DELETE FROM programcomments WHERE commentid = :commentid";
		$deleted = $db->prepare($query);
		$deleted->bindValue(':commentid', $commentid, PDO::PARAM_INT);
		$deleted->execute();

		header('Location: classes.php');
	}
	else {
		$_SESSION['comment_error'] = 'There was an error deleting your comment';
	}
	
	if ($_POST['command'] == 'Comment') {
		$query = "INSERT INTO programcomments (programid, content, username) VALUES (:programid, :content, :username)";
		$commented = $db->prepare($query);
		$commented->bindValue(':programid', $programid);
        $commented->bindValue(':content', $content);
        $commented->bindValue(':username', $username);
        $commented->execute();

        //header('Location: showprogram.php?programid=$programid');
	}
	else {
		$_SESSION['comment_error'] = 'There was an error submitting your comment';
	}		
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>hello</title>
</head>
<body>
	<p><?= $programid ?></p>
</body>
</html>
