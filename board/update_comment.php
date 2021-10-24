<?php
  session_start();
  // session_cache_limiter('private');
  require_once('conn.php');
  require_once('utils.php');

  $username = NULL;
  $user = NULL;
  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
  } 
  
  $id = $_GET['id'];

  $sql = "select * from jean_comments where id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);
  $result = $stmt->execute();
  if (!$result) {
    die('Error:' . $conn->error);
  }

  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
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
      <?php } ?>
    </div>
  <div class='board'>
    <div class='wrapper'>
    <h1>Comment</h1>
    <?php if ($username) { ?>
    <div class='board__input-row'>
      <span class='bg-color'>Hello! <?php echo escape($user['nickname']); ?></span>
      <a class='board__btn board__showEdit-btn'>edit</a>
      <form method='POST' class='board__new-nickname-form hide' action='handle_update_user.php'>
        <input type='text' name='update_comment' class='board__input board__intput-text'></input>
        <input type='submit' class='board__edit-btn' value='update' ></input>
      </form>
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
    <form class='board__new-comment-form' method='POST' action='handle_update_comment.php'>
      <div>
        <textarea name='content' rows='5' class='board__input board__input-textarea'><?php echo escape($row['content']); ?></textarea>
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
        <?php
        if (!empty($_GET['errCode'])) {
          $code = $_GET['errCode'];
          $err = 'Err!!!';
          if ($code === '1') {
            $msg = 'the information you entered is incompleted.';
          }
          echo '<h2 class="error">Error</h2>'; 
          echo '<h2 class="error">' . $msg . '</h2>';
        } ?>
        <input class='board__submit-btn' type='submit' value='Submit'></input>
      </div>
      <?php } else { ?>
        <h2 class='bg-color'>Please login to leave comment</h2>
      <?php } ?> 
      <div class='board__hr'></div>
    </form>
  </div>
  </div>
  </main>
  <script>
    document.querySelector('.board').addEventListener('click', (e) => {
      if (e.target.classList.contains('board__showEdit-btn')) {
        e.target.nextElementSibling.classList.toggle('hide');
      }
    })
  </script>
</body>
</html>