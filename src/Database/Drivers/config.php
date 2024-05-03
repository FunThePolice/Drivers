<?php

return [

    'selected_driver' => 'mysqli',

    'connections' => [

        'mysqli' => [
            'driver' => 'mysqli',
            'host' => 'localhost',
            'port' => 3306,
            'database' => 'users',
            'username' => 'root',
            'password' => '',
        ],

        'PDO' => [
            'driver' => 'PDO',
            'host' => 'localhost',
            'port' => 3306,
            'database' => 'users',
            'username' => 'root',
            'password' => '',
        ]
    ]
];
