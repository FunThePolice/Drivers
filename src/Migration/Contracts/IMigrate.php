<?php

namespace App\Migration\Contracts;

interface IMigrate
{

    public function create(string $migrationName);

    public function migrateUp();

    public function migrateDown();

}