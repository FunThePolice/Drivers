<?php

return [

    'selected' => 'database',

    'local' => [
        'path' => '/home/funp/PhpstormProjects/Model-Pages/src/Migration/LocalMigration/LocalMigrationInfo',
        'handler' => \App\Migration\LocalMigration\LocalMigration::class
    ],

    'database' => [
        'path' => '/home/funp/PhpstormProjects/Model-Pages/src/Migration/DbMigration/DbMigrationInfo',
        'handler' => \App\Migration\DbMigration\DbMigration::class
    ]

];