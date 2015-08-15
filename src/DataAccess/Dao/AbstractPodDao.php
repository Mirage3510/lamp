<?php
/**
 * PodDaoの基底クラス
 */
class AbstractPodDao {

	/** コネクション */
	private $db;

	/**
	 * コンストラクタ
	 * 新しいpodUserDaoのインスタンスを生成します。
	 * @param $db
	 */
	public function __construct($_db) {
		$db = $_db;
	}

}