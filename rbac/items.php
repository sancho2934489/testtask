<?php
return [
    'login' => [
        'type' => 2,
    ],
    'logout' => [
        'type' => 2,
    ],
    'index' => [
        'type' => 2,
    ],
    'view' => [
        'type' => 2,
    ],
    'error' => [
        'type' => 2,
    ],
    'update' => [
        'type' => 2,
    ],
    'create' => [
        'type' => 2,
    ],
    'delete' => [
        'type' => 2,
    ],
    'active' => [
        'type' => 2,
    ],
    'time' => [
        'type' => 2,
    ],
    'guest' => [
        'type' => 1,
        'children' => [
            'login',
            'logout',
            'error',
            'view',
        ],
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'guest',
            'update',
            'index',
            'create',
            'time',
            'active',
        ],
    ],
    'admin2' => [
        'type' => 1,
        'children' => [
            'admin',
            'delete',
        ],
    ],
];
