<?php
  require_once(ROOT_PATH .'Models/Db.php');

  class Answer extends Db {

    public function findAllById($id = 0):Array {
      try {
        $sql = 'SELECT answers.*, users.name AS user_name 
                FROM answers JOIN users ON answers.user_id = users.id
                WHERE answers.question_id = :question_id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':question_id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function insert($arr = ['user_id' => "", 'question_id' => "", 'text' => ""]) {
      try {
        $sql = "INSERT INTO answers (user_id, question_id, text) VALUES (:user_id, :question_id, :text)";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_INT);
        $sth->bindParam(':question_id', $arr['question_id'], PDO::PARAM_INT);
        $sth->bindParam(':text', $arr['text'], PDO::PARAM_STR);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function findById($id = 0) {
      try {
        $sql = 'SELECT * FROM answers WHERE id = :id';
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
        $sql = "UPDATE answers SET text=:text WHERE id=:id ";
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
        $sql = 'DELETE FROM answers WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }
  }
?>