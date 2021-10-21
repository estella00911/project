<?php
  require_once('conn.php');

  function generateToken() {
    $s = '';
    for($i=1; $i<=16; $i ++) {
      $s .= chr(rand(65,90));
    }
    return $s;
  }

  function getUserFromToken($token) {
  	global $conn;
    $username_sql = sprintf(
      "SELECT username FROM jean_tokens WHERE token = '%s'",
      $token
    );
    $username_result = $conn->query($username_sql);
    $username_row = $username_result->fetch_assoc();
    $username = $username_row['username'];

    $userInfo_sql = sprintf(
      "SELECT * FROM jean_users WHERE username = '%s'",
      $username
    );
    $userInfo_result = $conn->query($userInfo_sql);
    $userInfo_row = $userInfo_result->fetch_assoc();
    return $userInfo_row;
  };

  function getUserFromUsername($username) {
    global $conn;
    $userInfo_sql = sprintf(
      "SELECT * FROM jean_users WHERE username = '%s'",
      $username
    );
    $userInfo_result = $conn->query($userInfo_sql);
    $userInfo_row = $userInfo_result->fetch_assoc();
    return $userInfo_row;
  };

  function escape($string) {
    return htmlspecialchars($string);
  }
?>