<?php

return [

    'selected' => 'local',

    'local' => [
        'path' => dirname(__DIR__) . '/Migration/LocalMigration/LocalMigrationInfo',
        'handler' => \App\Migration\LocalMigration\LocalMigration::class
    ],

    'database' => [
        'path' => dirname(__DIR__) . '/Migration/DbMigration/DbMigrationInfo',
        'handler' => \App\Migration\DbMigration\DbMigration::class
    ]

];