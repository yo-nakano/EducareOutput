<?php
  require_once(ROOT_PATH .'Models/Db.php');

  class Comment extends Db {

    public function findAllById($id = 0):Array {
      try {
        $sql = 'SELECT comments.*, users.name AS user_name 
                FROM comments JOIN users ON comments.user_id = users.id
                WHERE comments.output_id = :output_id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':output_id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function insert($arr = ['user_id' => "", 'output_id' => "", 'text' => ""]) {
      try {
        $sql = "INSERT INTO comments (user_id, output_id, text) VALUES (:user_id, :output_id, :text)";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_INT);
        $sth->bindParam(':output_id', $arr['output_id'], PDO::PARAM_INT);
        $sth->bindParam(':text', $arr['text'], PDO::PARAM_STR);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function findById($id = 0) {
      try {
        $sql = 'SELECT * FROM comments WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function updateById($arr = ['id' => "", 'text' => ""]) {
      try {
        $sql = "UPDATE comments SET text=:text WHERE id=:id ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $arr['id'], PDO::PARAM_INT);
        $sth->bindParam(':text', $arr['text'], PDO::PARAM_STR);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function deleteById($id = 0) {
      try {
        $sql = 'DELETE FROM comments WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }
  }
?>