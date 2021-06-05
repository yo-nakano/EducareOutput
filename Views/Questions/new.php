<?php
  session_start();

  function h($str) {
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
  }

  $errors = array();
  if (isset($_POST)) {
    // タイトル
    if(empty($_POST['title'])) {
      $errors['title'] = "タイトルは必須入力です。";
    } 
    // 目的
    if(empty($_POST['goal'])) {
      $errors['goal'] = "目的は必須入力です。";
    } 
    // 不明点
    if(empty($_POST['unknown'])) {
      $errors['unknown'] = "不明点は必須入力です。";
    } 
    // 試したこと
    if(empty($_POST['trial'])) {
      $errors['trial'] = "試したことは必須入力です。";
    } 
    if (count($errors) == 0) {
      $_SESSION['form'] = $_POST;
      header('Location: create_confirm.php');
      exit();
    }
  } else {
    if (isset($_SESSION['form'])) {
      $_POST = $_SESSION['form'];
    }
  }

  if(isset($_SESSION['question'])) {
    unset($_SESSION['question']);
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
          <input type="text" maxlength="200" placeholder="質問の内容が推測しやすいタイトル（200文字以内）" name="title" value="<?php if(isset($_POST['title'])) {echo h($_POST['title']);};?>"></input>
          <!-- 目的 -->
          <h3>目的</h3>
          <?php if(isset($_POST['goal'])):?>
            <?php if(empty($_POST['goal'])): ?>
              <div class="error-message"><?php echo $errors['goal']; ?></div>
            <?php endif; ?> 
          <?php endif; ?> 
          <textarea maxlength="1000" name="goal" placeholder="最終的に実現したい画面表示・機能など（1000文字以内）"><?php if(isset($_POST['goal'])) {echo h($_POST['goal']);};?></textarea>
          <!-- 不明点 -->
          <h3>不明点・不具合</h3>
          <?php if(isset($_POST['unknown'])):?>
            <?php if(empty($_POST['unknown'])): ?>
              <div class="error-message"><?php echo $errors['unknown']; ?></div>
            <?php endif; ?> 
          <?php endif; ?> 
          <textarea maxlength="1000" name="unknown" placeholder="どんな知識が足りてない、どんなエラーが表示されるかなど（1000文字以内）"><?php if(isset($_POST['unknown'])) {echo h($_POST['unknown']);};?></textarea>
          <!-- 試したこと -->
          <h3>試したこと・調べた内容</h3>
          <?php if(isset($_POST['trial'])):?>
            <?php if(empty($_POST['trial'])): ?>
              <div class="error-message"><?php echo $errors['trial']; ?></div>
            <?php endif; ?> 
          <?php endif; ?> 
          <textarea maxlength="1000" name="trial" placeholder="どんな意図や根拠を持ってどうアプローチをしたかなど（1000文字以内）"><?php if(isset($_POST['trial'])) {echo h($_POST['trial']);};?></textarea>
          <!-- 仮説 -->
          <h3>仮説（任意）</h3>
          <textarea maxlength="1000" name="hypothesis" placeholder="思い通りにいかない原因の予測、このまま自力で続ける場合に考えるアプローチなど（1000文字以内）"><?php if(isset($_POST['hypothesis'])) {echo h($_POST['hypothesis']);};?></textarea>
          <input type="submit" value="送 信" id="confirm_submit">
      </form>
      <p class="return"><a href="index.php">戻る</a></p>
    </div>
  </body>
</html>