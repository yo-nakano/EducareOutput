<?php 
  session_start();
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
  <body class="mg_body">
    <?php include(ROOT_PATH .'Views/header.php') ?>
    <div class="mg_index">
      <h2>管理者用ページ</h2>
      <div class="mg_select">
        <h3><a href="/Users/index.php">ユーザー管理</a></h3>
        <h3><a href="/Outputs/index.php">アウトプット管理</a></h3>
        <h3><a href="/Questions/index.php">質問管理</a></h3>
      </div>  
    </div>  
  </body>
</html>