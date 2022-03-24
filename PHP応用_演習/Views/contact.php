<?php
require_once(ROOT_PATH .'Controllers/ContactController.php');
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>お問い合わせフォーム</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
<body>

<!-- -------------------------------------確認画面------------------------------------ -->

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
      <p><?php echo nl2br($_POST['body']); ?></p>
    </div>
    <input type="submit" name="btn_back" value="キャンセル">
    <input type="submit" name="btn_submit" value="送信">
    <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
    <input type="hidden" name="kana" value="<?php echo $_POST['kana']; ?>">
    <input type="hidden" name="tel" value="<?php echo $_POST['tel']; ?>">
    <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
    <input type="hidden" name="body" value="<?php echo $_POST['body']; ?>">
  </form>

  <!-- -------------------------------------完了画面------------------------------------- -->

<?php elseif( $page_flag === 2 ): ?>
<h1>完了画面</h1>
<p>お問い合わせ内容を送信しました。<br>
ありがとうございました。</p>
<a href="contact.php">トップへ</a>

<!-- -------------------------------------入力画面------------------------------------- -->
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
          <input type="text" name="name" id="name" placeholder="例）入力太郎"
          value="<?php if( !empty($_POST['name']) ){ echo $_POST['name']; } ?>"><br>
        </div>
        <!-- フリガナ -->
        <div class="element_wrap">
          <label for="kana">*フリガナ</label>
          <input type="text" name="kana" id="kana" placeholder="例）ニュウリョクタロウ"
          value="<?php if( !empty($_POST['kana']) ){ echo $_POST['kana']; } ?>"><br>
        </div>
        <!-- 電話番号 -->
        <div class="element_wrap">
          <label for="tel">電話番号</label>
          <input type="text" name="tel" id="tel" placeholder="例）08011112222"
          value="<?php if( !empty($_POST['tel']) ){ echo $_POST['tel']; } ?>"><br>
        </div>
        <!-- メールアドレス -->
        <div class="element_wrap">
          <label for="email">*メールアドレス</label>
          <input type="text" name="email" id="email" placeholder="例）nyuuryoku11@mail.com"
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
    <!-- -------------------------------------(入力画面)お問い合わせ内容詳細------------------------------------- -->
    <form action="" method="post">
    <table>
      <th>氏名</th>
      <th>フリガナ</th>
      <th>電話番号</th>
      <th>メールアドレス</th>
      <th>お問い合わせ内容</th>
      <th></th>
      <th></th>
      <?php if( !empty($message_array) ){ ?>
      <?php foreach( $message_array as $value ){ ?>
      <tr>
      <td><p><?php  echo $value['name']; ?></p></td>
      <td><p><?php  echo $value['kana']; ?></p></td>
      <td><p><?php  echo $value['tel'];  ?></p></td>
      <td><p><?php  echo $value['email'];  ?></p></td>
      <td><p><?php  echo nl2br($value['body']);  ?></p></td>
      <td><a href="edit.php?edit_id=<?php echo $value['id']; ?>" name="edit">編集</a></td>
      <td><input type="submit" name="delete" value="削除" onclick="return confirm('本当に削除しますか？')">
          <input type="hidden" name="delete" value="<?php echo $value['id']; ?>"></td>
      </tr>
      <?php } ?>
      <?php } ?>
    </table>
  </form>
  <?php endif; ?>
  </body>
</html>

