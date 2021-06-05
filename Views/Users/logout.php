<?php
  require_once(ROOT_PATH .'Controllers/UserController.php');
  session_start();
  //セッションの中身をすべて削除
  $_SESSION['user'] = [];
  //セッションを破壊  
  session_destroy();
  header('Location: login.php');
?> 