<?php

use App\Http\Controllers as Controllers;
use App\Http\Middlewares as Middlewares;

return [
    '"GET~/"' => [
        'handler' => [Controllers\PostController::class, 'index']
    ],
    
    '"GET~/dashboard"' => [
        'handler' => [Controllers\DashboardController::class, 'index'],
        'middlewares' => [Middlewares\AuthMiddleware::class]
    ],

    '"GET~/posts/{id}"' => [
        'handler' => [Controllers\PostController::class, 'show']
    ],

    '"GET~/dashboard/posts/create"' => [
        'handler' => [Controllers\PostController::class, 'create'],
        'middlewares' => [Middlewares\AuthMiddleware::class]
    ],

    '"GET~/dashboard/posts/{id}/edit"' => [
        'handler' => [Controllers\PostController::class, 'edit'],
        'middlewares' => [Middlewares\AuthMiddleware::class]
    ],

    '"POST~/dashboard/posts"' => [
        'handler' => [Controllers\PostController::class, 'store'],
        'middlewares' => [Middlewares\AuthMiddleware::class]
    ],

    '"PUT~/dashboard/posts/{id}"' => [
        'handler' => [Controllers\PostController::class, 'update'],
        'middlewares' => [Middlewares\AuthMiddleware::class]
    ],
    
    '"DELETE~/dashboard/posts/{id}"' => [
        'handler' => [Controllers\PostController::class, 'destroy'],
        'middlewares' => [Middlewares\AuthMiddleware::class]
    ]
];