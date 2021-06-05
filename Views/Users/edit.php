<?php
  require_once(ROOT_PATH .'Controllers/UserController.php');
  $user = new UserController();
  $user_params = $user->get();
  $user_info = $user->view();

  session_start();
  $_SESSION['id'] = $_GET['id'];

  $errors = [];
  
  if(!empty($_POST)) {
    // ユーザー名のチェック
    if(isset($_POST['name'])) {
      if(empty($_POST['name'])) {
        $errors['name'] = "ユーザー名は必須入力です。";
      }
    }  
    // メールアドレスのチェック
    if(isset($_POST['email'])) {
      if(empty($_POST['email'])) {
        $errors['email'] = "メールアドレスは必須入力です。正しくご入力ください。";
      } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "メールアドレスは正しくご入力ください。";
      } 
      foreach($user_params['users'] as $user) {
        if($user['id'] !== $_GET['id']) {
          if($_POST['email'] == $user['email']) {
            $errors['email'] = "既に登録されてるメールアドレスです。";
          }
        }
      }
    }
    if(count($errors) == 0) {
      $_SESSION['form'] = $_POST;
      header('Location: update.php');
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
    </script>
  </head>
  <body>
    <?php include(ROOT_PATH .'Views/header2.php') ?>
    <div id="signup-box">
      <form method="post" action="">
        <!-- ユーザー名・バリデーション -->
        <?php if(isset($_POST['name'])): ?>
          <?php if(empty($_POST['name'])): ?>
            <div class="user-error-msgs"><?= $errors['name']; ?></div>
          <?php endif; ?> 
        <?php endif; ?>
        <!-- ユーザー名・入力フォーム -->
        <input type="text" placeholder="ユーザー名" name="name" value="<?php if(isset($_POST['name'])) {echo $_POST['name'];} else {echo $user_info['name'];} ?>"></input>
        <!-- メールアドレス・バリデーション -->
        <?php if(isset($_POST['email'])): ?>
          <?php if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)): ?>
            <div class="user-error-msgs"><?= $errors['email']; ?></div>
          <?php endif; ?>
          <?php foreach($user_params['users'] as $user): ?>
            <?php if($_GET['id'] !== $user['id']): ?>
              <?php if($_POST['email'] == $user['email']): ?>
                <div class="user-error-msgs"><?= $errors['email']; ?></div>
              <?php endif; ?>
            <?php endif; ?>  
          <?php endforeach; ?>  
        <?php endif; ?>
        <!-- メールアドレス・入力フォーム -->
        <input type="text" placeholder="メールアドレス" name="email" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];} else {echo $user_info['email'];} ?>"></input>
        <input type="submit" value="更 新" id="signup_submit-button"></input>
      </form>  
    </div>
    <div id="move_to_login"> 
      <a href="view.php?id=<?= $_SESSION['id'] ?>">戻る</a>
    </div>
  </body>
</html>