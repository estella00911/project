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
    }
  }

  if ($username == $admin_status) {
    $stmt = $conn->prepare('SELECT * from jean_users where status = ?');
    $stmt->bind_param('s', $admin_status);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
      die('Error:' . $conn->error);
    }
    if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $admin = $row['status'];
    }
  }

  $page = NULL;
    if (empty($_GET['page']) == 1) {
    $page = 1;
  } else {
    $page = $_GET['page'];
  }
  $limit_per_page = 5;
  $offset = ($page - 1) * $limit_per_page;

  $sql =
    'SELECT '.
      'C.id as id, '.
      'C.content as content, '.
      'C.created_at as created_at, '.
      'C.is_deleted as is_deleted, '.
      'U.nickname as nickname, '.
      'U.username as username '.
    'FROM jean_comments as C '.
    'LEFT JOIN '.
    'jean_users as U '.
    'ON C.username = U.username '.
    'WHERE is_deleted is NULL '.
    'ORDER BY C.id DESC '.
    'limit ? offset ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ii', $limit_per_page, $offset);
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
    <strong><header>注意！本站為練習用網站，註冊時請勿使用任何真實的帳號或密碼。</header></strong>
  </div>
  <main>
    <div class='board__navbar'>
      <?php if (!$username) { ?> 
      <a class='board__btn' href="register.php">Register</a>
      <a class='board__btn' href="login.php">Login</a>
      <?php } else { ?>
      <a class='board__btn' href="logout.php">Logout</a>
      <?php if ($username == $admin) { ?>
          <a class='board__btn' href="index_admin.php">Backstage Management</a>
        <?php } ?>
      <?php } ?>
    </div>
  <div class='board'>
    <div class='wrapper'>
    <h1>Comment</h1>
    <?php if ($username) { ?>
    <div class='board__input-row'>
      <span class='bg-color'>Hello! <?php echo escape($user['nickname']); ?></span>
      <a class='board__btn board__showEdit-btn'>edit</a>
      <div>
        <form method='POST' class='board__new-nickname-form hide' action='handle_update_user.php'>
          <input type='text' name='new_nickname' class='board__input board__intput-text' placeholder="input new nickname"></input>
          <input type='submit' class='board__edit-btn' value='update' ></input>
        </form>
      </div>
    </div>
      <?php
        if (!empty($_GET['errCode2'])) {
          $code = $_GET['errCode2'];
          $err = 'Err!!!';
          if ($code === '2') {
            $msg = 'the information you entered is incompleted.';
          }
          echo '<h2 class="error">Error</h2>'; 
          echo '<h2 class="error">' . $msg . '</h2>';
      } ?>
    <form class='board__new-comment-form' method='POST' action='handle_add_comment.php'>
      <div>
        <textarea name='content' rows='5' class='board__input board__input-textarea'></textarea>
        <?php
        if (!empty($_GET['errCode'])) {
          $code = $_GET['errCode'];
          $err = 'Err!!!';
          if ($code === '1') {
            $msg = 'the information you entered is incompleted.';
          } else if ($code === '2') {
            $msg = 'you are not allowed to leave a comment.';
          }
          echo '<h2 class="error">Error</h2>'; 
          echo '<h2 class="error">' . $msg . '</h2>';
        } ?>
        <input class='board__submit-btn' type='submit' value='Submit'></input>
      </div>
      <?php } else { ?>
        <h2 class='bg-color'>Please login to leave comment</h2>
      <?php } ?> 
    </form>
  </div>
    <section>
      <div class='board__hr'></div>
      <div class='wrapper'>
        <?php 
          while($row = $result->fetch_assoc()) {
        ?>
        <!-- <div class='card'> -->
        <div class='card'>
          <div class='card__avatar'></div>
          <div class='card__body'>
            <span class='card__author'><?php echo escape($row['nickname']); ?>(@ <?php echo escape($row['username']); ?>)</span>
            <span class='card__time'><?php echo escape($row['created_at']);?></span>
              <?php if($row['username'] == $username OR $admin) { ?> 
              <!-- 若是 username 本人或管理員，就可以編輯刪除留言 -->
              <div>
              <a class='card__btn' href='update_comment.php?id=<?php echo escape($row['id'])?>'>Edit</a>
              <a class='card__btn' href='handle_delete_comment.php?id=<?php echo escape($row['id'])?>'>Delete</a>
            </div>
            <?php } ?>
            <p class='card__content'><?php echo escape($row['content']); ?></p>
          </div>
        </div>
      <?php } ?>
      </div>
    </section>
      <div class='board__hr pagi__hr-style'></div>
      <?php
        $sql_page =
          'SELECT ' .
          'count(id) as count ' .
          'FROM jean_comments '.
          'WHERE is_deleted is NULL';
        $stmt = $conn->prepare($sql_page);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $total_comments = $row['count'];
        $total_page = ceil($total_comments / $limit_per_page);
      ?>
      <section class='section__pagination'>
        <div class='pagi__btns'>
          <?php if($page != 1) { ?>
          <a class='pagi__btn-leftArrow pagi__btn-first hidden' href='index.php'>
            <div class='pagi__img-leftArrow'></div><span>first</span>
          </a>
          <a class='pagi__btn-leftArrow' href='index.php?page=<?php echo $page-1; ?>'>
            <div class='pagi__img-leftArrow'></div><span>previous</span>
          </a>
        <?php } ?>
        <?php if ($page != $total_page) { ?>
          <a class='pagi__btn-rightArrow' href='index.php?page=<?php echo $page+1; ?>'>
            <div class='pagi__img-rightArrow'></div><span>next</span>
          </a>
          <a class='pagi__btn-rightArrow pagi__btn-last hidden' href='index.php?page=<?php echo $total_page; ?>'>
            <div class='pagi__img-rightArrow'></div><span>last</span>
          </a>
        <?php } ?>
        </div>
        <div class='pagi__info'>共有 <?php echo $total_comments; ?> 筆留言，頁數<?php echo ' ' . $page . ' / ' . $total_page; ?></div>
  </div>
  </main>
  <script>
    document.querySelector('.board').addEventListener('click', (e) => {
      if (e.target.classList.contains('board__showEdit-btn')) {
        e.target.nextElementSibling.firstChild.nextElementSibling.classList.toggle('hide');
      }
    })
  </script>
</body>
</html>