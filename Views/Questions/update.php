<?php
  require_once(ROOT_PATH .'Controllers/QuestionController.php');
  session_start();
  
  // ダイレクトアクセス禁止
  if (isset($_SESSION['question']) && !empty($_POST)) {
    $question = new QuestionController();
    $question->update();
    header("Location: view.php?={$_SESSION['edit-id']}");
  } else {
    header('Location: index.php');
    exit();
  }

  unset($_SESSION['question']);
?>