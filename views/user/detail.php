<?php
header("Context-Type:text/html; charset=UTF-8");
define('DB_DATABASE', 'lampdb');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DSN', 'mysql:dbhost=localhost;charset=utf8;dbname=' . DB_DATABASE);

if(@$_POST["user_id"]) {
	$userId = $_POST["user_id"];
} else {
	session_start();
	$userId = $_SESSION["user_id"];
}

try {
	//db接続
	$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//取得処理
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
		<title>ユーザー詳細</title>
		<link rel="stylesheet" href="../css/common.css" />
		<link rel="stylesheet" href="../css/detail.css" />
	</head>
	<body>
		<header class="main_header">
			<h1 class="header_title">ユーザー管理</h1>
			<nav class="main_nav">
				<a href="search.php">[一覧]</a>
				<a href="create.html">[新規作成]</a>
			</nav>
		</header>
		<article>
			<h2  class="sub_title">ユーザー詳細</h2>
			<dl id="user_detail" class="item_list clear">
				<dt>名前（カナ）</dt>
				<dd>
					<span><?php echo $user["last_name_kana"] . "&nbsp;" . $user["first_name_kana"] ?></span>
				</dd>
				<dt class="clear">名前（漢字）</dt>
				<dd>
					<?php echo $user["disp_name"] ?>
				</dd>
				<dt class="clear">住所</dt>
				<dd>
					<?php echo $user["address"] ?>
				</dd>
				<dt class="clear">電話番号</dt>
				<dd>
					<?php echo $user["tel_number"] ?>
				</dd>
				<dt class="clear">性別</dt>
				<dd>
					<?php if($user["sex"] === "0") :?>
						<span>男</span>
					<?php elseif($user["sex"] === "1"): ?>
						<span>女</span>
					<?php else :?>
						<span>不明</span>
					<?php endif;?>
				</dd>
				<dt class="clear">生年月日</dt>
				<dd>
					<?php echo $user["birth_day"] ?>
				</dd>
			</dl>
			<div id="button_container" >
				<form id="update_form" action="update.php" method="post">
					<button type="submit" name="user_id" class="normal_button" value="<?php echo $userId?>">更新</button>
				</form>
				<form id="delete_form" action="remove.php" method="post">
					<button type="submit" name="user_id"  class="normal_button" value="<?php echo $userId?>">削除</button>
				</form>
			</div>
		</article>
	</body>
</html>