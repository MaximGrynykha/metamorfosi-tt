<?php

use App\Http\Controllers as Controllers;
use App\Http\Middlewares as Middlewares;

return [
    '"GET~/"' => [ # COMPLETE
        'handler' => [Controllers\PostController::class, 'index']
    ],
    
    '"GET~/dashboard"' => [ # COMPLETED
        'handler' => [Controllers\DashboardController::class, 'index'],
        'middlewares' => [Middlewares\AuthMiddleware::class]
    ],

    '"GET~/posts/{id}"' => [ # COMPLETE
        'handler' => [Controllers\PostController::class, 'show']
    ],

    '"GET~/dashboard/posts/create"' => [ # COMPLETE
        'handler' => [Controllers\PostController::class, 'create'],
        'middlewares' => [Middlewares\AuthMiddleware::class]
    ],

    '"GET~/dashboard/posts/{id}/edit"' => [ # COMPLETED
        'handler' => [Controllers\PostController::class, 'edit'],
        'middlewares' => [Middlewares\AuthMiddleware::class]
    ],

    '"POST~/dashboard/posts"' => [ # COMPLETED
        'handler' => [Controllers\PostController::class, 'store'],
        'middlewares' => [Middlewares\AuthMiddleware::class]
    ],

    '"PUT~/dashboard/posts/{id}"' => [
        'handler' => [Controllers\PostController::class, 'update'],
        'middlewares' => [Middlewares\AuthMiddleware::class]
    ],
    
    '"DELETE~/dashboard/posts/{id}"' => [ # COMPLETE
        'handler' => [Controllers\PostController::class, 'destroy'],
        'middlewares' => [Middlewares\AuthMiddleware::class]
    ]
];