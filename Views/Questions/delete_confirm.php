<?php
  require_once(ROOT_PATH .'Controllers/QuestionController.php');
  session_start();
  
  $question = new QuestionController();
  $params = $question->view();  

  if ($params['user_id'] != $_SESSION['user']['id']) {
    if($_SESSION['user']['role'] == 0) {
       header('Location: index.php');
    }
  }
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

        $('#exec_submit').on('click', function() {
          if(confirm("この投稿を削除しますか？")) {
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
    <div class="box2">
      <h2>削除内容確認</h2>
      <form method="post" action="delete.php">
        <div class="confirm-info">
          <h3>タイトル</h3>
          <div class="post-info"><?= $params['title'] ?></div>
        </div>
        <div class="confirm-info">
          <h3>目的</h3>
          <div class="post-info"><?= $params['goal'] ?></div>
        </div>
        <div class="confirm-info">
          <h3>不明点</h3>
          <div class="post-info"><?= $params['unknown'] ?></div>
        </div>
        <div class="confirm-info">
          <h3>試したこと</h3>
          <div class="post-info"><?= $params['trial'] ?></div>
        </div>
        <div class="confirm-info">
          <h3>仮説</h3>
          <div class="post-info"><?= $params['hypothesis'] ?></div>
        </div>
        <input type="hidden" name="delete-id" value="<?= $params['id'] ?>">
        <div id="action-button">
          <button type="button" id="return_submit" onclick="history.back()">戻 る</button>
          <button type="submit" id="exec_submit">削 除</button>
        </div>
      </form>
    </div>
  </body>
</html>