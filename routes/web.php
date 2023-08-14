<?php

use App\Controllers\HomeController;

return [

    '/'   => [HomeController::class, 'index'],
    'json' => function () {
        return [
            'message' => 'hello world'
        ];
    }
];