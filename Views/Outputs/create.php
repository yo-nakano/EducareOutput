<?php
  require_once(ROOT_PATH .'Controllers/OutputController.php');
  session_start();
 
  // ダイレクトアクセス禁止
  if (isset($_SESSION['output']) && !empty($_POST)) {
    $output = new OutputController();
    $output->create();
    header('Location: index.php');
  } else {
    header('Location: new.php');
    exit();
  }

  unset($_SESSION['output']);
?>