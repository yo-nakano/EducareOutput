<?php 
  require_once(ROOT_PATH .'Controllers/OutputController.php');
  session_start();

  if (!empty($_POST['delete-id'])) {
    $output = new OutputController();
    $params = $output->delete();
    header("Location: index.php");
  } else {
    header('Location: index.php');
    exit();
  }
  
?>