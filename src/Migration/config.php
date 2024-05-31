<?php

return [

    'selected' => 'database',

    'local' => [
        'path' => dirname(__DIR__) . '/Migration/LocalMigration/LocalMigrationInfo',
        'handler' => \App\Migration\LocalMigration\LocalMigration::class
    ],

    'database' => [
        'handler' => \App\Migration\DbMigration\DbMigration::class
    ]

];