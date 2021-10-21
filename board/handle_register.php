<?php
  require_once('conn.php');
  session_start();
  if (
  	empty($_POST['nickname']) || 
  	empty($_POST['username']) ||
  	empty($_POST['password'])
	) {
  	header("Location: register.php?errCode=1");
  	die();
	}

  $nickname = $_POST['nickname'];
  $username = $_POST['username'];
  // $password = $_POST['password'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $sql =
  	"INSERT INTO jean_users(nickname, username, password) VALUES(?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss',  $nickname, $username, $password);
  $result = $stmt->execute();

  if(!$result) {
  	$errCode = $conn->errno;
  	if ($errCode === 1062) {
  		header("Location: register.php?errCode=2");
  		die();
  	}
  	echo $conn->error;
  	die();
  };
  
  $_SESSION['username'] = $username;
  header("Location: index.php");
?>




