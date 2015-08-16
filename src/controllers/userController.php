<?php
require_once '/lamp/src/framework/mvc/Request.php';
require_once '/lamp/src/form/UserForm.php';

class userController {

	const VIEW_ROOT = "/lamp/views/";
	const VIEW_TEST = "test/test.php";

	private $userForm;

	public function indexAction() {
		echo "incex!";
	}
	public function helloAction() {

		echo 'Hello World';
	}

	public function testAction() {
		$this->userForm = new UserForm();
		$this->userForm->setUserName("Tom");

		return $this::VIEW_ROOT . $this::VIEW_TEST;
	}
}