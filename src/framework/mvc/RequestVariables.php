<?php

/**
 * リクエスト変数抽象クラス
 */
abstract class RequestVariables {

	protected $_values;

	//コンストラクタ
	public function __construct() {
		$this->setValues();
	}

	//パラメータ値設定
	abstract protected  function setValues();

	/**
	 * 指定キーのパラメータを取得します。<br>
	 * キーの指定がない場合は全てのパラメータを配列で返却します。
	 * @param string $key
	 * @return パラメータ
	 */
	public function get($key = null) {
		$ret = null;
		if(null == $key) {
			$ret = $this->_values;
		} else {
			if(true == $this->has($key)) {
				$ret = $this->_values[$key];
			}
		}
		return $ret;
	}

	/**
	 * 指定のキーが存在するか確認します。
	 * @param string $key
	 */
	public function has($key) {
		if(false == array_key_exists($key, $this->_values)) {
			return false;
		}
		return true;
	}

}