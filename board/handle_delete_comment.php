<?php
	require_once('conn.php');
	require_once('utils.php');
	session_start();

	$admin = NULL;
	$admin_user = 'admin';

  	$id = $_GET['id'];
  	$username = $_SESSION['username'];
  	if ($username == $admin_user) {
		$admin = $admin_user;
	}

if ($username == $admin) { // 權限為 admin 時的工作
		$sql = "UPDATE jean_comments SET is_deleted=1 where id=?";
		$stmt = $conn->prepare($sql);	
		$stmt->bind_param('i', $id);
	} else { // 權限為一般使用者，需先從資料庫撈到該筆留言時 username 是否與登入的 username 相同
		$sql = "UPDATE jean_comments SET is_deleted=1 where id=? and username=?";
		$stmt = $conn->prepare($sql);	
		$stmt->bind_param('is', $id, $username);
	}
	$result = $stmt->execute();

	if (!$result) {
		die($conn->error);
	}
	
	header("Location: index.php");
?>