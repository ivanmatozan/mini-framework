<?php

define('BP', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);

// Autoloader
spl_autoload_register(function ($class) {
    $class = lcfirst($class);
    $filename = BP . DS . str_replace('\\', DS, $class) . '.php';

    if (file_exists($filename)) {
        require $filename;
    }
});

$app = new App\Core\Application();
$container = $app->getContainer();

$container['errorHandler'] = function () {
    die(404);
};

$container['config'] = function () {
    return [
        'db_driver'   => 'mysql',
        'db_host'     => 'localhost',
        'db_name'     => 'project',
        'db_username' => 'root',
        'db_password' => 'root'
    ];
};

$container->db = function ($container) {
    $config = $container->config;

    return new \PDO(
        "{$config['db_driver']}:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_username'],
        $config['db_password']
    );
};

$app->get('/', function () {
    echo 'Home';
});

$app->post('/register', function () {
    echo 'Register';
});

$app->map('/users', function () {
    echo 'Users';
}, ['GET', 'POST']);

$app->run();
