<?php

class AppModel {

	public $name;
	private $useTable;
	private $dbConfig = 'default';
	public $id = null;

	private $parent = null;
	private $alreadyUsed = false;

	public $belongsTo = array();
	public $hasOne = array();
	public $hasMany = array();


	public function __construct($name, $parent = null) 
	{
		$this->name = $name;
		$this->parent = $parent;
		self::init();
	}

	private function init()
	{
		$this->useTable = $this->useTable ? $this->useTable:strtolower($this->name);

		foreach ($this->hasOne as $model) {
			if (!empty($this->parent) && $model == $this->parent->name)	{
				$this->{$model} = $this->parent;
			}
			else {
				$this->{$model} = new $model($model);
			}
		}
		
		foreach ($this->hasMany as $model) {
			$this->{$model} = new $model($model);
		}
		
		foreach ($this->belongsTo as $model) {
			if (!empty($this->parent) && $model == $this->parent->name) {
				//debug($this->parent);//->name;
				//echo $this->name, '  ' ,$model;
				$this->{$model} = $this->parent;
			}
			else {
				$this->{$model} = new $model($model, $this);
			}
		}
	}

	public function find($type = 'all', $condition = null, $return = 'likeArray')
	{
		if (is_array($condition) && !empty($condition)) {
			$WHERE = '';
			foreach ($condition as $keyword => $array)
			{
				switch ($keyword)
				{
					case 'condition':
						foreach ($array as $field => $value)
						{
							$WHERE .= ' AND '.$field." = '".$value."'";
							//echo $WHERE;
						}
						break;
					case 'fields':
						//$fields =  'SELECT '.$array.' FROM '.$this->useTable.' WHERE 1=1 '.$WHERE;
						$fields = $array;
						//echo $query;
						break;
				}
			}
			$query =  'SELECT '.$fields.' FROM '.$this->useTable.' WHERE 1=1 '.$WHERE;
			switch ($return)
			{
				case 'likeArray':
					$ret = $this->likeArray($query);
					break;
				case 'likeJSON':
					$ret = $this->likeJSON($this->likeArray($query));
					break;
			}
			echo $query.'<br />';
			return $ret;
		}
	}

	private function likeArray($query)
	{
		$result = mysql_query($query);
		if (mysql_errno()  > 0) {
			new Exception('Mysql Ошибка: '.mysql_error());
		}
		else {
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$ret[] = $row;
			}
			return $ret;
		}
	}

	private function likeJSON($arr)
	{

	}

	public function save($save)
	{
		$save[$this->name];
	}
}