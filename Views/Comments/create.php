<?php
  require_once(ROOT_PATH .'Controllers/CommentController.php');
  session_start();

  if(!empty($_SESSION['text'])) {
    $comment = new CommentController();
    $comment->create();
    header("Location: /Outputs/view.php?id={$_SESSION['output_id']}");
  } else {
    header("Location: /Outputs/index.php");
  }

  unset($_SESSION['output_id']);
  unset($_SESSION['text']);
?>