<?php

require __DIR__.'/../../vendor/autoload.php';

use App\Factories\MigrationFactory;

$migration = MigrationFactory::create();

switch ($argv[1]) {
    case 'create':
        $migration->create($argv[2]);
        break;
        case 'migrate':
            $migration->migrateUp();
        break;
        case 'migrate:rollback':
            $migration->migrateDown();
            break;
            case 'migrate:fresh':
        $migration->migrateFresh();
        break;

}
