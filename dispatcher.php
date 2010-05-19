<?php

class Dispatcher
{
	public $controllerName;
	public $actionName;
	public $params;
	public $controller;

	public function __construct()
	{
		$uri = explode(DS, trim($_REQUEST["url"], DS));
			
		$this->controllerName = $uri[0];
		$this->actionName = !empty($uri[1]) ? $uri[1]:'index';
		$this->params = array_slice($uri, 2);

		try
		{
			$this->loadController($this->controllerName);
			$controllerClass = $this->controllerName.'Controller';
			$this->controller = new $controllerClass();
			$this->controller->action = $this->actionName;
			$this->dispatchMethod($this->actionName, $this->params);
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}

	private function loadController($controller)
	{
		if(!file_exists(CONTROLLERS_DIR.$controller.'Controller.php'))
		{
			throw new Exception('Создайте файл '.CONTROLLERS_DIR.$controller.'Controller.php ');
		}
		else
		{
			require_once((CONTROLLERS_DIR.$controller.'Controller.php'));
		}
	}

	/**
	 * Thanks to cakephp
	 *
	 * @param unknown_type $method
	 * @param unknown_type $params
	 * @return unknown
	 */
	function dispatchMethod($method, $params = array()) {
		switch (count($params)) {
			case 0:
				return $this->controller->{$method}();
			case 1:
				return $this->controller->{$method}($params[0]);
			case 2:
				return $this->controller->{$method}($params[0], $params[1]);
			case 3:
				return $this->controller->{$method}($params[0], $params[1], $params[2]);
			case 4:
				return $this->controller->{$method}($params[0], $params[1], $params[2], $params[3]);
			case 5:
				return $this->controller->{$method}($params[0], $params[1], $params[2], $params[3], $params[4]);
			default:
				return call_user_func_array(array(&$this, $method), $params);
				break;
		}
	}
}
