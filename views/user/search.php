<?php
header("Context-Type:text/html; charset=UTF-8");
define('DB_DATABASE', 'lampdb');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DSN', 'mysql:dbhost=localhost;charset=utf8;dbname=' . DB_DATABASE);

$inputUserNmae = isset($_POST["input_user_name"]) ? htmlspecialchars($_POST["input_user_name"]) : null;
if($inputUserNmae != null) {
	//スペース入力を除去
	$searchUserName = preg_replace('/(\s|　)/', "", $inputUserNmae);
}

//条件検索
$searchCondition = array(
		"userId" => isset($_POST["user_id"]) ? htmlspecialchars($_POST["user_id"]) : null,
		"userName" => isset($searchUserName) ? $searchUserName : null,
		"telNumber" => isset($_POST["tel_number"]) ? htmlspecialchars($_POST["tel_number"]) : null,
		"sex" => isset($_POST["sex"]) ? htmlspecialchars($_POST["sex"]) : null
);
//検索条件のクエリ生成
$whereCondition = " where ";
foreach ($searchCondition as $key => $elem) {
	if($elem != null) {
		switch ($key) {
			case "userId" :
				$whereCondition = $whereCondition . "user_id =". $elem . " && ";
				break;
			case "userName" :
				$whereCondition = $whereCondition . "disp_name like '%". $elem . "%' && ";
				break;
			case "telNumber" :
				$whereCondition = $whereCondition . "tel_number ='". $elem . "' && ";
				break;
			case "sex" :
				$whereCondition = $whereCondition . "sex ='". $elem . " ' && ";
				break;
		}
	}
}

$whereCondition = $whereCondition . "delete_flag='0'";

//sqlの生成
$sql = "select * from m_user" . $whereCondition;
//echo $sql;

try {
	//db接続
	$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare($sql);
	$stmt->execute();
	//$stmt = $db->query("select * from m_user where delete_flag = 0");
	$userList = $stmt->fetchAll(PDO::FETCH_ASSOC);


} catch (PDOException $e) {
	echo $e->getMessage();
	exit;
}
$timestamp = new DateTime();
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8" />
		<title>ユーザー一覧</title>
		<link rel="stylesheet" href="../css/common.css" />
		<link rel="stylesheet" href="../css/search.css" />
	</head>
	<body>
		<header class="main_header">
			<h1 class="header_title">ユーザー管理</h1>
			<nav id="create">
				<a href="create.html">[新規作成]</a>
			</nav>
		</header>
		<section id="search_condition">
			<h2 class="sub_title">検索条件</h2>
			<form method="post">
				<dl class="item_list">
					<dt><span>ID</span></dt>
					<dd>
						<input type="number" name="user_id" value="<?php echo isset($_POST["user_id"]) ? htmlspecialchars($_POST["user_id"]) : null ?>" />
					</dd>
					<dt class="clear"><span>名前</span></dt>
					<dd>
						<input type="text" name="input_user_name" value="<?php echo isset($_POST["input_user_name"]) ? htmlspecialchars($_POST["input_user_name"]) : null ?>" />
					</dd>
					<dt class="clear"><span>電話番号</span></dt>
					<dd>
						<input type="text" name="tel_number" value="<?php echo isset($_POST["tel_number"]) ? htmlspecialchars($_POST["tel_number"]) : null ?>"/>
					</dd>
					<dt class="clear"><span>性別</span></dt>
					<dd>
						<select name="sex">
							<option></option>
							<option value="0" <?php if(@$_POST["sex"] === "0"){echo "selected";}?>>男</option>
							<option value="1" <?php if(@$_POST["sex"] === "1"){echo "selected";}?>>女</option>
							<option value="2" <?php if(@$_POST["sex"] === "2"){echo "selected";}?>>不明</option>
						</select>
					</dd>
				</dl>
				<input id="search_button" type="submit" class="normal_button" value="検索" />
			</form>
		</section>
		<article id="list" class="clear">
			<h2 class="sub_title">ユーザー一覧</h2>
			<?php if(count($userList) > 0) :?>
				<table id="search_result" class="normal_table">
					<thead>
						<tr>
							<th>ID</th>
							<th>名前</th>
							<th>電話番号</th>
							<th>性別</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($userList as $user) :?>
							<tr>
								<td><?php echo $user["user_id"]?></td>
								<td><?php echo $user["last_name"] . "&nbsp;" . $user["first_name"]?></td>
								<td><?php echo $user["tel_number"]?></td>
								<?php if($user["sex"] === "0") :?>
									<td>男</td>
								<?php elseif($user["sex"] === "1"): ?>
									<td>女</td>
								<?php else :?>
									<td>不明</td>
								<?php endif;?>
								<td>
									<form action="detail.php" method="post">
										<button type="submit" name="user_id" class="normal_button" value="<?php echo $user["user_id"]?>">詳細</button>
									</form>
								</td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			<?php  else :?>
				<p>該当データが存在しません。</p>
			<?php endif; ?>
		</article>
	</body>
</html>