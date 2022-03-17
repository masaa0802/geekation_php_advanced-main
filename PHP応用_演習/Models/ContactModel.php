<?php 
require_once(ROOT_PATH .'Models/Db.php');

if( !empty($_POST['btn_submit']) ) {
  $name = $_POST['name'];
  $kana = $_POST['kana'];
  $tel= $_POST['tel'];
  $email = $_POST['email'];
  $body = $_POST['body'];

  if( empty($error_message) ) {

  // トランザクション開始
  $pdo->beginTransaction();

  try {
      // SQL作成
      $stmt = $pdo->prepare("INSERT INTO contacts (name, kana, tel, email, body) VALUES (:name, :kana, :tel, :email, :body)");

      // 値をセット
      $stmt->bindValue(':name', $name, PDO::PARAM_STR);
      $stmt->bindValue(':kana', $kana, PDO::PARAM_STR);
      $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->bindValue(':body', $body, PDO::PARAM_STR);

      // SQLクエリの実行
      $res = $stmt->execute();

      // コミット
      $res = $pdo->commit();

  } catch(Exception $e) {

      // エラーが発生した時はロールバック
      $pdo->rollBack();
      echo $e;
  }

  // プリペアドステートメントを削除
  $stmt = null;
  }
}

if( empty($error_message) ) {

	// メッセージのデータを取得する
	$sql = "SELECT * FROM contacts ORDER BY created_at DESC";
	$message_array = $pdo->query($sql);
}

// データベースの接続を閉じる
$pdo = null;
?>