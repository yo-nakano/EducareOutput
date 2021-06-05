<?php
  require_once(ROOT_PATH .'Controllers/AnswerController.php');
  session_start();

  if(!empty($_SESSION['text'])) {
    $answer = new AnswerController();
    $answer->update();
    header("Location: /Questions/view.php?id={$_SESSION['question_id']}");
  } else {
    header("Location: /Questions/index.php");
  }

  unset($_SESSION['id']);
  unset($_SESSION['output_id']);
  unset($_SESSION['text']);
?>