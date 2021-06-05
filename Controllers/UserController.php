<?php
  require_once(ROOT_PATH .'Models/User.php');

  class UserController {
    private $request; // リクエストパラメータ
    private $User;  // Userモデル

    public function __construct() {
      // リクエストパラメータの取得
      $this->request['get'] = $_GET;
      $this->request['post'] = $_POST;
      $this->User = new User();
    }

    // 新規登録
    public function register() {
      $new_user = [
        'name' => $this->request['post']['name'],
        'email' => $this->request['post']['email'],
        'password' => $this->request['post']['password']
      ];
      $this->User->insert($new_user);
    }

    // ログイン
    public function login() {
      $registered_user = [
        'email' => $this->request['post']['email'],
        'password' => $this->request['post']['password']
      ];
      $user = $this->User->findUser($registered_user);
      $params = [
        'user' => $user
      ];
      return $params;
    }

    // ユーザーデータ取得
    public function get() {
      $users = $this->User->findAll();
      $params = [
        'users' => $users
      ];
      return $params; 
    }

    public function view() {
      $user = $this->User->findById($this->request['get']['id']);
      return $user; 
    }

    public function update() {
      session_start();
      $edited_user = [
        'id' => $_SESSION['id'],
        'name' => $_SESSION['form']['name'],
        'email' => $_SESSION['form']['email']
      ];
      $this->User->updateById($edited_user);
    }

    public function delete() {
      $this->User->deleteById($this->request['post']['id']); 
    }

    public function identify() {
      $user = $this->User->findByEmail($this->request['post']['email']); 
      return $user;
    }

    public function password_update() {
      $arr = [
        'email' => $this->request['post']['email'], 
        'password' => $this->request['post']['password']
      ];
      $this->User->updateByEmail($arr);
    }
  }
?>