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

if(!empty($_POST['btn_confirm'])){
$errors = validation();
  if(empty($errors) ) {
    $page_flag = 1;
  } 
} elseif (!empty($_POST['btn_submit'])) {
  $page_flag = 2;
}

// -----------------------------------------------------------------------------------

require_once(ROOT_PATH .'Models/ContactModel.php');

$controller = new ContactController();

class ContactController {
  private $model;

  public function __construct(){
      $this->model = new Model();
  }

  public function selectController(){
      return $this->model->select();
  }

  public function insertController($name, $kana, $tel, $email, $body){
      return $this->model->insert($name, $kana, $tel, $email, $body);
  }

  public function updateController($id, $name, $kana, $tel, $email, $body){
      return $this->model->update($id, $name, $kana, $tel, $email, $body);
  }

  public function editController($id){
      return $this->model->edit($id);
  }

  public function deleteController($id){
      return $this->model->delete($id);
  }
}
       