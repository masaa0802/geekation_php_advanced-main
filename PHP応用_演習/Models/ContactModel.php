<!-- <#?php  
// require_once(ROOT_PATH .'Db.php');


// class Model extends Db {
//   public function __construct($dbh = null) {
//       parent::__construct($dbh);
//   }

//   public function insert(){
//     if( !empty($_POST['btn_submit']) ) {
//       $name = $_POST['name'];
//       $kana = $_POST['kana'];
//       $tel= $_POST['tel'];
//       $email = $_POST['email'];
//       $body = $_POST['body'];
    
//       if( empty($error_message) ) {
        
//       try {
//           // SQL作成
//           $stmt = $dbh->prepare("INSERT INTO contacts (name, kana, tel, email, body) VALUES (:name, :kana, :tel, :email, :body)");
    
//           // 値をセット
//           $stmt->bindValue(':name', $name, PDO::PARAM_STR);
//           $stmt->bindValue(':kana', $kana, PDO::PARAM_STR);
//           $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
//           $stmt->bindValue(':email', $email, PDO::PARAM_STR);
//           $stmt->bindValue(':body', $body, PDO::PARAM_STR);
    
//           // SQLクエリの実行
//           $res = $stmt->execute();
    
//           // コミット
//           $res = $dbh->commit();
    
//       } catch(Exception $e) {
    
//           // エラーが発生した時はロールバック
//           $dbh->rollBack();
//           echo $e;
//       }
    
//       // プリペアドステートメントを削除
//       $stmt = null;
//       }
//     }
    
//     if( empty($error_message) ) {
    
//       // メッセージのデータを取得する
//       $sql = "SELECT * FROM contacts ORDER BY created_at ASC";
//       $message_array = $dbh->query($sql);
//     }
//   }
//   public function delete(){
//     if( !empty($_POST['delete'])) {

//       // トランザクション開始
//       $pdo->beginTransaction();

//       try {
//         // SQL作成
//         $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = :id");

//         // 値をセット
//         $stmt->bindValue( ':id', $_POST['delete'], PDO::PARAM_INT);

//         // SQLクエリの実行
//         $stmt->execute();

//         // コミット
//         $res = $pdo->commit();

//       } catch(Exception $e) {

//         // エラーが発生した時はロールバック
//         $pdo->rollBack();
//         echo $e;
//       }

//       // 削除に成功したら一覧に戻る
//       if( $res ) {
//         header("Location: contact.php");
//         exit;
//       }
        
//       // 投稿データが取得できないときは管理ページに戻る
//       if( empty($message_data) ) {
//         echo '投稿データが取得できませんでした';
//       }
//     }
//   }
//   public function edit(){  
//     if( !empty($_GET['edit_id'])) {
//       // SQL作成
//       $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = :id");

//       // 値をセット
//       $stmt->bindValue( ':id', $_GET['edit_id'], PDO::PARAM_INT);

//       // SQLクエリの実行
//       $stmt->execute();

//       // 表示するデータを取得
//       $message_data = $stmt->fetch();

//       // 投稿データが取得できないときは管理ページに戻る
//       if( empty($message_data) ) {
//         echo '投稿データが取得できませんでした';
//       }
//     } elseif ( !empty($_POST['edit_id']) ) {
//       $name = $_POST['name'];
//       $kana = $_POST['kana'];
//       $tel= $_POST['tel'];
//       $email = $_POST['email'];
//       $body = $_POST['body'];

//       // 氏名
//       if (empty($name)) {
//           $errors['name'] = '氏名は必須項目です。';
//       }
//       // フリガナ
//       if (empty($kana)) {
//           $errors['kana'] = 'フリガナは必須項目です。';
//       }
//       // 電話番号
//       if (preg_match('/^[0-9]+$/',$tel) === 0) {
//           $errors['tel'] = '正しい電話番号を入力してください。';
//       }
//       // メールアドレス
//       if (empty($email)) {
//           $errors['email'] = 'メールアドレスは必須項目です。';
//       } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//           $errors['email'] = '正しいEメールアドレスを指定してください。';
//       }
//       // お問い合わせ内容
//       if (empty($body)) {
//           $errors['body'] = 'お問い合わせ内容は必須項目です。';
//       } 
//       if( empty($errors) ) {
//           // トランザクション開始
//         $pdo->beginTransaction();

//         try {
//             // SQL作成
//             $stmt = $pdo->prepare("UPDATE contacts SET name = :name, kana = :kana, tel = :tel, email = :email , body = :body WHERE id = :id");

//             // 値をセット
//             $stmt->bindValue( ':id', $_POST['edit_id'], PDO::PARAM_INT);
//             $stmt->bindValue(':name', $name, PDO::PARAM_STR);
//             $stmt->bindValue(':kana', $kana, PDO::PARAM_STR);
//             $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
//             $stmt->bindValue(':email', $email, PDO::PARAM_STR);
//             $stmt->bindValue(':body', $body, PDO::PARAM_STR);

//             // SQLクエリの実行
//             $stmt->execute();

//             // コミット
//             $res = $pdo->commit();

//         } catch(Exception $e) {

//             // エラーが発生した時はロールバック
//             $pdo->rollBack();
//             echo $e;
//         }
//         // 更新に成功したら一覧に戻る
//         if( $res ) {
//           header("Location: ./contact.php");
//           exit;
//         }

//         // プリペアドステートメントを削除
//         $stmt = null;
//       }
//     }

//     // データベースの接続を閉じる
//     $stmt = null;
//     $pdo = null;
//   }
// }

<?php 

require_once(ROOT_PATH .'Models/Db.php');

class Model extends Db {
  public function __construct($dbh = null) {
      parent::__construct($dbh);
  }
  // すべての情報取得
  public function select() {
    try {
      $sql = "SELECT * FROM contacts WHERE id = :id" ;
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $message_array = $sth->query($sql);
      $message_array = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $message_array;
    } catch(Exception $e) {
      // エラーが発生した時はロールバック
      $sth->rollBack();
      echo $e;
    }
  }

  // 新規データ作成
  public function insert(){
    try {
      $sql = "INSERT INTO contacts (name, kana, tel, email, body) VALUES (:name, :kana, :tel, :email, :body)";
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $res = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $res;
      } catch(Exception $e) {
      // エラーが発生した時はロールバック
      $sth->rollBack();
      echo $e;
    }
  }
} 








