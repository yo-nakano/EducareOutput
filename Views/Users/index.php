<?php 
  require_once(ROOT_PATH .'Controllers/UserController.php');
  session_start();

  if($_SESSION['user']['role'] == 0) {
    header("Location: /Outputs/index.php");
  }
  
  $user = new UserController();
  $params = $user->get();
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
        $('.mg_delete_button').on('click', function() {
          if(confirm("このアカウントを削除します。削除後は元には戻せません。本当によろしいですか？")) {
            return true;
          } else {
            return false;
          }
        });
      });
    </script>
  </head>
  <body class="mg_body">
    <?php include(ROOT_PATH .'Views/header.php') ?>
    <div class="mg_index">
      <h2>ユーザー一覧</h2>
      <table>
        <tr>
          <th>名前</th>
          <th>メールアドレス</th>
          <th>&nbsp;</th>
          <!-- <th>&nbsp;</th> -->
        </tr>
        <?php foreach($params['users'] as $user): ?>
        <tr>
          <td><?= $user['name']; ?></td>
          <td><?= $user['email']; ?></td>
          <td class="mg">
            <form action="view.php" method="get">
              <input type="hidden" name="id" value="<?= $user['id']; ?>">
              <input type="submit" value="詳細" class="mg_button">
            </form>
            <form action="delete.php" method="post">
              <input type="hidden" name="id" value="<?= $user['id']; ?>">
              <input type="submit" value="削除" class="mg_delete_button">
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
      <p class="return"><a href="mg_index.php">管理者用ページ</a></p>
    </div>  
  </body>
</html>