<?php
	session_start();
	require_once('conn.php');
	require_once('utils.php');

	if (empty($_POST['content'])) {
		header("Location: index.php?errCode=1");
		die('資料不齊全');
	}
	$user = getUserFromUsername($_SESSION['username']);
	$username = $user['username'];
	$content = $_POST['content'];

	$sql_access = 
	'SELECT ' .
	'cannot_add_comment '.
	'FROM jean_users ' .
	'WHERE username=?';
	$stmt_access = $conn->prepare($sql_access);
  $stmt_access->bind_param('s', $username);
  $result = $stmt_access->execute();
  if (!$result) {
    die($conn->error);
  }
  $result = $stmt_access->get_result();
  $row = $result->fetch_assoc();
  $cannot_add_comment = $row['cannot_add_comment'];

  if (empty($cannot_add_comment)) {
	  $sql ="insert into jean_comments(username, content) values(?, ?)";
	  $stmt = $conn->prepare($sql);
	  $stmt->bind_param('ss', $username, $content);
	  $result = $stmt->execute();
	  if (!$result) {
	    die($conn->error);
	  }
	} else {
		header("Location: index.php?errCode=2");
		die();
	}
	header("Location: index.php");
?>