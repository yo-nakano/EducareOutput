<?php
  require_once(ROOT_PATH .'Controllers/UserController.php');
  $user = new UserController();
  $all_params = $user->get();

  $errors = [];
  if(isset($_POST)) {
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
      foreach($all_params['users'] as $user) {
        if($_POST['email'] == $user['email']) {
          $errors['email'] = "既に登録されてるメールアドレスです。";
        }
      }
    }
    // パスワードのチェック
    if(empty($_POST['password'])) {
      $errors['password'] = "パスワードは必須入力です。正しくご入力ください。";
    } elseif(!preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])) {
      $errors['password'] = "パスワードは半角英数字のみでご入力ください。";
    } 
    // エラーが無ければ登録データでそのままログインし、一覧ページに遷移
    if(count($errors) == 0) {
      $user = new UserController();
      $user->register();
      $params = $user->login();
      if(!empty($params['user'])) {
        session_start();
        $_SESSION['user'] = $params['user'];
        header('Location: /Outputs/index.php');
        exit();
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
    <div id="signup-box">
      <form method="post" action="">
        <!-- ユーザー名・バリデーション -->
        <?php if(isset($_POST['name'])): ?>
          <?php if(empty($_POST['name'])): ?>
            <div class="user-error-msgs"><?= $errors['name']; ?></div>
          <?php endif; ?> 
        <?php endif; ?>
        <!-- ユーザー名・入力フォーム -->
        <input type="text" maxlength="10" placeholder="ユーザー名（10文字以内）" id="name" name="name" value="<?php if(isset($_POST['name'])) {echo $_POST['name'];} ?>"></input>
        <!-- メールアドレス・バリデーション -->
        <?php if(isset($_POST['email'])): ?>
          <?php if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)): ?>
            <div class="user-error-msgs"><?= $errors['email']; ?></div>
          <?php endif; ?>
          <?php foreach($all_params['users'] as $user): ?>
            <?php if($_POST['email'] == $user['email']): ?>
              <div class="user-error-msgs"><?= $errors['email']; ?></div>
            <?php endif; ?>
          <?php endforeach; ?>  
        <?php endif; ?>
        <!-- メールアドレス・入力フォーム -->
        <input type="text" placeholder="メールアドレス" id="email" name="email" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];} ?>"></input>
        <!-- パスワード・バリデーション -->
        <?php if(isset($_POST['password'])): ?>
          <?php if(empty($_POST['password']) || !preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])): ?>
            <div class="user-error-msgs"><?= $errors['password']; ?></div>
          <?php endif; ?>
        <?php endif; ?>
        <!-- パスワード・入力フォーム -->
        <input type="password" placeholder="パスワード" id="password" name="password" value="<?php if(isset($_POST['password'])) {echo $_POST['password'];} ?>"></input>
        <input type="submit" value="新規登録" id="signup_submit-button"></input>
      </form>  
    </div>
    <div id="move_to_login">
      <a href="login.php">ログイン</a>
    </div>
  </body>
</html>