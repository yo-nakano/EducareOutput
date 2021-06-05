<?php
  require_once(ROOT_PATH .'Controllers/OutputController.php');
  session_start();
  
  // ダイレクトアクセス禁止
  if (isset($_SESSION['output']) && !empty($_POST)) {
    $output = new OutputController();
    $output->update();
    header("Location: view.php?={$_SESSION['edit-id']}");
  } else {
    header('Location: index.php');
    exit();
  }

  unset($_SESSION['output']);
?>