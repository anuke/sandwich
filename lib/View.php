<?php

class View
{
	public $_vars;
	
	public function __construct(&$constructor)
	{
		$this->_vars = $constructor->viewVars;
	}
	
	public function render()
	{
		foreach ($this->_vars as $variable => $value)
		{
			$$variable = $value;
		}
	}
}