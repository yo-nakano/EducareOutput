<?php 
  require_once(ROOT_PATH .'Controllers/UserController.php');
  require_once(ROOT_PATH .'Controllers/OutputController.php');
  require_once(ROOT_PATH .'Controllers/QuestionController.php');

  session_start();
  
  $user = new UserController();
  $user_info = $user->view();

  $output = new OutputController();
  $output_params = $output->user_index();
  $favorite_params = $output->favorite_index();

  $question = new QuestionController();
  $question_params = $question->user_index();
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
        $('#account_delete').on('click', function() {
          if(confirm("このアカウントを削除します。削除後は元には戻せません。本当によろしいですか？")) {
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
    <?php if($_GET['id'] == $_SESSION['user']['id'] || $_SESSION['user']['role'] == 1): ?>
      <div class="user_view_contents">
        <h3>アカウント情報</h3>
        <div class="user_info">
          <h4><span>ユーザー名　　　　　</span><?= $user_info['name']; ?></h4>
          <h4><span>メールアドレス　　　</span><?= $user_info['email']; ?></h4>
        </div>  
        <div class="edit_delete">
          <?php if($_GET['id'] == $_SESSION['user']['id']): ?>
          <form method="get" action="edit.php">
            <input type="hidden" name="id" value="<?= $user_info['id'] ?>">
            <input type="submit" value="編集">
          </form>
          <?php endif; ?>
          <form method="post" action="delete.php">
            <input type="hidden" name="id" value="<?= $user_info['id'] ?>">
            <input type="submit" id="account_delete" value="削除">
          </form>
        </div>
      </div>
    <?php endif; ?>

    <?php if(!empty($output_params)): ?>
      <div class="contents-head">
        <h2><span><?= $user_info['name'] ?></span> が投稿したアウトプット</h2>
      </div>
      <div class="contents-body">
        <?php if(!empty($output_params)): ?>
          <?php foreach($output_params as $output): ?>
            <div id="created-list">
              <form action="/Outputs/view.php" method="get" id="title">
                <input type="hidden" name="id" value="<?= $output['id'] ?>">
                <input type="submit" value="<?= $output['title'] ?>">
              </form>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if(!empty($favorite_params)): ?>
      <div class="contents-head">
        <h2><span><?= $user_info['name'] ?></span> がお気に入り登録したアウトプット</h2>
      </div>
      <div class="contents-body">
        <?php if(!empty($favorite_params)): ?>
          <?php foreach($favorite_params as $favorite_output): ?>
            <div id="created-list">
              <form action="/Outputs/view.php" method="get" id="title">
                <input type="hidden" name="id" value="<?= $favorite_output['output_id'] ?>">
                <input type="submit" value="<?= $favorite_output['title'] ?>">
              </form>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>  

    <?php if(!empty($question_params)): ?>
      <div class="contents-head">
        <h2><span><?= $user_info['name'] ?></span> が投稿した質問</h2>
      </div>
      <div class="contents-body">
        <?php foreach($question_params as $question): ?>
          <div id="created-list">
            <form action="/Questions/view.php" method="get" id="title">
              <input type="hidden" name="id" value="<?= $question['id'] ?>">
              <input type="submit" value="<?= $question['title'] ?>">
            </form>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </body>
</html>