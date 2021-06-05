<?php
  require_once(ROOT_PATH .'Models/Comment.php');

  class CommentController {
    private $request; // リクエストパラメータ
    private $Comment;  // Commentモデル

    public function __construct() {
      // リクエストパラメータの取得
      $this->request['get'] = $_GET;
      $this->request['post'] = $_POST;
      $this->Comment = new Comment();
    }

    public function index() {
      $comments = $this->Comment->findAllById($this->request['get']['id']);
      return $comments;
    }

    public function create() {
      session_start();
      $new_comment = [
        'user_id' => $_SESSION['user']['id'],
        'output_id' => $_SESSION['output_id'],
        'text' => $_SESSION['text']
      ];
      $this->Comment->insert($new_comment);
    }

    public function view() {
      if(empty($this->request['get']['id']) && empty($this->request['post']['id'])) {
        echo '指定のパラメータが不正です。このページを表示できません。';
        exit;
      }
      if(!empty($this->request['get']['id'])) {
        $comment = $this->Comment->findById($this->request['get']['id']);
      }
      if(empty($this->request['get']['id'])) {
        $comment = $this->Comment->findById($this->request['post']['id']);
      }
      return $comment;
    }

    public function update() {
      session_start();
      $edited_comment = [
        'id' => $_SESSION['id'],
        'text' => $_SESSION['text']
      ];
      $this->Comment->updateById($edited_comment);
    }

    public function delete() {
      $this->Comment->deleteById($this->request['post']['id']);
    }
  }
?>