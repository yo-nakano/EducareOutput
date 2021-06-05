<?php
  require_once(ROOT_PATH .'Controllers/QuestionController.php');
  require_once(ROOT_PATH .'Controllers/AnswerController.php');

  session_start();

  if(!isset($_GET['id']) && isset($_SESSION['edit-id'])) {
    $_GET['id'] = $_SESSION['edit-id'];
    unset($_SESSION['edit-id']);
  }

  $question = new QuestionController();
  $params = $question->view();

  $answer = new AnswerController();
  $answer_params = $answer->index();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>educare output</title>
    <link rel="stylesheet" type="text/css" href="/css/base.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
      $(function(){
        $(window).on('load, scroll', function() {
          // スクロールによるヘッダーの固定、背景変化
          if($('#header').css('position','relative')){
            var position = $('#header').offset().top;
          };
          if($(window).scrollTop() > position) {
            $('#header').css({'position':'fixed'});
          } else {
            $('#header').css({'position':'relative'});
          };
        }); 
        $('.comment_delete').on('click', function() {
          if(confirm("この回答を削除しますか？")) {
            return true;
          } else {
            return false;
          }
        });
      });
    </script>
  </head>
  <body>
    <?php include(ROOT_PATH .'Views/header.php') ?>
    <div class="view_contents">
      <form action="/Users/view.php" id="user_name">
        <input type="hidden" name="id" value="<?= $params['user_id'] ?>">
        <input type="submit" id="view_user_name" value="<?= $params['user_name'] ?>">
      </form>
      <div id="question_view_title">
        <h2><?= $params['title']; ?></h2>
      </div>
      <div>
        <h4>目的</h4>
        <div id="view_text"><?= $params['goal']; ?></div>
      </div>
      <div>
        <h4>不明点</h4>
        <div id="view_text"><?= $params['unknown']; ?></div>
      </div>
      <div>
        <h4>試したこと</h4>
        <div id="view_text"><?= $params['trial']; ?></div>
      </div>
      <?php if(!empty($params['hypothesis'])): ?>
      <div>
        <h4>仮説</h4>
        <div id="view_text"><?= $params['hypothesis']; ?></div>
      </div>
      <?php endif; ?>

      <?php if($params['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['role'] == 1): ?>
        <div class="edit_delete">
        <?php if($params['user_id'] == $_SESSION['user']['id']): ?>
          <form method="get" action="edit.php">
            <input type="hidden" name="id" value="<?= $params['id'] ?>">
            <input type="submit" value="編集">
          </form>
        <?php endif; ?>  
          <form method="get" action="delete_confirm.php">
            <input type="hidden" name="id" value="<?= $params['id'] ?>">
            <input type="submit" value="削除">
          </form>
        </div>
      <?php endif; ?>

    </div>
    <div class="view_contents">
      <h3>回答 (コメント)</h3>
      <?php foreach($answer_params as $answer): ?>
        <div class="comments">
          <form action="/Users/view.php" method="get">
            <input type="hidden" name="id" value="<?= $answer['user_id'] ?>">
            <input type="submit" id="view_user_name" value="<?= $answer['user_name'] ?>">
          </form>
          <div class="comment"><?= $answer['text'] ?></div>
          <?php if($answer['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['role'] == 1): ?>
            <div class="comment-edit_delete">
            <?php if($answer['user_id'] == $_SESSION['user']['id']): ?>
              <form method="get" action="/Answers/edit.php">
                <input type="hidden" name="id" value="<?= $answer['id'] ?>">
                <input type="submit" value="編集">
              </form>
            <?php endif; ?>
              <form method="post" action="/Answers/delete.php">
                <input type="hidden" name="id" value="<?= $answer['id'] ?>">
                <input type="submit" class="comment_delete" value="削除">
              </form>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
      <form method="post" action="/Answers/new.php">
        <input type="hidden" name="question_id" value="<?= $params['id']; ?>">
        <input type="submit" class="comment_create" value="回答する">
      </form> 
    </div>
  </body>
</html>