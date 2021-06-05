<?php
  session_start();

  function h($str) {
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
  }

  if (!isset($_SESSION['form'])) {
    header('Location: new.php');
    exit();
  } 

  $_SESSION['question'] = $_SESSION['form'];
  unset($_SESSION['form']);
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
      });
    </script>
  </head>
  <body>
    <?php include(ROOT_PATH .'Views/header.php') ?>
    <div class="box2">
      <h2>投稿内容確認</h2>
      <form method="post" action="create.php">
        <div class="confirm-info">
          <h3>タイトル</h3>
          <div class="post-info"><?= h($_SESSION['question']['title']) ?></div>
        </div>
        <div class="confirm-info">
          <h3>目的</h3>
          <div class="post-info"><?= h($_SESSION['question']['goal']) ?></div>
        </div>
        <div class="confirm-info">
          <h3>不明点</h3>
          <div class="post-info"><?= h($_SESSION['question']['unknown']) ?></div>
        </div>
        <div class="confirm-info">
          <h3>試したこと</h3>
          <div class="post-info"><?= h($_SESSION['question']['trial']) ?></div>
        </div>
        <div class="confirm-info">
          <h3>仮説</h3>
          <div class="post-info"><?= h($_SESSION['question']['hypothesis']) ?></div>
        </div>
        <input type="hidden" name="create-id" value="<?= h($_SESSION['question']['title']) ?>">
        <div id="action-button">
          <button type="button" id="return_submit" onclick="history.back()">訂 正</button>
          <button type="submit" id="exec_submit">投 稿</button>
        </div>
      </form>
    </div>
  </body>
</html>