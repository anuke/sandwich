<?php

class usersController extends AppController
{
	public $name = 'users';
	public $uses = array('Users');
	public function __construct()
	{
		parent::__construct();
	}

	public function register($login, $password)
	{
		$array = array('fields' => '*', 'condition' => array('login' => "$login", 'password' => md5($password)));
		$this->set('user', $this->Users->find('all', $array));
	}
}