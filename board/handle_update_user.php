<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if (empty($_POST['new_nickname'])) {
  	header('Location: ./index.php?errCode2=2');
    die();
  }

  $new_nickname = $_POST['new_nickname'];
  $username = $_SESSION['username'];
  $sql = 'UPDATE jean_users SET nickname=? where username=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $new_nickname, $username);
  $result = $stmt->execute();
  if (!$result) {
  	die($conn->error);
  }
  header('Location: index.php');
?>