<?php 
 require_once(ROOT_PATH .'Models/Db.php');

$value = null;

if( !empty($_GET['message_id'])) {
  // トランザクション開始
  $pdo->beginTransaction();

  try {
    // SQL作成
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = :id");

    // 値をセット
    $stmt->bindValue( ':id', $_GET['message_id'], PDO::PARAM_INT);

    // SQLクエリの実行
    $stmt->execute();

    // コミット
    $res = $pdo->commit();

  } catch(Exception $e) {

    // エラーが発生した時はロールバック
    $pdo->rollBack();
    echo $e;
  }

  // 削除に成功したら一覧に戻る
  if( $res ) {
    header("Location: contact.php");
    exit;
  }
    
  // 投稿データが取得できないときは管理ページに戻る
  if( empty($message_data) ) {
    echo '投稿データが取得できませんでした';
  }
}
