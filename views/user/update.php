<?php

header("Context-Type:text/html; charset=UTF-8");
define('DB_DATABASE', 'lampdb');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DSN', 'mysql:dbhost=localhost;charset=utf8;dbname=' . DB_DATABASE);

$userId = $_POST["user_id"];

try {
	//db接続
	$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//初期表示データ取得
	$stmt = $db->query("select * from m_user where user_id=" . $userId);
	$userList = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$user = $userList[0];

} catch (PDOException $e) {
	echo $e->getMessage();
	exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8" />
		<title>ユーザー更新</title>
		<link rel="stylesheet" href="../css/common.css" />
		<link rel="stylesheet" href="../css/update.css" />
	</head>
	<body>
		<header class="main_header">
			<h1 class="header_title">ユーザー管理</h1>
			<nav>
				<a href="search.php">[一覧]</a>
			</nav>
		</header>
		<article>
			<h2 class="sub_title">ユーザー更新</h2>
			<form action="doUpdate.php" method="post" accept-charset="UTF-8">
				<dl id="user_update" class="item_list">
					<dt>名前（カナ）</dt>
					<dd>
						<span>（姓）</span><input type="text" name="last_name_kana" value="<?php echo $user["last_name_kana"]?>" />
						<span>（名）</span><input type="text" name="first_name_kana" value="<?php echo $user["first_name_kana"]?>" />
					</dd>
					<dt class="clear">名前（漢字）</dt>
					<dd>
						<span>（姓）</span><input type="text" name="last_name" value="<?php echo $user["last_name"]?>" />
						<span>（名）</span><input type="text" name="first_name" value="<?php echo $user["first_name"]?>" />
					</dd>
					<dt class="clear">住所</dt>
					<dd>
						<input type="text" name="address" value="<?php echo $user["address"]?>" />
					</dd>
					<dt class="clear">電話番号</dt>
					<dd>
						<input type="tel" name="tel_number" value="<?php echo $user["tel_number"]?>" />
					</dd>
					<dt class="clear">性別</dt>
					<dd>
						<select name="sex">
							<option value="0" <?php if($user["sex"] === "0"){echo "selected";}?>>男</option>
							<option value="1" <?php if($user["sex"] === "1"){echo "selected";}?>>女</option>
							<option value="2" <?php if($user["sex"] === "2"){echo "selected";}?>>不明</option>
						</select>
					</dd>
					<dt class="clear">生年月日</dt>
					<dd>
						<input type="date" name="birth_day" value="<?php echo $user["birth_day"]?>" />
					</dd>
				</dl>
				<input type="hidden" name="user_id" value='<?php echo $user["user_id"]; ?>' />
				<input id="update_button" type="submit" class="normal_button" value="更新" />
			</form>
		</article>
	</body>
</html>