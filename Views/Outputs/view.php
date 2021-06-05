<?php
  require_once(ROOT_PATH .'Controllers/OutputController.php');
  require_once(ROOT_PATH .'Controllers/CommentController.php');
  require_once('favorite_judge.php');

  session_start();

  if(!isset($_GET['id']) && isset($_SESSION['edit-id'])) {
    $_GET['id'] = $_SESSION['edit-id'];
    unset($_SESSION['edit-id']);
  }

  $output = new OutputController();
  $params = $output->view();

  $comment = new CommentController();
  $comment_params = $comment->index();

  function h($str) {
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
  }
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>educare output</title>
    <link rel="stylesheet" type="text/css" href="/css/base.css">
    <script src="https://kit.fontawesome.com/3a388de8eb.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
      $(function(){
          var $favorite = $('.btn-favorite');
          $favorite.on('click',function(e){
              e.stopPropagation();
              var $this = $(this);
              //カスタム属性（output）に格納された投稿ID取得
              favoriteOutputId = $this.parents('.favorite').data('output'); 
              $.ajax({
                url: 'favorite_ajax.php',
                type: 'POST',
                data: {'post' : favoriteOutputId},
              }).done(function(data){
                console.log(data);
                // いいねの総数を表示
                $this.children('span').html(data);
                // いいね取り消しのスタイル
                $this.children('i').toggleClass('far'); //空洞ハート
                // いいね押した時のスタイル
                $this.children('i').toggleClass('fas'); //塗りつぶしハート
                $this.children('i').toggleClass('active');
                $this.toggleClass('active');
              }).fail(function(msg) {
                console.log('Ajax Error');
              });
          });
      });
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
        $('.comment_delete').on('click', function() {
          if(confirm("このコメントを削除しますか？")) {
            return true;
          } else {
            return false;
          }
        });
      });
    </script>
  </head>
  <body>
    <?php include(ROOT_PATH .'Views/header.php') ?>
    <div class="view_contents">
      <form action="/Users/view.php" method="get">
        <input type="hidden" name="id" value="<?= $params['user_id'] ?>">
        <input type="submit" id="view_user_name" value="<?= $params['user_name'] ?>">
      </form>
      <div id="output_view_title">
        <h2><?= $params['title']; ?></h2>
      </div>
      <div>
        <!-- <h4>アウトプット内容</h4> -->
        <div id="view_text"><?= h($params['text']); ?></div>
      </div>

      <?php if($params['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['role'] == 1): ?>
        <div class="edit_delete">
          <?php if($params['user_id'] == $_SESSION['user']['id']): ?>
            <form method="get" action="edit.php">
              <input type="hidden" name="id" value="<?= $params['id'] ?>">
              <input type="submit" value="編集">
            </form>
          <?php endif; ?>  
          <form method="get" action="delete_confirm.php">
            <input type="hidden" name="id" value="<?= $params['id'] ?>">
            <input type="submit" value="削除">
          </form>
        </div>
      <?php endif; ?>
      
      <div class="favorite" data-output="<?= $_GET['id'] ?>">
        <div class="btn-favorite ">
            
            <i class="fa-star fa-lg px-16 
                      <?php if(!empty(findByUserAndOutput($_SESSION['user']['id'], $_GET['id'])))
                            {echo 'active fas';} else {echo 'far';}; ?>">
            </i>
            <span><?php echo count_favorites($_GET['id']); ?></span>
            <p class="favorite-sign">お気に入り</p>
        </div>
      </div>
    </div>
    <div class="view_contents">
      <h3>コメント</h3>
      <?php foreach($comment_params as $comment): ?>
        <div class="comments">
          <form action="/Users/view.php" method="get">
            <input type="hidden" name="id" value="<?= $comment['user_id'] ?>">
            <input type="submit" id="view_user_name" value="<?= $comment['user_name'] ?>">
          </form>
          <div class="comment"><?= h($comment['text']) ?></div>
          <?php if($comment['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['role'] == 1): ?>
            <div class="comment-edit_delete">
            <?php if($comment['user_id'] == $_SESSION['user']['id']): ?>
              <form method="get" action="/Comments/edit.php">
                <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                <input type="submit" value="編集">
              </form>
            <?php endif; ?>
              <form method="post" action="/Comments/delete.php">
                <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                <input type="submit" class="comment_delete" value="削除">
              </form>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>  
      <form method="post" action="/Comments/new.php">
        <input type="hidden" name="output_id" value="<?= $params['id']; ?>">
        <input type="submit" class="comment_create" value="コメントする">
      </form>  
    </div>
  </body>
</html>