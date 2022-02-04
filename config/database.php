<?php

return [
    'dsn' => sprintf('%s:host=%s;port=%s;dbname=%s', 
                getenv('DB_CONNECTION'), 
                getenv('DB_HOST'), 
                getenv('DB_PORT'), 
                getenv('DB_DATABASE')
            ),
    'user' => getenv('DB_USERNAME'),
    'pass' => getenv('DB_PASSWORD'),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    ]) : []
];