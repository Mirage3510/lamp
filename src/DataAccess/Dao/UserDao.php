<?php

require_once '../IDataAccessService.php';
require_once 'AbstractPodDao.php';

/**
 * POD経由でユーザーデータにアクセスするクラスです。
 */
class UserDao extends AbstractPodDao implements IDataAccessService{

	const DB_USER_NAME = 'root';
	const DB_PASSWORD = '';
	const DB_DSN = 'mysql:dbhost=localhost;charset=utf8;dbname=lampdb';

}