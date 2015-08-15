<?php

/**
 * 要求されたURIに応じてクラス及びメソッドに振り分けるクラスです。
 *
 */
class Dispatcher {

	/** システムのルートディレクトリ*/
	private $sysRoot;

	/**
	 * システムのルートディレクトリを設定します。
	 * @param string $path
	 */
	public function setSystemRoot($path) {
		$this->sysRoot = rtrim($path, '/');
	}

	public function dispatch() {
		//パラメータの取得（先頭及び末尾の/は削除)
		$param = preg_replace('/\/?$/', '', $_SERVER['REQUEST_URI']);
		$param = preg_replace('/^\/?/', '', $_SERVER['REQUEST_URI']);

		$params = array();
		if('' != $param) {
			//パラメータを/で分割
			$params = explode('/', $param);
		}

		//1番目のパラメータをコントローラとして取得
		$controller = "index";
		if(0 < count($params)) {
			$controller = $params[0];
		}

		//パラメータより取得したコントローラー名によりクラス振り分け
		$className = ucfirst(strtolower($controller)) . 'Controller';

		//クラスファイル読み込み
		require_once $this->sysRoot . '/controllers/' . $className . '.php';

		//クラスインスタンス生成
		$controllerInstance = new $className();

		//2番目のパラメータをコントローラーとして取得
		$action= 'index';
		if(1 < count($params)) {
			$action = $params[1];
		}

		//アクションメソッドを実行
		$actionMethod = $action . 'Action';
		$controllerInstance->$actionMethod();
	}
}