<?php
  require_once(ROOT_PATH .'Controllers/QuestionController.php');
  session_start();
 
  // ダイレクトアクセス禁止
  if (isset($_SESSION['question']) && !empty($_POST)) {
    $question = new QuestionController();
    $question->create();
    header('Location: index.php');
  } else {
    header('Location: new.php');
    exit();
  }

  unset($_SESSION['question']);
?>