<?php 
// 使用する変数を初期化
$name = null;
$kana = null;
$tel= null;
$email = null;
$body = null;

$message_data = null;
$message_array = array();
$pdo = null;
$stmt = null;
$res = null;
$option = null;

// データベースに接続
try {

  $option = array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::MYSQL_ATTR_MULTI_STATEMENTS => false
  );
  $pdo = new PDO('mysql:charset=UTF8;dbname=casteria;host=127.0.0.1;port=8111', 'root', '', $option);

} catch(PDOException $e) {

  // 接続エラーのときエラー内容を取得する
  $error_message[] = $e->getMessage();
}

if( !empty($_GET['message_id']) && empty($_POST['message_id']) ) {
  // SQL作成
	$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = :id");

	// 値をセット
	$stmt->bindValue( ':id', $_GET['message_id'], PDO::PARAM_INT);

	// SQLクエリの実行
	$stmt->execute();

	// 表示するデータを取得
	$message_data = $stmt->fetch();

  // 投稿データが取得できないときは管理ページに戻る
	if( empty($message_data) ) {
		echo '投稿データが取得できませんでした';
	}
} elseif ( !empty($_POST['message_id']) ) {
  $name = $_POST['name'];
  $kana = $_POST['kana'];
  $tel= $_POST['tel'];
  $email = $_POST['email'];
  $body = $_POST['body'];

  // 氏名
  if (empty($name)) {
      $errors['name'] = '氏名は必須項目です。';
  }
  // フリガナ
  if (empty($kana)) {
      $errors['kana'] = 'フリガナは必須項目です。';
  }
  // 電話番号
  if (preg_match('/^[0-9]+$/',$tel) === 0) {
      $errors['tel'] = '正しい電話番号を入力してください。';
  }
  // メールアドレス
  if (empty($email)) {
      $errors['email'] = 'メールアドレスは必須項目です。';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = '正しいEメールアドレスを指定してください。';
  }
  // お問い合わせ内容
  if (empty($body)) {
      $errors['body'] = 'お問い合わせ内容は必須項目です。';
  } 
  if( empty($errors) ) {
      // トランザクション開始
    $pdo->beginTransaction();

    try {
        // SQL作成
        $stmt = $pdo->prepare("UPDATE contacts SET name = :name, kana = :kana, tel = :tel, email = :email , body = :body WHERE id = :id");

        // 値をセット
        $stmt->bindValue( ':id', $_POST['message_id'], PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':kana', $kana, PDO::PARAM_STR);
        $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':body', $body, PDO::PARAM_STR);

        // SQLクエリの実行
        $stmt->execute();

        // コミット
        $res = $pdo->commit();

    } catch(Exception $e) {

        // エラーが発生した時はロールバック
        $pdo->rollBack();
        echo $e;
    }
    // 更新に成功したら一覧に戻る
		if( $res ) {
			header("Location: ./contact.php");
			exit;
		}

    // プリペアドステートメントを削除
    $stmt = null;
  }
}



// データベースの接続を閉じる
$stmt = null;
$pdo = null;

?>


<!DOCTYPE html>
<html lang="ja">
  <head>
      <title>お問い合わせフォーム</title>
      <link rel="stylesheet" href="css/style.css">
  </head>
<body>

  <h1> 詳細画面 </h1>
    <p>* は必須項目です</p>
      <?php if(!empty($errors) ): ?>
        <ul class="error_list">
        <?php foreach( $errors as $value ): ?>
          <li><?php echo $value; ?></li>
        <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <form action= "" method="post">
        <div class="row">
          <!-- 氏名  -->
          <div class="element_wrap">
            <label for="name">*氏名</label>
            <input type="text" name="name" id="name" placeholder="例）入力太郎"
            value="<?php if( !empty($message_data['name']) ){ echo $message_data['name']; } 
            elseif( !empty($name) ){ echo htmlspecialchars( $name, ENT_QUOTES, 'UTF-8'); }
            ?>"><br>
          </div>
          <!-- フリガナ -->
          <div class="element_wrap">
            <label for="kana">*フリガナ</label>
            <input type="text" name="kana" id="kana" placeholder="例）ニュウリョクタロウ"
            value="<?php if( !empty($message_data['kana']) ){ echo $message_data['kana']; }
            elseif( !empty($kana) ){ echo htmlspecialchars( $kana, ENT_QUOTES, 'UTF-8'); }
            ?>"><br>
          </div>
          <!-- 電話番号 -->
          <div class="element_wrap">
            <label for="tel">電話番号</label>
            <input type="text" name="tel" id="tel" placeholder="例）08011112222"
            value="<?php if( !empty($message_data['tel']) ){ echo $message_data['tel']; }
            elseif( !empty($tel) ){ echo htmlspecialchars( $tel, ENT_QUOTES, 'UTF-8'); }
            ?>"><br>
          </div>
          <!-- メールアドレス -->
          <div class="element_wrap">
            <label for="email">*メールアドレス</label>
            <input type="text" name="email" id="email" placeholder="例）nyuuryoku11@mail.com"
            value="<?php if( !empty($message_data['email']) ){ echo $message_data['email']; } 
            elseif( !empty($email) ){ echo htmlspecialchars( $email, ENT_QUOTES, 'UTF-8'); }
            ?>"><br>
          </div>
          <!-- お問い合わせ内容 -->
          <div class="element_wrap">
            <label for="body">*お問い合わせ内容</label><br>
            <textarea rows="10" name="body" id="body" ><?php if (!empty($message_data['body'])){ echo nl2br($message_data['body']); } 
            elseif( !empty($body) ){ echo htmlspecialchars( $body, ENT_QUOTES, 'UTF-8'); }
            ?></textarea><br>
          </div>
          <a class="btn_cancel" href="contact.php">キャンセル</a>
          <input name = "btn_submit" type="submit" value="更新">
          <input type="hidden" name="message_id" value="<?php if( !empty($message_data['id']) ){ echo $message_data['id']; } ?>">
        </div>
      </form>
  </body>
</html>