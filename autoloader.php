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
