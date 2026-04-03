<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/app.php';
\App\Core\Database::getInstance($config['db']);

$seeder = new \App\Database\DatabaseSeeder();
$seeder->run();
