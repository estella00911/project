<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  $admin = NULL;
  $admin_status = 'admin';
  $username = NULL;
  $user = NULL;
  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
    if ($username == $admin_status) {  // 若為管理員，就有權利編輯、刪除所有人的留言
      $admin = $admin_status;
    } else {
      header("Location: index.php");
    }
  } else {
    header("Location: index.php");
  }

  $page = NULL;
    if (empty($_GET['page']) == 1) {
    $page = 1;
  } else {
    $page = $_GET['page'];
  }
  $limit_per_page = 5;
  $offset = ($page - 1) * $limit_per_page;
  $sql ='SELECT * FROM jean_users ORDER BY id DESC';
  $stmt = $conn->prepare($sql);
  // $stmt->bind_param('ii', $limit_per_page, $offset);
  $result = $stmt->execute();
  if (!$result) {
    die('Error:' . $conn->error);
  }
  $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Jean's Board</title>
  <link rel="stylesheet" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&family=Roboto+Slab:wght@500&display=swap" rel="stylesheet">

</head>

<body>
  <div class='warning'>
    <strong><header>注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</header></strong>
  </div>
  <main>
    <div class='board__navbar'>
      <?php if (!$username) { ?> 
      <a class='board__btn' href="register.php">Register</a>
      <a class='board__btn' href="login.php">Login</a>
      <?php } else { ?>
      <a class='board__btn' href="logout.php">Logout</a>
      <a class='board__btn' href="index.php">Back to Board</a>
      <?php } ?>
    </div>
  <div class='board admin__board'>
    <div class='wrapper admin__wrapper'>
    <h1>Backstage Management</h1>
    <!-- <div class='admin__btn-panel'>
      <div class='admin__btn'>All Users</div>
      <div class='admin__btn'>All Comments</div>
    </div> -->
  </div>
    <section>
      <div class='board__hr'></div>
      <h2>All Users</h2>
      <div class='wrapper'>
       <table class='tb__users'>
          <!-- <caption>All Users</caption> -->
          <thead>
            <tr>
              <th>id</th>
              <th>username</th>
              <th>nickname</th>
              <th>user status</th>
              <th><span class='board__title'>permission to </span><span class='board__title'>leave message</span><th>
            </tr>
          </thead>
          <tbody>
            <?php 
              while($row = $result->fetch_assoc()) {
            ?>
            <tr data-title="<?php echo escape($row['id']); ?>">
              <td><?php echo escape($row['id']); ?></td>
              <td><?php echo escape($row['username']); ?></td>
              <td><?php echo escape($row['nickname']); ?></td>
              <td><?php echo escape($row['status']); ?></td>
              <!-- original: 0 false  -> 可以留言-->
              <?php if (!$row['cannot_add_comment']) { ?>
              <td><a class='board__edit-btn' href='handle_suspend.php?id=<?php echo escape($row['id'])?>'>suspend</a></td>
              <!-- original: 1 true=  「不能留言」要改成「可以留言」 -->
              <?php } else { ?>　
              <td><a class='board__edit-btn' href='handle_message_permission.php?id=<?php echo escape($row['id'])?>'>allow</a></td>
              <?php } ?>
            </tr>
            <?php } ?>
          </tbody>  
        </table>

      </div>
    </section>

</body>
</thml>
