<?php
  require_once(ROOT_PATH .'Controllers/OutputController.php');
  session_start();

  $output = new OutputController();
  $params = $output->index();
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
      $(function(){
        $('.list li a').each(function(){
          var href = $(this).attr('href');
          if(location.href.match(href)) {
            $(this).parent().addClass('current');
          } else {
            $(this).parent().removeClass('current');
          };
        });
        $('.current a').css('text-decoration', 'underline');
        $('.current a').css('text-underline-offset', '5px');
      });
    </script>
  </head>

    <?php if($_SESSION['user']['role'] == 0): ?>
      <body>
        <?php include(ROOT_PATH .'Views/header.php') ?>
        <div class="contents-head">
          <h2>アウトプット一覧</h2>
        </div>
        <div class="contents-body">
          <?php foreach($params as $output): ?>
            <div id="created-list">
              <form action="view.php" method="get" id="title">
                <input type="hidden" name="id" value="<?= $output['id'] ?>">
                <input type="submit" value="<?= $output['title'] ?>">
              </form>
              <form action="/Users/view.php" method="get" id="user_name">
                <input type="hidden" name="id" value="<?= $output['user_id'] ?>">
                <span>created by </span><input type="submit" value="<?= $output['user_name'] ?>">
              </form>
            </div>
          <?php endforeach; ?>
        </div>
        <a id="new-button" href="new.php">+<span id="new-sign">新規投稿</span></a>
      </body>
    <?php endif; ?>  

    <?php if($_SESSION['user']['role'] == 1): ?>
      <body class="mg_body">
      <?php include(ROOT_PATH .'Views/header.php') ?>
        <div class="mg_index">
          <h2>アウトプット一覧</h2>
          <table>
            <tr>
              <th class="mg_index_title">タイトル</th>
              <th>投稿ユーザー</th>
              <th>&nbsp;</th>
              <!-- <th>&nbsp;</th> -->
            </tr>
            <?php foreach($params as $output): ?>
            <tr>
              <td class="mg_index_title"><?= $output['title']; ?></td>
              <td><?= $output['user_name']; ?></td>
              <td class="mg">
                <form action="view.php" method="get">
                  <input type="hidden" name="id" value="<?= $output['id']; ?>">
                  <input type="submit" value="詳細" class="mg_button">
                </form>
                <form action="delete_confirm.php" method="get">
                  <input type="hidden" name="id" value="<?= $output['id']; ?>">
                  <input type="submit" value="削除" class="mg_button">
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </table>
          <p class="return"><a href="/Users/mg_index.php">管理者用ページ</a></p>
        </div>  
      </body>
    <?php endif; ?>  
  
</html>