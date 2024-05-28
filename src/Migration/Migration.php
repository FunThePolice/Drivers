<?php

namespace App\Migration;

class Migration
{

    public readonly int $batch;

    public readonly string $migrationName;

    public function __construct(int $batch, string $migrationName)
    {
        $this->batch = $batch;
        $this->migrationName = $migrationName;
    }

    public function getBatch(): int
    {
        return $this->batch;
    }

    public function getMigrationName(): string
    {
        return $this->migrationName;
    }

}