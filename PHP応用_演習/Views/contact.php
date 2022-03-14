<?php
// 使用する変数を初期化
$name = '';
$kana = '';
$tel= '';
$email = '';
$body = '';
$page_flag = 0;

if(!empty($_POST['btn_confirm']) ) {
$errors = validation();
  if(empty($errors) ) {
    $page_flag = 1;
  } 
} elseif (!empty($_POST['btn_submit'])) {
  $page_flag = 2;
}

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
    <div class="element_wrap_p">
      <label for="name">氏名</label>
      <p><?php echo $_POST['name']; ?></p>
    </div>
    <!-- フリガナ -->
    <div class="element_wrap_p">
      <label for="kana">フリガナ</label>
      <p><?php echo $_POST['kana']; ?></p>
    </div>
    <!-- 電話番号 -->
    <div class="element_wrap_p">
      <label for="tel">電話番号</label>
      <p><?php echo $_POST['tel']; ?></p>
    </div>
    <!-- メールアドレス -->
    <div class="element_wrap_p">
      <label for="email">メールアドレス</label>
      <p><?php echo $_POST['email']; ?></p>
    </div>
    <!-- お問い合わせ内容 -->
    <div class="element_wrap_p">
      <label for="body">*お問い合わせ内容</label><br>
      <p><?php echo $_POST['body']; ?></p>
    </div>
    <input type="submit" name="btn_back" value="キャンセル">
    <input type="submit" name="btn_submit" value="送信">
    <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
    <input type="hidden" name="kana" value="<?php echo $_POST['kana']; ?>">
    <input type="hidden" name="tel" value="<?php echo $_POST['tel']; ?>">
    <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
    <input type="hidden" name="body" value="<?php echo $_POST['body']; ?>">
  </form>

<?php elseif( $page_flag === 2 ): ?>
<h1>完了画面</h1>
<p>お問い合わせ内容を送信しました。<br>
ありがとうございました。</p>

<?php else: ?>
<h1> 入力画面</h1>
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
          <input type="varchar" name="name" id="name" placeholder="例）入力太郎"
          value="<?php if( !empty($_POST['name']) ){ echo $_POST['name']; } ?>"><br>
        </div>
        <!-- フリガナ -->
        <div class="element_wrap">
          <label for="kana">*フリガナ</label>
          <input type="varchar" name="kana" id="kana" placeholder="例）ニュウリョクタロウ"
          value="<?php if( !empty($_POST['kana']) ){ echo $_POST['kana']; } ?>"><br>
        </div>
        <!-- 電話番号 -->
        <div class="element_wrap">
          <label for="tel">電話番号</label>
          <input type="varchar" name="tel" id="tel" placeholder="例）08011112222"
          value="<?php if( !empty($_POST['tel']) ){ echo $_POST['tel']; } ?>"><br>
        </div>
        <!-- メールアドレス -->
        <div class="element_wrap">
          <label for="email">*メールアドレス</label>
          <input type="varchar" name="email" id="email" placeholder="例）nyuuryoku11@mail.com"
          value="<?php if( !empty($_POST['email']) ){ echo $_POST['email']; } ?>"><br>
        </div>
        <!-- お問い合わせ内容 -->
        <div class="element_wrap">
          <label for="body">*お問い合わせ内容</label><br>
          <textarea rows="10" name="body" id="body" ><?php if (!empty($_POST['body'])){ echo nl2br($_POST['body']); } ?></textarea><br>
        </div>
        <input name = "btn_confirm" type="submit" value="入力内容を確認する">
        </div>
    </form>
  <?php endif; ?>
  </body>
</html>