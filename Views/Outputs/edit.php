<?php
  require_once(ROOT_PATH .'Controllers/OutputController.php');
  session_start();

  $output = new OutputController();
  $params = $output->view();

  if ($params['user_id'] != $_SESSION['user']['id']) {
    header('Location: index.php');
  }

  // XSS対策
  function h($str) {
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
  }

  $_SESSION['edit-id'] = $_GET['id'];

  // 入力バリデーション
  $errors = array();
  if (isset($_POST)) {
    // タイトル
    if(empty($_POST['title'])) {
      $errors['title'] = "タイトルは必須入力です。";
    } 
    // テキスト
    if(empty($_POST['text'])) {
      $errors['text'] = "アウトプット内容は必須入力です。";
    } 
    if (count($errors) == 0) {
      $_SESSION['form'] = $_POST;
      header('Location: update_confirm.php');
      exit();
    }
  } else {
    if (isset($_SESSION['form'])) {
      $_POST['form'] = $_SESSION['form'];
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
      });
    </script>
  </head>
  <body>
    <?php include(ROOT_PATH .'Views/header.php') ?>
    <div class="box1">
      <form method="post" action="">
          <!-- タイトル -->
          <h3>タイトル</h3>
          <?php if(isset($_POST['title'])):?>
            <?php if(empty($_POST['title'])): ?>
              <div class="error-message"><?php echo $errors['title']; ?></div>
            <?php endif; ?> 
          <?php endif; ?>   
          <input type="text" placeholder="投稿内容に基づくタイトル（200文字以内）" name="title" value="<?php if(isset($_POST['title'])) {echo h($_POST['title']);} else {echo h($params['title']);}; ?>"></input>
          <!-- テキスト -->
          <h3>アウトプット内容</h3>
          <?php if(isset($_POST['text'])):?>
            <?php if(empty($_POST['text'])): ?>
              <div class="error-message"><?php echo $errors['text']; ?></div>
            <?php endif; ?> 
          <?php endif; ?> 
          <textarea id="output-text" name="text"><?php if(isset($_POST['text'])) {echo h($_POST['text']);} else {echo h($params['text']);}; ?></textarea>
          <input type="submit" value="送 信" id="confirm_submit">
      </form>
      <p class="return"><a href="view.php?id=<?= $_GET['id'] ?>">戻る</a></p>
    </div>
  </body>
</html>