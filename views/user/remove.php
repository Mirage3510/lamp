<?php
header("Context-Type:text/html; charset=UTF-8");
define('DB_DATABASE', 'lampdb');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DSN', 'mysql:dbhost=localhost;charset=utf8;dbname=' . DB_DATABASE);

try {
	//db接続
	$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//論理削除
	$now = new DateTime();
	$now = $now->format('Y-m-d H:i:s');
	$stmt = $db->prepare("update m_user set delete_flag = '1', update_date = :timestamp where user_id=:user_id");
	$stmt->bindValue(':user_id', $_POST["user_id"], PDO::PARAM_STR);
	$stmt->bindValue(':timestamp', $now, PDO::PARAM_STR);
	$stmt->execute();

	//一覧画面に繊維
	header("Location: http://localhost/lamp/user/search.php");
	exit;

} catch (PDOException $e) {
	echo $e->getMessage();
	exit;
}