<?php
  require_once(ROOT_PATH .'Models/Db.php');

  class User extends Db {

    // 登録 insert
    public function insert($arr = ['name' => "", 'email' => "", 'password' => ""]) {
      try {
        $sql = 'INSERT INTO users (name, email, password, role) 
                VALUES(:name, :email, :password, :role)';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':name', $arr['name'], PDO::PARAM_STR);
        $sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
        $hash = password_hash($arr['password'], PASSWORD_DEFAULT);
        $sth->bindParam(':password', $hash, PDO::PARAM_STR);
        $sth->bindValue(':role', 0, PDO::PARAM_INT);
        $sth->execute();
      } catch (PDOException $e){
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    // ログイン select
    public function findUser($arr = ['email' => "", 'password' => ""]) {
      try {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        if(isset($result['password'])) {
          if(password_verify($arr['password'], $result['password'])) {
          return $result;
          }
        }  
      } catch (PDOException $e){
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    // ユーザー情報取得
    public function findAll():Array {
      try {
        $sql = 'SELECT * FROM users';
        $sth = $this->dbh->query($sql);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      } catch (PDOException $e){
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    public function findById($id = 0) {
      try {
        $sql = 'SELECT * FROM users WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
      } catch (PDOException $e){
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    public function updateById($arr = ['id' => "", 'name' => "", 'email' => ""]) {
      try {
        $sql = "UPDATE users SET name=:name, email=:email WHERE id=:id ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $arr['id'], PDO::PARAM_INT);
        $sth->bindParam(':name', $arr['name'], PDO::PARAM_STR);
        $sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function deleteById($id = 0) {
      try {
        $sql = 'DELETE FROM users WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }

    public function findByEmail($email = "") {
      try {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':email', $email, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
      } catch (PDOException $e){
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    public function updateByEmail($arr = ['email' => "", 'password' => ""]) {
      try {
        $sql = "UPDATE users SET password = :password WHERE email = :email";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
        $hash = password_hash($arr['password'], PASSWORD_DEFAULT);
        $sth->bindParam(':password', $hash, PDO::PARAM_STR);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！' . $e->getMessage();
      }
    }
  }
  
?>