<?php
  require_once(ROOT_PATH .'Controllers/UserController.php');
  session_start();

  if(!empty($_SESSION['form'])) {
    $user = new UserController();
    $user->update();
    $_SESSION['user']['name'] = $_SESSION['form']['name'];
    header("Location: /Users/view.php?id={$_SESSION['id']}");
  } else {
    header("Location: /Outputs/index.php");
  }

  unset($_SESSION['id']);
  unset($_SESSION['form']);
?>