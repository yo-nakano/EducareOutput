<?php
  require_once(ROOT_PATH .'Models/Answer.php');

  class AnswerController {
    private $request; // リクエストパラメータ
    private $Answer;  // Commentモデル

    public function __construct() {
      // リクエストパラメータの取得
      $this->request['get'] = $_GET;
      $this->request['post'] = $_POST;
      $this->Answer = new Answer();
    }

    public function index() {
      $answers = $this->Answer->findAllById($this->request['get']['id']);
      return $answers;
    }

    public function create() {
      session_start();
      $new_answer = [
        'user_id' => $_SESSION['user']['id'],
        'question_id' => $_SESSION['question_id'],
        'text' => $_SESSION['text']
      ];
      $this->Answer->insert($new_answer);
    }

    public function view() {
      if(empty($this->request['get']['id']) && empty($this->request['post']['id'])) {
        echo '指定のパラメータが不正です。このページを表示できません。';
        exit;
      }
      if(!empty($this->request['get']['id'])) {
        $answer = $this->Answer->findById($this->request['get']['id']);
      }
      if(empty($this->request['get']['id'])) {
        $answer = $this->Answer->findById($this->request['post']['id']);
      }
      return $answer;
    }

    public function update() {
      session_start();
      $edited_answer = [
        'id' => $_SESSION['id'],
        'text' => $_SESSION['text']
      ];
      $this->Answer->updateById($edited_answer);
    }

    public function delete() {
      $this->Answer->deleteById($this->request['post']['id']);
    }
  }
?>