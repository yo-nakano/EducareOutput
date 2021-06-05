<?php
  require_once(ROOT_PATH .'Models/Question.php');

  class QuestionController {
    private $request; // リクエストパラメータ
    private $Question;  // Questionモデル

    public function __construct() {
      // リクエストパラメータの取得
      $this->request['get'] = $_GET;
      $this->request['post'] = $_POST;
      $this->Question = new Question();
    }

    public function index() {
      $questions = $this->Question->findAll();
      return $questions;
    }

    public function create() {
      session_start();
      $new_question = [
        'user_id' => $_SESSION['user']['id'],
        'title' => $_SESSION['question']['title'],
        'goal' => $_SESSION['question']['goal'],
        'unknown' => $_SESSION['question']['unknown'],
        'trial' => $_SESSION['question']['trial'],
        'hypothesis' => $_SESSION['question']['hypothesis']
      ];
      $this->Question->insert($new_question);
    }

    public function view() {
      if(empty($this->request['get']['id'])) {
        echo '指定のパラメータが不正です。このページを表示できません。';
        exit;
      }
      $question = $this->Question->findById($this->request['get']['id']);
      return $question;
    }

    public function update() {
      session_start();
      $edited_question = [
        'id' => $_SESSION['edit-id'],
        'user_id' => $_SESSION['user']['id'],
        'title' => $_SESSION['question']['title'],
        'goal' => $_SESSION['question']['goal'],
        'unknown' => $_SESSION['question']['unknown'],
        'trial' => $_SESSION['question']['trial'],
        'hypothesis' => $_SESSION['question']['hypothesis']
      ];
      $this->Question->updateById($edited_question);
    }

    public function delete() {
      $this->Question->deleteById($this->request['post']['delete-id']);
    }

    public function user_index() {
      $questions = $this->Question->findAllByUserId($this->request['get']['id']);
      return $questions;
    }
  }
?>