<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');


  if(
  	empty($_POST['username']) ||
  	empty($_POST['password'])
  ) {
  	header("Location: login.php?errCode=1");  // show err: incomplete input
  	die();
  }
  

  $username = $_POST['username'];
 
  // get hash password
  $sql ='SELECT password FROM jean_users where username = ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $username);
  $result = $stmt->execute();
  if (!$result) {
    echo $conn->error;
    die();
  }

  $result = $stmt->get_result();
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($_POST['password'], $row['password'])) {
      $_SESSION['username'] = $username;
      header("Location: index.php");
      die();
    } else {
    	header("Location: login.php?errCode=2");
      die();
    }
  } else {
    header("Location: login.php?errCode=3");
    die();
  }
?>
