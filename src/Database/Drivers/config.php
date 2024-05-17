<?php

use App\Database\Drivers\Mysqli\MySqlDriver;
use App\Database\Drivers\PDO\PdoDriver;

return [

    'selected_driver' => 'PDO',

    'connections' => [

        'mysqli' => [
            'driver' => MySqlDriver::class,
            'host' => 'localhost',
            'port' => 3306,
            'database' => 'users',
            'username' => 'root',
            'password' => '',
        ],

        'PDO' => [
            'driver' => PdoDriver::class,
            'host' => 'localhost',
            'port' => 3306,
            'database' => 'users',
            'username' => 'root',
            'password' => '',
        ]

    ]

];
