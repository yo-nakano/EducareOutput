<?php
  if(!isset($_SESSION['user']['name'])) {
    header('Location: /Users/login.php');
    exit;
  }
?>

<div id="header">
  <?php if(isset($_SESSION['user']['name'])): ?>
    <ul class="logo">
      <?php if($_SESSION['user']['role'] == 0): ?>
        <li><a href="/Outputs/index.php" id="logo">educare output</a></li>
      <?php endif; ?> 
      <?php if($_SESSION['user']['role'] == 1): ?>
        <li><a href="/Users/mg_index.php" id="logo">educare output</a></li>
      <?php endif; ?>  
    </ul>

    <ul class="list">
      <li id="output_index"><a id="intro-button" href="/Outputs/index.php">アウトプット一覧</a></li>
      <li id="question_index"><a id="exp-button" href="/Questions/index.php">質問一覧</a></li>
    </ul>

    <ul class="list">
      <li><a id="intro-button" href="/Users/view.php?id=<?= $_SESSION['user']['id']; ?>"><?= $_SESSION['user']['name'] ?></a></li>
      <li><a id="exp-button" href="/Users/logout.php">ログアウト</a></li>
    </ul> 
  <?php endif; ?>  
</div>
