<?php
session_start();
​
// (1) 登録するデータを用意
$name = $_POST['name'];
$kana = $_POST['kana'];
$tel = $_POST['tel'];
$email = $_POST['email'];
$body = $_POST['body'];
​
// (2) データベースに接続
$dsn = 'mysql: dbname=casteria; host = 127.0.0.1';
$user = 'root';
$password = '';
$pdo = new PDO($dsn, $user, $password);
​
// DB接続チェック
try {
    $dbh = new PDO($dsn, $user, $password);
    echo '接続成功' . '<br><br>';
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();

​
// (3) SQL作成
$stmt = $pdo->prepare("INSERT INTO contacts (name, kana, tel, email, body) VALUES (:name, :kana, :tel, :email, :body)");
​
// (4) 登録するデータをセット
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':kana', $kana, PDO::PARAM_STR);
$stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':body', $body, PDO::PARAM_STR);
​
// (5) SQL実行
$stmt->execute();
​}
// (6) データベースの接続解除
$pdo = null;
?>