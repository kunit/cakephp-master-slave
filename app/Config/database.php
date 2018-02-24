<?php
class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'db',
		'login' => 'app',
		'password' => 'app',
		'database' => 'app',
		'prefix' => '',
		'encoding' => 'utf8',
	);

	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'db',
		'login' => 'app',
		'password' => 'app',
		'database' => 'test_app',
		'prefix' => '',
		'encoding' => 'utf8',
	);
}
