<?php

return [

    'selected_driver' => 'mysqli',

    'connections' => [

        'mysqli' => [
            'driver' => \App\Database\Drivers\Mysqli\MySqlDriver::class,
            'host' => 'localhost',
            'port' => 3306,
            'database' => 'users',
            'username' => 'root',
            'password' => '',
        ],

        'PDO' => [
            'driver' => \App\Database\Drivers\PDO\PdoDriver::class,
            'host' => 'localhost',
            'port' => 3306,
            'database' => 'users',
            'username' => 'root',
            'password' => '',
        ]
    ]
];
