<?php

  function findByUserAndOutput($user_id, $output_id) {
    try {
      $dsn = 'mysql:host=localhost;dbname=educare_output;charset=utf8';
      $user = 'root';
      $password = 'root';
      $dbh = new PDO($dsn, $user, $password);
      
      $sql = "SELECT * FROM favorites WHERE user_id = :user_id AND output_id = :output_id";
      $sth = $dbh->prepare($sql);
      $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $sth->bindParam(':output_id', $output_id, PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);
      return $result;
      exit;
    } catch(Exception $e) {
      error_log('エラー発生：'.$e->getMessage());
    }
  }

  function count_favorites($output_id) {
    try {
      $dsn = 'mysql:host=localhost;dbname=educare_output;charset=utf8';
      $user = 'root';
      $password = 'root';
      $dbh = new PDO($dsn, $user, $password);
      
      $sql = "SELECT count(*) FROM favorites WHERE output_id = :output_id";
      $sth = $dbh->prepare($sql);
      $sth->bindParam(':output_id', $output_id, PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetchColumn();
      return $result;
      exit;
    } catch(Exception $e) {
      error_log('エラー発生：'.$e->getMessage());
    }
  }

?>