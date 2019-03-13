<?php

define('BP', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);

// Autoloader
spl_autoload_register(function ($class) {
    $class = lcfirst($class);
    $filename = BP . DS . str_replace('\\', DS, $class) . '.php';

    if (file_exists($filename)) {
        require_once $filename;
    }
});
