<?php

$app->get('/', [\App\Controllers\HomeController::class, 'index']);

$app->map('/customer/json-list', [new \App\Controllers\CustomerController($container->db), 'jsonList'], ['GET', 'POST']);

$app->get('/home', function (\App\Core\Response $response) {
    return 'Home';
});

$app->post('/register', function () {
    return 'Register';
});
