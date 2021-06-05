<?php 
  require_once(ROOT_PATH .'Controllers/UserController.php');
  session_start();

  $user = new UserController();
  $user->delete();
  if($_SESSION['user']['role'] == 0) {
    header("Location: logout.php");
  }
  if($_SESSION['user']['role'] == 1) {
    header("Location: index.php");
  }
  exit();
?>