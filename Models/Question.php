<?php
  require_once(ROOT_PATH .'Models/Db.php');

  class Question extends Db {

    public function findAll():Array {
      try {
        $sql = 'SELECT questions.*, users.name AS user_name 
                FROM questions JOIN users ON questions.user_id = users.id';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function insert($arr = ['user_id' => "", 'title' => "", 'goal' => "", 'unknown' => "", 'trial' => "", 'hypothesis' => ""]) {
      try {
        $sql = "INSERT INTO questions (user_id, title, goal, unknown, trial, hypothesis) VALUES (:user_id, :title, :goal, :unknown, :trial, :hypothesis)";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_INT);
        $sth->bindParam(':title', $arr['title'], PDO::PARAM_STR);
        $sth->bindParam(':goal', $arr['goal'], PDO::PARAM_STR);
        $sth->bindParam(':unknown', $arr['unknown'], PDO::PARAM_STR);
        $sth->bindParam(':trial', $arr['trial'], PDO::PARAM_STR);
        $sth->bindParam(':hypothesis', $arr['hypothesis'], PDO::PARAM_STR);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function findById($id = 0) {
      try {
        $sql = 'SELECT questions.*, users.name AS user_name 
                FROM questions JOIN users ON questions.user_id = users.id
                WHERE questions.id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function updateById($arr = ['id' => "", 'user_id' => "", 'title' => "", 'goal' => "", 'unknown' => "", 'trial' => "", 'hypothesis' => ""]) {
      try {
        $sql = "UPDATE questions SET user_id=:user_id, title=:title, goal=:goal, unknown=:unknown, trial=:trial, hypothesis=:hypothesis WHERE id=:id ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $arr['id'], PDO::PARAM_INT);
        $sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_INT);
        $sth->bindParam(':title', $arr['title'], PDO::PARAM_STR);
        $sth->bindParam(':goal', $arr['goal'], PDO::PARAM_STR);
        $sth->bindParam(':unknown', $arr['unknown'], PDO::PARAM_STR);
        $sth->bindParam(':trial', $arr['trial'], PDO::PARAM_STR);
        $sth->bindParam(':hypothesis', $arr['hypothesis'], PDO::PARAM_STR);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function deleteById($id = 0) {
      try {
        $sql = 'DELETE FROM questions WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function findAllByUserId($id = 0):Array {
      try {
        $sql = 'SELECT * FROM questions WHERE user_id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }
  }
?>