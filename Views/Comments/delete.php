<?php 
  require_once(ROOT_PATH .'Controllers/CommentController.php');
  session_start();

if(empty($_POST['id'])) {
  header("Location: /Outputs/index.php");
} else {
  $comment = new CommentController();
  $params = $comment->view();
  $comment->delete();
  header("Location: /Outputs/view.php?id={$params['output_id']}");
  exit();
}
?>