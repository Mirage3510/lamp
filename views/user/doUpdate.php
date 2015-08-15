<?php

header("Context-Type:text/html; charset=UTF-8");
define('DB_DATABASE', 'lampdb');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DSN', 'mysql:dbhost=localhost;charset=utf8;dbname=' . DB_DATABASE);

$userId = $_POST["user_id"];
$dispName = $_POST["last_name"] . $_POST['first_name'];
$now = new DateTime();
$now = $now->format('Y-m-d H:i:s');

try {
	//db接続
	$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//データ更新
	$sql = "
			update
				m_user
			set
				update_date = :update_date,
				last_name = :last_name,
				first_name = :first_name,
				last_name_kana = :last_name_kana,
				first_name_kana = :first_name_kana,
				disp_name = :disp_name,
				tel_number = :tel_number,
				address = :address,
				sex = :sex,
				birth_day = :birth_day
			where
				user_id = :user_id
			";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':update_date', $now, PDO::PARAM_STR);
	$stmt->bindValue(':last_name', $_POST["last_name"], PDO::PARAM_STR);
	$stmt->bindValue(':first_name', $_POST["first_name"], PDO::PARAM_STR);
	$stmt->bindValue(':last_name_kana', $_POST["last_name_kana"], PDO::PARAM_STR);
	$stmt->bindValue(':first_name_kana', $_POST["first_name_kana"], PDO::PARAM_STR);
	$stmt->bindValue(':disp_name', $dispName, PDO::PARAM_STR);
	$stmt->bindValue(':tel_number', $_POST["tel_number"], PDO::PARAM_STR);
	$stmt->bindValue(':address', $_POST["address"], PDO::PARAM_STR);
	$stmt->bindValue(':sex', $_POST["sex"], PDO::PARAM_STR);
	$stmt->bindValue(':birth_day', $_POST["birth_day"], PDO::PARAM_STR);
	$stmt->bindValue(':user_id', $_POST["user_id"], PDO::PARAM_INT);
	$stmt->execute();

	//取得したIDをセッションパラメータに登録
	session_start();
	$_SESSION["user_id"] = $userId;

	//詳細画面に遷移
	header("Location: http://localhost/lamp/user/detail.php");


} catch (PDOException $e) {
	echo $e->getMessage();
	exit;
}