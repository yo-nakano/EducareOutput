<?php 
  require_once(ROOT_PATH .'Controllers/QuestionController.php');
  session_start();

  if (!empty($_POST['delete-id'])) {
    $question = new QuestionController();
    $params = $question->delete();
    header("Location: index.php");
  } else {
    header('Location: index.php');
    exit();
  }
  
?>