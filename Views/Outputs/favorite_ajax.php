<?php
  session_start();
  $user_id = $_SESSION['user']['id'];

  if (isset($_POST['post'])) {
    $output_id = $_POST['post'];
    // echo $output_id;

    $dsn = 'mysql:host=localhost;dbname=educare_output;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);

      try {
          $sql = "SELECT * FROM favorites WHERE user_id = :user_id AND output_id = :output_id";
          $sth = $dbh->prepare($sql);
          $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
          $sth->bindParam(':output_id', $output_id, PDO::PARAM_INT);
          $sth->execute();
          $result = $sth->fetch(PDO::FETCH_ASSOC);

          if(!empty($result)) {
            $sql = "DELETE FROM favorites WHERE user_id = :user_id AND output_id = :output_id";
            $sth = $dbh->prepare($sql);
            $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sth->bindParam(':output_id', $output_id, PDO::PARAM_INT);
            $sth->execute();
          } else {
            $sql = "INSERT INTO favorites (user_id, output_id) VALUES (:user_id, :output_id)";
            $sth = $dbh->prepare($sql);
            $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sth->bindParam(':output_id', $output_id, PDO::PARAM_INT);
            $sth->execute();
          }

          $sql = "SELECT COUNT(*) FROM favorites WHERE output_id = :output_id";
          $sth = $dbh->prepare($sql);
          $sth->bindParam(':output_id', $output_id, PDO::PARAM_INT);
          $sth->execute();
          $count = $sth->fetchColumn();
          echo $count;

      } catch(Exception $e){
        error_log('エラー発生：'.$e->getMessage());
      }
  }
?>