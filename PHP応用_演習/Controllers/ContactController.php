<?php 
function validation(){
  // エラー内容
  $errors = [];
  // 送信データをチェック
  if (isset($_POST)) {
      // 氏名
      if (empty($_POST['name'])) {
          $errors['name'] = '氏名は必須項目です。';
      }
      // フリガナ
      if (empty($_POST['kana'])) {
          $errors['kana'] = 'フリガナは必須項目です。';
      }
      // 電話番号
      if (preg_match('/^[0-9]+$/', $_POST['tel']) === 0) {
          $errors['tel'] = '正しい電話番号を入力してください。';
      }
      // メールアドレス
      if (empty($_POST['email'])) {
          $errors['email'] = 'メールアドレスは必須項目です。';
      } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
          $errors['email'] = '正しいEメールアドレスを指定してください。';
      }
      // お問い合わせ内容
      if (empty($_POST['body'])) {
          $errors['body'] = 'お問い合わせ内容は必須項目です。';
      } 
  }
  return $errors;
}

$page_flag = 0;

if(!empty($_POST['btn_confirm']) ) {
$errors = validation();
  if(empty($errors) ) {
    $page_flag = 1;
  } 
} elseif (!empty($_POST['btn_submit'])) {
  $page_flag = 2;
}

// -----------------------------------------------------------------------------------

require_once(ROOT_PATH .'Models/ContactModel.php');

class ContactController {
    private $request;   // リクエストパラメータ(GET,POST)
    private $Model;    // モデルオブジェクト生成

    public function __construct() {
        // リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;  

        // モデルオブジェクトの生成
        $this->Model = new Model();

        // 別モデルと連携
        $dbh = $this->Model->get_db_handler();
    }

    public function insertController(){
      if(!empty($_POST['btn_submit'])){
        if(isset($this->request['post']['name'])) {
          $name = $this->request['post']['name'];
        }if(isset($this->request['post']['kana'])) {
          $kana = $this->request['post']['kana'];
        }if(isset($this->request['post']['tel'])) {
          $tel = $this->request['post']['tel'];
        }if(isset($this->request['post']['email'])) {
          $email = $this->request['post']['email'];
        }if(isset($this->request['post']['body'])) {
          $body = $this->request['post']['body'];
        }
      }
      $insert = $this->Model->insert();
      $params = [
          'insert' => $insert,
          'name' => $name,
          'kana' => $kana,
          'tel' => $tel,
          'email' => $email,
          'body' => $body,
      ];
      return $params;
    }

    public function selectController() {
      if(isset($this->request['get']['id'])) {
          $id = $this->request['get']['id'];
      }

      $select = $this->Contact->select();
      $params = [
          'select' => $select,
          'id' => $id,
      ];
      return $params;
  }
}
       