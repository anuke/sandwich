<?php

class DbConfig
{
	public $default = array(
		'host'		=> 'localhost',
		'db'		=> 'vcms',
		'login'		=> 'vcms',
		'password'	=> 'vcms',
		'type'		=> 'mysql',
		'charset'	=> 'utf8',
	);
	
	
	public function __construct()
	{
		$this->init();
	}
	
	public function init()
	{
		$ret = array();
		foreach ($this as $key => $value)
		{
			$conn[$key] = mysql_connect($value['host'], $value['login'], $value['password']);
			$ret[$key] = mysql_select_db($value['db'], $conn[$key]) ? $conn[$key]:false;
			if ($ret[$key] && $value['charset'])
			{
				mysql_query(" SET NAMES '{$value['charset']} ", $conn[$key]);
			}
		}
		return $ret;
	}
}