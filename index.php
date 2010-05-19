<?php
$TIME_START = microtime();
define('DS', '/');
define('APPDIR', 'app');
define('CONTROLLERS_DIR', APPDIR.'/controllers/');
define('MODELS_DIR', APPDIR.'/models/');
define('VIEWS_DIR', APPDIR.'/views/');
define('CONFIG_DIR', APPDIR.'/config/');

function debug($var)
{
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}

function __autoload($className)
{
	if (preg_match('/^(App|Object)/', $className)) {
		require_once('lib/'.$className.'.php');
	}
	elseif(preg_match('/DbConfig/', $className))
	{
		require_once(CONFIG_DIR.strtolower($className).'.php');
	}
	elseif (preg_match('/Controller/', $className))
	{
		require_once(CONTROLLERS_DIR.strtolower($className).'.php');
	}
	else
	{
		require_once(MODELS_DIR.strtolower($className).'.php');
	}
}

require_once('dispatcher.php');
$dispatcher = new Dispatcher();
$time_end = microtime();

echo "\n".$time_end - $TIME_START.' sec ';