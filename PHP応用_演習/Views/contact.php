<?php
// 使用する変数を初期化
$name = '';
$kana = '';
$tel= '';
$email = '';
$body = '';

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
    } elseif (mb_strlen($_POST['body']) > 255) {
        $errors['body'] = 'お問い合わせ内容は255文字以内でお願いします。';
    }
}
// 変数の初期化
$page_flag = 0;

if(!empty($_POST['btn_confirm']) ) {
	$page_flag = 1;
} elseif (!empty($_POST['btn_submit'])) {
	$page_flag = 2;
}
?>
 
<!DOCTYPE html>
<html lang="ja">
  <head>
      <title>お問い合わせフォーム</title>
      <link rel="stylesheet" href="css/style.css">
  </head>
<body>
<?php if( $page_flag === 1 ): ?>
  <h1> 確認画面</h1>
  <form action= "" method="post">
    <!-- 氏名  -->
    <label for="name">氏名</label>
    <p><?php echo $_POST['name']; ?></p>
    <!-- フリガナ -->
    <label for="kana">フリガナ</label>
    <p><?php echo $_POST['kana']; ?></p>
    <!-- 電話番号 -->
    <label for="tel">電話番号</label>
    <p><?php echo $_POST['tel']; ?></p>
    <!-- メールアドレス -->
    <label for="email">メールアドレス</label>
    <p><?php echo $_POST['email']; ?></p>
    <!-- お問い合わせ内容 -->
    <label for="body">*お問い合わせ内容</label><br>
    <p><?php echo $_POST['body']; ?></p>
    <input type="submit" name="btn_back" value="キャンセル">
    <input type="submit" name="btn_submit" value="送信">
    <input type="hidden" name="your_name" value="<?php echo $_POST['name']; ?>">
    <input type="hidden" name="email" value="<?php echo $_POST['kana']; ?>">
    <input type="hidden" name="email" value="<?php echo $_POST['tel']; ?>">
    <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
    <input type="hidden" name="email" value="<?php echo $_POST['body']; ?>">
  </form>

<?php elseif( $page_flag === 2 ): ?>
<h1>完了画面</h1>
<p>お問い合わせ内容を送信しました。<br>
ありがとうございました。</p>

<?php else: ?>
<h1> 入力画面</h1>
    <p>* は必須項目です</p>
      <form action= "" method="post">
        <div class="row">
          <!-- 氏名  -->
          <label for="name">*氏名</label>
          <?php if (!empty($errors)); $errors['name']; ?>
          <input type="varchar" name="name" id="name" placeholder="例）入力太郎"><br>
          <!-- フリガナ -->
          <label for="kana">*フリガナ</label>
          <?php if (!empty($errors)) $errors['kana'] ?>
          <input type="varchar" name="kana" id="kana" placeholder="例）ニュウリョクタロウ"><br>
          <!-- 電話番号 -->
          <label for="tel">電話番号</label>
          <?php if (!empty($errors)) $errors['tel'] ?>
          <input type="varchar" name="tel" id="tel" placeholder="例）08011112222"><br>
          <!-- メールアドレス -->
          <label for="email">*メールアドレス</label>
          <?php if (!empty($errors)) $errors['email'] ?>
          <input type="varchar" name="email" id="email" placeholder="例）nyuuryoku11@mail.com"><br>
          <!-- お問い合わせ内容 -->
          <label for="body">*お問い合わせ内容</label><br>
          <?php if (!empty($errors)) $errors['body'] ?>
          <textarea rows="10" name="body" id="body">
              </textarea><br>
          <input name = "btn_confirm" type="submit" value="入力内容を確認する">
          </div>
      </form>
    <?php endif; ?>
    </body>
</html>