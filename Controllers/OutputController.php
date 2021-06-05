<?php
  require_once(ROOT_PATH .'Models/Output.php');

  class OutputController {
    private $request; // リクエストパラメータ
    private $Output;  // Outputモデル

    public function __construct() {
      // リクエストパラメータの取得
      $this->request['get'] = $_GET;
      $this->request['post'] = $_POST;
      $this->Output = new Output();
    }

    public function index() {
      $outputs = $this->Output->findAll();
      return $outputs;
    }

    public function create() {
      session_start();
      $new_output = [
        'user_id' => $_SESSION['user']['id'],
        'title' => $_SESSION['output']['title'],
        'text' => $_SESSION['output']['text']
      ];
      $this->Output->insert($new_output);
    }

    public function view() {
      if(empty($this->request['get']['id'])) {
        echo '指定のパラメータが不正です。このページを表示できません。';
        exit;
      }
      $output = $this->Output->findById($this->request['get']['id']);
      return $output;
    }

    public function update() {
      session_start();
      $edited_output = [
        'id' => $_SESSION['edit-id'],
        'user_id' => $_SESSION['user']['id'],
        'title' => $_SESSION['output']['title'],
        'text' => $_SESSION['output']['text']
      ];
      $this->Output->updateById($edited_output);
    }

    public function delete() {
      $this->Output->deleteById($this->request['post']['delete-id']);
    }

    public function user_index() {
      $outputs = $this->Output->findAllByUserId($this->request['get']['id']);
      return $outputs;
    }

    public function favorite_index() {
      $outputs = $this->Output->findFavorites($this->request['get']['id']);
      return $outputs;
    }
  }
?>