<?php

declare(strict_types=1);

return [
    'db' => [
        'host' => getenv('DB_HOST') ?: 'blog_mysql',
        'port' => getenv('DB_PORT') ?: '3306',
        'name' => getenv('DB_NAME') ?: 'blog',
        'user' => getenv('DB_USER') ?: 'blog_user',
        'password' => getenv('DB_PASSWORD') ?: 'blog_password',
    ],
    'app' => [
        'per_page' => 9,
    ],
];
