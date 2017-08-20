<?php

error_reporting(-1);

define('WWW', __DIR__);
define('ROOT', dirname(__DIR__));
define('ADMIN', dirname(__DIR__) . '/admin');
define('VIEWS', dirname(__DIR__) . '/app/views');
define('CORE', dirname(__DIR__) . '/app/core');
define('APP', dirname(__DIR__) . '/app');

$query = rtrim($_SERVER['QUERY_STRING'], '/');

spl_autoload_register(function ($class){
    $file = APP . "/controllers/$class.php";
    if (is_file($file)){
        require_once $file;
    }
    $file = APP . "/core/$class.php";
    if (is_file($file)){
        require_once $file;
    } 
    $file = APP . "/models/$class.php";
    if (is_file($file)){
        require_once $file;
    }
});

//собственные правила
Dispatcher::add('^bad$', ['method' => 'index']);

// правила default
Dispatcher::add('^$', ['method' => 'index']);
Dispatcher::add('^(?P<method>[a-z-]+)$');

//debug(Dispatcher::getRoutes());

Dispatcher::dispatch($query);
