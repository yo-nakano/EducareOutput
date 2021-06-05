<?php
  require_once(ROOT_PATH .'Models/Db.php');

  class Output extends Db {

    public function findAll():Array {
      try {
        $sql = 'SELECT outputs.*, users.name AS user_name 
                FROM outputs JOIN users ON outputs.user_id = users.id';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function insert($arr = ['user_id' => "", 'title' => "", 'text' => ""]) {
      try {
        $sql = "INSERT INTO outputs (user_id, title, text) VALUES (:user_id, :title, :text)";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_INT);
        $sth->bindParam(':title', $arr['title'], PDO::PARAM_STR);
        $sth->bindParam(':text', $arr['text'], PDO::PARAM_STR);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function findById($id = 0) {
      try {
        $sql = 'SELECT outputs.*, users.name AS user_name 
                FROM outputs JOIN users ON outputs.user_id = users.id
                WHERE outputs.id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function updateById($arr = ['id' => "", 'user_id' => "", 'title' => "", 'text' => ""]) {
      try {
        $sql = "UPDATE outputs SET user_id=:user_id, title=:title, text=:text WHERE id=:id ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $arr['id'], PDO::PARAM_INT);
        $sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_INT);
        $sth->bindParam(':title', $arr['title'], PDO::PARAM_STR);
        $sth->bindParam(':text', $arr['text'], PDO::PARAM_STR);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function deleteById($id = 0) {
      try {
        $sql = 'DELETE FROM outputs WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function findAllByUserId($id = 0):Array {
      try {
        $sql = 'SELECT * FROM outputs WHERE user_id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function findFavorites($id = 0) {
      try {
        $sql = 'SELECT outputs.*, favorites.* 
                FROM outputs JOIN favorites ON outputs.id = favorites.output_id
                WHERE favorites.user_id = :id';
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