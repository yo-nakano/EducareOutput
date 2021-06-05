<?php 
  require_once(ROOT_PATH .'Controllers/AnswerController.php');
  session_start();

  if(empty($_POST['id'])) {
    header("Location: /Questions/index.php");
  } else {
    $answer = new AnswerController();
    $params = $answer->view();
    $answer->delete();
    header("Location: /Questions/view.php?id={$params['question_id']}");
    exit();
  }
?>