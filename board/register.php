<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>我自己的留言板</title>
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
    <a class='board__btn' href="login.php">Login</a>
    <a class='board__btn' href="index.php">Back to Board</a>
  </div>
  <div class='board board__register-height'>
    <div class='wrapper'>
    <form class='board__new-comment-form board__login-css' method='POST' action='handle_register.php'>
      <h1 class='board__anchor'>Register</h1>
      <div class='board__input-area'>
        <div class='board__row board__register'>
          <span>Nickname:</span>
          <input type='text' name='nickname' class='board__input board__intput-text'></input>
        </div>
        <div class='board__row board__register'>
          <span>Username:</span>
          <input type='text' name='username' class='board__input board__intput-text'></input>
        </div>
        <div class='board__row board__register'>
          <span>Password:</span>
          <input type='password' name='password' class='board__input board__intput-text'></input>
        </div>
        </div>
        <?php
        if (!empty($_GET['errCode'])) {
          $code = $_GET['errCode'];
          $err = 'Err!!!';
          if ($code === '1') {
            $msg = 'Sign up Not Completed';
          } else if($code === '2') {
            $msg = 'The username already exists.<br>Please use a different username.';
          }
          echo '<h2 class="error">Error</h2>';
          echo '<h2 class="error">' . $msg . '</h2>';
        }
      ?>
        <input class='board__register-btn board__submit-btn' type='submit' value='Sign Up'></input>

    </form>
  </main>
</body>
</html>