<?php
    namespace Model;

    require_once('DbTest.php');

    // class Sample {
    //     // $a + $b を返す
    //     public function Add($a, $b) {
    //         return $a + $b;
    //     }

    //     // $a - $b を返す
    //     public function Sub($a, $b) {
    //         return $a - $b;
    //     }
    // }

    class User extends TestDb {
        function insert($arr = ['name' => "山田", 'email' => "yamada@gmail.com", 'password' => "yamada730"]) {
            $sql = 'INSERT INTO users (name, email, password) 
                    VALUES(:name, :email, :password)';
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':name', $arr['name'], PDO::PARAM_STR);
            $sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
            $hash = password_hash($arr['password'], PASSWORD_DEFAULT);
            $sth->bindParam(':password', $hash, PDO::PARAM_STR);
            $sth->execute();
        }

        function findUser($arr = ['email' => "yamada@gmail.com", 'password' => "yamada730"]) {
            $sql = 'SELECT * FROM users WHERE email = :email';
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            if(isset($result['password'])) {
                if(password_verify($arr['password'], $result['password'])) {
                    return $result['name'];
                }
            }  
        }

        public function findAll():Array {
            $sql = 'SELECT * FROM users';
            $sth = $this->dbh->query($sql);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function findById($id = 2) {
            $sql = 'SELECT * FROM users WHERE id = :id';
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            return $result;    
        }

        public function updateById($arr = ['id' => 2, 'name' => "高橋", 'email' => "takahashi@gmail.com"]) {
            $sql = "UPDATE users SET name=:name, email=:email WHERE id=:id ";
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':id', $arr['id'], PDO::PARAM_INT);
            $sth->bindParam(':name', $arr['name'], PDO::PARAM_STR);
            $sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
            $sth->execute();

            $sql = 'SELECT * FROM users WHERE id = :id';
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':id', $arr['id'], PDO::PARAM_INT);
            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public function deleteById($id = 2) {
            $sql = 'DELETE FROM users WHERE id = :id';
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
        }
    }
?>