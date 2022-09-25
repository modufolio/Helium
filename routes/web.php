<?php

return [

    '/'   => 'homepage',
    'api/list' => 'api',
    'json' => function () {
        return [
            'message' => 'hello world'
        ];
    }
];