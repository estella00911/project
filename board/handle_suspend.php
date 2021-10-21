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

    $sql = "select * from jean_users where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    if (!$result) {
      die('Error:' . $conn->error);
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
	if ($username == $admin) { // 權限為 admin 時的工作
			$sql1 = "UPDATE jean_users SET cannot_add_comment = 1 where id=?"; // 1=true
			$sql2 = "UPDATE jean_users SET cannot_add_comment = 0 where id=?"; // 0=false
			$sql = $row['cannot_add_comment'] == 0 ? $sql1 : $sql2;
			$stmt = $conn->prepare($sql);	
			$stmt->bind_param('i', $id);
	} else { // 權限為一般使用者，需先從資料庫撈到該筆留言時 username 是否與登入的 username 相同
		header("Location: index.php");
	}
	$result = $stmt->execute();

	if (!$result) {
		die($conn->error);
	}
	// print_r($msg);
	// echo 'null:',$row['cannot_add_comment'];
	header("Location: index_admin.php");
?>