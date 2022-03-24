<?php  

class Model {
  private $pdo;
  private static $dsn = 'mysql:charset=UTF8;dbname=casteria;host=127.0.0.1;port=8111';
  private static $username = 'root';
  private static $password = '';

  public $id;
  public $name;
  public $kana;
  public $tel;
  public $email;
  public $body;

  public function __construct(){

      $this->pdo = new PDO(self::$dsn, self::$username, self::$password);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }

  public function creteData(){
    try {
      // トランザクション開始
      $this->pdo->beginTransaction();
      // SQL作成
      $stmt = $this->pdo->prepare("SELECT * FROM contacts ORDER BY created_at ASC");
      // SQL実行
      $res = $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
      // コミット
      if ($res) {
          $this->pdo->commit();
      }
    } catch (PDOException $e) {
      // エラーメッセージを出力
      echo $e->getMessage();
      // ロールバック
      $this->pdo->rollBack();
    } finally {
      // データベースの接続解除
      $this->pdo = null;
    }
  }

  public function insertData($name, $kana, $tel, $email, $body){       
    try {
        // トランザクション開始
        $this->pdo->beginTransaction();
        // SQL作成
        $stmt = $this->pdo->prepare("INSERT INTO contacts (name, kana, tel, email, body) VALUES (:name, :kana, :tel, :email, :body)");
  
        // 値をセット
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':kana', $kana, PDO::PARAM_STR);
        $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':body', $body, PDO::PARAM_STR);
  
        // SQLクエリの実行
        $res = $stmt->execute();
  
        // コミット
        if ($res) {
         $this->pdo->commit();
        }
  
    } catch(PDOException $e) {
  
        // エラーが発生した時はロールバック
        $this->pdo->rollBack();
        echo $e;
    }
  
    // プリペアドステートメントを削除
    $stmt = null;
  }

  public function updateData($id, $name, $kana, $tel, $email, $body){
    try {
        // トランザクション開始
        $this->pdo->beginTransaction();
        // SQL作成
        $stmt = $this->pdo->prepare("UPDATE contacts SET name = :name, kana = :kana, tel = :tel, email = :email , body = :body WHERE id = :id");

        // 値をセット
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':kana', $kana, PDO::PARAM_STR);
        $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':body', $body, PDO::PARAM_STR);

        // SQLクエリの実行
        $res = $stmt->execute();

        // コミット
        if ($res) {
          $this->pdo->commit();
        }

    } catch(PDOException $e) {
        // エラーメッセージを出力
        echo $e->getMessage();
        // エラーが発生した時はロールバック
        $this->pdo->rollBack();
        echo $e;
    }
    // 更新に成功したら一覧に戻る
    if ($res) {
      header("Location: ./contact.php");
      exit;
    }
    // プリペアドステートメントを削除
    $stmt = null;
  }
  

  public function editData($id){  

    try{
      // トランザクション開始
      $this->pdo->beginTransaction();
      // SQL作成
      $stmt = $this->pdo->prepare("SELECT * FROM contacts WHERE id = :id");

      // 値をセット
      $stmt->bindValue( ':id', $id, PDO::PARAM_INT);

      // SQLクエリの実行
      $stmt->execute();
    } catch (PDOException $e) {
      // エラーメッセージを出力
      echo $e->getMessage();
      // ロールバック
      $this->pdo->rollBack();
    } finally {
        // データベースの接続解除
        $this->pdo = null;
    }
    // 表示するデータを取得
    return $stmt->fetch();
  }

  public function deleteData($id){

    try {
      // トランザクション開始
      $this->pdo->beginTransaction();
      // SQL作成
      $stmt = $this->pdo->prepare("DELETE FROM contacts WHERE id = :id");

      // 値をセット
      $stmt->bindValue(':id',$id, PDO::PARAM_INT);

      // SQLクエリの実行
      $res = $stmt->execute();

      // コミット
      if ($res) {
         $this->pdo->commit();
      }

    } catch(PDOException $e) {

      // エラーが発生した時はロールバック
      $this->pdo->rollBack();
      echo $e;
    }

    // 削除に成功したら一覧に戻る
    if ($res) {
      header("Location: contact.php");
      exit;
    }
  }
}









