<?php
  require_once(ROOT_PATH .'Controllers/UserController.php');
  $user = new UserController();

  $errors = [];
  if(isset($_POST)) {
    if(empty($_POST['email'])) {
      $errors['email'] = "メールアドレスは必須入力です。正しくご入力ください。";
    } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "メールアドレスは正しくご入力ください。";
    }
    // パスワードのチェック
    if(empty($_POST['password'])) {
      $errors['password'] = "パスワードは必須入力です。正しくご入力ください。";
    } elseif(!preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])) {
      $errors['password'] = "パスワードは半角英数字のみでご入力ください。";
    }
    // エラーが無ければ、一覧ページに遷移
    if(count($errors) == 0) {
      $params = $user->login();
      if(!empty($params['user'])) {
        session_start();
        $_SESSION['user'] = $params['user'];
        if($_SESSION['user']['role'] == 0) {
          header('Location: /Outputs/index.php');
          exit();
        }
        if($_SESSION['user']['role'] == 1) {
          header('Location: /Users/mg_index.php');
          exit();
        }
      } else {
        $message = "メールアドレスまたはパスワードが一致しません";
      }
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
    <p class="failed-msg"><?php if(isset($message)) {echo $message;} ?></p>
    <div id="login-box">
      <form method="post" action="">
          <?php if(isset($_POST['email'])): ?>
            <?php if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)): ?>
              <div class="user-error-msgs"><?= $errors['email']; ?></div>
            <?php endif; ?>
          <?php endif; ?>
          <input type="text" placeholder="メールアドレス" name="email"></input>
          <?php if(isset($_POST['password'])): ?>
            <?php if(empty($_POST['password']) || !preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])): ?>
              <div class="user-error-msgs"><?= $errors['password']; ?></div>
            <?php endif; ?>
          <?php endif; ?>
          <input type="password" placeholder="パスワード" name="password"></input>
          <input type="submit" value="ログイン" id="login_submit-button"></input>
      </form>  
    </div>
    <div id="move_to_signup">
      <a href="signup.php">新規登録</a>
    </div>
    <div id="move_to_signup">
      <a href="password_reset.php">パスワード再設定</a>
    </div>
  </body>
</html>