<?php
require_once(ROOT_PATH .'Controllers/ContactController.php');
if (!empty($_POST)) {
    $id = $_POST['id'];
    if ($id) {
        $errors = $controller->validation();
    }
}
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

        <?php if (!empty($errors)) :?>
            <ul class="error_list">
            <?php foreach ($errors as $value) :?>
                <li><?php echo $value;?></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action= "" method="post">
        <?php
        // GETパラメータの$idがあり、POSTデータがない場合、データを表示する
        if (!empty($_GET['id'])&& empty($_POST['id'])) {
            $message_data = $controller->editData($_GET['id']);
        // POSTがある場合（入力されたデータが送信された場合）
        } elseif (!empty($_POST)) {
            // 登録するデータを用意
            $id = $_POST['id'];
            $name = $_POST['name'];
            $kana = $_POST['kana'];
            $tel = $_POST['tel'];
            $email = $_POST['email'];
            $body = $_POST['body'];
            // DBを更新する
            $controller->updateData($id, $name, $kana, $tel, $email, $body);
        // GETパラメータの$idが空で、POSTデータがない場合、contact.phpにリダイレクト
        // 不正アクセスの防止
        } elseif (empty($_GET['id'] && empty($_POST))) {
            header("Location: contact.php");
            exit;
        }
        ?>
        <div class="row">
          <!-- 氏名  -->
          <div class="element_wrap">
            <label for="name">*氏名</label>
            <input type="text" name="name" id="name" placeholder="例）入力太郎" value="
            <?php
            if (!empty($message_data['name'])) {
                echo $message_data['name'];
            } elseif (!empty($name)) {
                echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
            } ?>"><br>
          </div>
          <!-- フリガナ -->
          <div class="element_wrap">
            <label for="kana">*フリガナ</label>
            <input type="text" name="kana" id="kana" placeholder="例）ニュウリョクタロウ" value="
            <?php
            if (!empty($message_data['kana'])) {
                echo $message_data['kana'];
            } elseif (!empty($kana)) {
                echo htmlspecialchars($kana, ENT_QUOTES, 'UTF-8');
            } ?>"><br>
          </div>
          <!-- 電話番号 -->
          <div class="element_wrap">
            <label for="tel">電話番号</label>
            <input type="text" name="tel" id="tel" placeholder="例）08011112222" value="
            <?php
            if (!empty($message_data['tel'])) {
                echo $message_data['tel'];
            } elseif (!empty($tel)) {
                echo htmlspecialchars($tel, ENT_QUOTES, 'UTF-8');
            } ?>"><br>
          </div>
          <!-- メールアドレス -->
          <div class="element_wrap">
            <label for="email">*メールアドレス</label>
            <input type="text" name="email" id="email" placeholder="例）nyuuryoku11@mail.com" value="
            <?php
            if (!empty($message_data['email'])) {
                echo $message_data['email'];
            } elseif (!empty($email)) {
                echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            }?>"><br>
          </div>
          <!-- お問い合わせ内容 -->
          <div class="element_wrap">
            <label for="body">*お問い合わせ内容</label><br>
            <textarea rows="10" name="body" id="body" >
                <?php
                if (!empty($message_data['body'])) {
                    echo nl2br($message_data['body']);
                } elseif (!empty($body)) {
                    echo htmlspecialchars($body, ENT_QUOTES, 'UTF-8');
                }?>
            </textarea><br>
          </div>
          <a class="btn_cancel" href="contact.php">キャンセル</a>
          <input name = "btn_update" type="submit" value="更新">
          <input type="hidden" name="id" value="
            <?php
            if (!empty($message_data['id'])) {
                echo $message_data['id'];
            } ?>">
        </div>
      </form>
  </body>
</html>