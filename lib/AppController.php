<?php

class AppController extends Object {
	
	public $name = '';
	public $uses;
	public $action = '';
	private $viewVars = array();
	private $db = array();
	
	function __construct()
	{
		$this->linkModel();
		$this->db = new DbConfig();
		//debug($this->db->init());
	}
	
	private function linkModel()
	{
		//$this->__set($name, new $name());
		foreach ($this->uses as $model) {
			$this->{$model} = new $model($model);
		}
	}
	
	public function set($one, $two)
	{
		$this->viewVars[$one] = $two;
	}
	
	public function render($tpl = null)
	{
		echo __FILE__ . ' <strong>' . __LINE__ . '</strong> line ' ;
		require_once(dirname(__FILE__).'/../'.VIEWS_DIR.$this->name.'/'.($tpl == null ? $this->action:$tpl).'.tpl');
	}
	
	public function __destruct()
	{
		//echo 'am destructed';
		$this->render();
		//debug($this);
	}
}