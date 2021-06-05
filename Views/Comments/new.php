<?php
  session_start();
 
  function h($str) {
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
  }

  if(isset($_POST['output_id'])) {
    $_SESSION['output_id'] = $_POST['output_id'];
  }

  $errors = array();
  if (isset($_POST['text'])) {
    if(empty($_POST['text'])) {
      $errors['text'] = "コメント内容は必須入力です。";
    } 
    if (count($errors) == 0) {
      $_SESSION['text'] = $_POST['text'];
      header('Location: create.php');
      exit();
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
          <!-- テキスト -->
          <h3>コメント</h3>
          <?php if(isset($_POST['text'])):?>
            <?php if(empty($_POST['text'])): ?>
              <div class="error-message"><?php echo $errors['text']; ?></div>
            <?php endif; ?> 
          <?php endif; ?> 
          <textarea name="text"><?php if(isset($_POST['text'])) {echo h($_POST['text']);};?></textarea>
          <input type="submit" value="送 信" id="confirm_submit">
      </form>
      <p class="return"><a href="/Outputs/view.php?id=<?= $_SESSION['output_id'] ?>">戻る</a></p>
    </div>
  </body>
</html>