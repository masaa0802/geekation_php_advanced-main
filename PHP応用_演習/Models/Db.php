<?php 
class Db {
  protected $dbh;

  public function __construct($dbh = null) {
    if(!$dbh) { // 接続情報が存在しない場合
      try {
        $option = array(
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::MYSQL_ATTR_MULTI_STATEMENTS => false
        );
        $this->dbh = new PDO('mysql:charset=UTF8;dbname=casteria;host=127.0.0.1;port=8111', 'root', '',$option);

        // 接続成功
      } catch (PDOException $e) {
        echo "接続失敗: " . $e->getMessage() . "\n";
        exit();
      }
    } else { // 接続情報が存在する場合
        $this->dbh = $dbh;
    }
  }

  public function get_db_handler() {
      return $this->dbh;
  }

  public function begin_transaction() {
      $this->dbh->beginTransaction();
  }

  public function commit() {
      $this->dbh->commit();
  }

  public function rollback() {
      $this->dbh->rollback();
  }
}


// // 使用する変数を初期化
// $name = null;
// $kana = null;
// $tel= null;
// $email = null;
// $body = null;

// $message_array = array();
// $message_date = null;
// $pdo = null;
// $stmt = null;
// $res = null;
// $option = null;

// // データベースに接続
// try {

//   $option = array(
//       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//       PDO::MYSQL_ATTR_MULTI_STATEMENTS => false
//   );
//   $pdo = new PDO('mysql:charset=UTF8;dbname=casteria;host=127.0.0.1;port=8111', 'root', '', $option);

// } catch(PDOException $e) {

//   // 接続エラーのときエラー内容を取得する
//   $error_message[] = $e->getMessage();
// }