<?php

class usersController extends AppController
{
	public $name = 'users';
	public $uses = array('Users');
	public function __construct()
	{
		parent::__construct();
		//echo 'users';
		//$this->User->find('all');
	}

	public function register($login, $password)
	{
		$array = array('fields' => '*', 'condition' => array('login' => "$login", 'password' => md5($password)));
		//echo '</pre>';
		//print_r($this->Users->find('all', $array));
		//debug($this->Users->UserProfile);
		
		$this->set('user', $this->Users->find('all', $array));
	}
}