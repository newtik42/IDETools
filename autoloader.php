<?php

spl_autoload_register(function ($class_name) {
    $classs = explode('\\', $class_name);
    if(current($classs) != 'NewTik') return;
    array_shift($classs);
    if(current($classs) != 'IDETools') return;
    array_shift($classs);    
    $file = __DIR__ . '/src/' . implode('/', $classs) . '.php';
    include_once $file;
});

set_error_handler(function($code, $message, $file, $line) {
	// error suppressed with @
	if (error_reporting() === 0) {
		return false;
	}

	switch ($code) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$error = 'Notice';
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$error = 'Warning';
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$error = 'Fatal Error';
			break;
		default:
			$error = 'Unknown';
			break;
	}
    $file = str_replace(__DIR__, 'IDETools', $file);
    if(php_sapi_name() === 'cli')
        echo $error . ': ' . $message . ' in ' . $file . ' on line ' . $line . PHP_EOL;
    else
        echo '<b>' . $error . '</b>: ' . $message . ' in <b>' . $file . '</b> on line <b>' . $line . '</b>';
	
	return true;
});
