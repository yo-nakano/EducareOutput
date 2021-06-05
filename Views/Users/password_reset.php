<?php
  require_once(ROOT_PATH .'Controllers/UserController.php');
  $user = new UserController();

  $errors = [];
  if(isset($_POST)) {
    if(isset($_POST['email'])) {
      $user_info = $user->identify();
      if(empty($_POST['email'])) {
        $errors['email'] = "メールアドレスは必須入力です。正しくご入力ください。";
      } elseif(empty($user_info)) {
        $errors['email'] = "そのメールアドレスは登録されていません。";
      }
    }
    if(empty($_POST['password'])) {
      $errors['password'] = "パスワードは必須入力です。正しくご入力ください。";
    } elseif(!preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])) {
      $errors['password'] = "パスワードは半角英数字のみでご入力ください。";
    } 
    if(empty($_POST['password_conf'])) {
      $errors['password_conf'] = "パスワード(確認)は必須入力です。正しくご入力ください。";
    } elseif(isset($_POST['password'])) {
      if($_POST['password_conf'] !== $_POST['password']) {
        $errors['password_conf'] = "上で入力したパスワードと一致しません。";
      } 
    }
  
    if(count($errors) == 0) {
      $user->password_update();
      header('Location: login.php');
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
        <!-- メールアドレス・バリデーション -->
        <?php if(isset($_POST['email'])): ?>
          <?php $user_info = $user->identify(); ?>
          <?php if(empty($_POST['email']) || empty($user_info)): ?>
            <div class="user-error-msgs"><?= $errors['email']; ?></div>
          <?php endif; ?>
        <?php endif; ?>
        <!-- メールアドレス・入力フォーム -->
        <input type="text" placeholder="メールアドレス" name="email" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];} ?>"></input>
        <!-- パスワード・バリデーション -->
        <?php if(isset($_POST['password'])): ?>
          <?php if(empty($_POST['password']) || !preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])): ?>
            <div class="user-error-msgs"><?= $errors['password']; ?></div>
          <?php endif; ?>
        <?php endif; ?>
        <!-- パスワード・入力フォーム -->
        <input type="password" placeholder="パスワード" name="password" value="<?php if(isset($_POST['password'])) {echo $_POST['password'];} ?>"></input>
        <!-- 確認パスワード・バリデーション -->
        <?php if(isset($_POST['password_conf'])): ?>
          <?php if(empty($_POST['password_conf'])): ?>
            <div class="user-error-msgs"><?= $errors['password_conf']; ?></div>
          <?php endif; ?>
          <?php if(isset($_POST['password'])): ?>
            <?php if($_POST['password_conf'] !== $_POST['password']): ?>
              <div class="user-error-msgs"><?= $errors['password_conf']; ?></div>
            <?php endif; ?>
          <?php endif; ?>
        <?php endif; ?>
        <!-- 確認パスワード・入力フォーム -->
        <input type="password" placeholder="パスワード(確認)" name="password_conf" value="<?php if(isset($_POST['password_conf'])) {echo $_POST['password_conf'];} ?>"></input>
        <input type="submit" value="再設定" id="signup_submit-button"></input>
      </form>  
    </div>
    <div id="move_to_login">
      <a href="login.php">ログイン</a>
    </div>
    <div id="move_to_signup">
      <a href="signup.php">新規登録</a>
    </div>
  </body>
</html>