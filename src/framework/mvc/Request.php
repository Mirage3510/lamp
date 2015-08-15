<?php
require_once '/lamp/src/framework/mvc/Post.php';
require_once '/lamp/src/framework/mvc/QueryString.php';

/**
 * リクエストクラス
 */
class Request {

	/**POSTパラメータ */
	private $post;

	/**GETパラメータ */
	private $query;

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		$this->post = new Post();
		$this->query = new QueryString();
	}

	/**
	 * POST変数を取得します。<br>
	 * パラメータに指定のない場合は、POST変数全てを配列で返却します。
	 * @param string $key
	 * @return パラメータ
	 */
	public function getPost($key = null) {
		if (null == $key) {
			return $this->post->get();
		}
		if (false == $this->post->has($key)) {
			return null;
		}
		return $this->post->get($key);
	}

	/**
	 * GET変数を取得します。<br>
	 * パラメータに指定のない場合は、GET変数すべてを配列で返却します。
	 * @param string $key
	 * @return パラメータ
	 */
	public function getQuery($key = null) {
		if(null == $key) {
			return  $this->query->get();
		}
		if(false == $this->query->has($key)) {
			return null;
		}
		return $this->query->get($key);
	}


}