<?php

namespace App\Migration\DbMigration;

use App\Builder\Builder;
use App\Factories\DriverFactory;
use App\Migration\BaseMigration;
use App\Migration\Contracts\IMigrate;
use App\Migration\Migration;

class DbMigration extends BaseMigration implements IMigrate
{

    /**
     * @throws \Exception
     */
    public function create(string $migrationName): void
    {
        $this->createMigration($migrationName);
    }

    public function migrateUp(): void
    {
        $this->applyMigrations();
    }

    public function migrateDown(): void
    {
        $this->rollbackMigrations();
    }

    protected function getLatestMigrations(): array
    {
        $rows = $this->getBuilder()->rawQuery('select * from migrations where batch=' . $this->getLastBatch());
        foreach ($rows as $row) {
            $result[] = new Migration($row['batch'], $row['migration']);
        }

        return $result;
    }

    protected function applyMigration(Migration $migration): void
    {
        $this->getBuilder()->create(
            'migrations',
            [
                'migration' => $migration->getMigrationName(),
                'batch' => $migration->getBatch(),
            ]
        );
    }

    protected function rollbackMigrationsByBatch(int $batch): void
    {
        $this->getBuilder()->rawQuery('delete from migrations where batch=' . $batch);
    }

    protected function getLastBatch(): int
    {
        $row = $this->getBuilder()->rawQuery('select MAX(batch) from migrations');
        return $row['MAX(batch)'] ?? 1;
    }

    protected function getCurrentBatch(): int
    {
        $latestBatch = $this->getLastBatch();

        if ($latestBatch === 1) {
            return $latestBatch;
        } else {
            return ++$latestBatch;
        }

    }

    protected function getBuilder(): Builder
    {
        return new Builder(DriverFactory::create());
    }

}