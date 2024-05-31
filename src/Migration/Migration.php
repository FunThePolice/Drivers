<?php

namespace App\Migration;

class Migration
{

    public readonly int $batch;

    public readonly string $migration;

    public function __construct(int $batch, string $migration)
    {
        $this->batch = $batch;
        $this->migration = $migration;
    }

    public function getBatch(): int
    {
        return $this->batch;
    }

    public function getMigrationName(): string
    {
        return $this->migration;
    }

}