<?php

try {
	$dbh->beginTransaction();
	// DBへ接続
  $dbh = new PDO("mysql:host=127.0.0.1;port=3306;dbname = casteria; charset=utf8");
	$username = 'root';
	$password = '';
	// SQL作成
	$sql = 'CREATE TABLE contacts (
		id INT(11) AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(50) NOT NULL, 
		kana VARCHAR(50) NOT NULL,
    tel VARCHAR(11), 
    email VARCHAR(100) NOT NULL,
    body text,
    created_at datetime CURRENT_TIMESTANP,
		registry_datetime DATETIME,
	) engine=innodb default charset=utf8';

	// SQL実行
	$res = $dbh->query($sql);
	$dbh->commit();
} catch(PDOException $e) {

	echo $e->getMessage();
	die();
	$dbh->rollBack();
}

// 接続を閉じる
$dbh = null;
