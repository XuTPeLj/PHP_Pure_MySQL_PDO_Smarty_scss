<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/app.php';

\App\Core\Database::getInstance($config['db']);
\App\Core\Controller::setConfig($config);

$router = new \App\Core\Router();

$router->get('/', \App\Controllers\HomeController::class, 'index');
$router->get('/category/{id}', \App\Controllers\CategoryController::class, 'show');
$router->get('/article/{id}', \App\Controllers\ArticleController::class, 'show');

$router->dispatch($_SERVER['REQUEST_URI'] ?? '/');
