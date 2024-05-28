<?php

namespace App\Migration\LocalMigration;

use App\Migration\BaseMigration;
use App\Migration\Contracts\IMigrate;
use App\Migration\Migration;

class LocalMigration extends BaseMigration implements IMigrate
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

    protected function getLastBatch(): int
    {
        $info = $this->readMigrationFile();

        if (!isset($info['applied'])) {
            $info['applied'] = [];
        }

        if (!empty($info['applied'])) {
            return max(array_keys($info['applied']));
        }  else {
            return 1;
        }

    }

    protected function getCurrentBatch(): int
    {
        $info = $this->readMigrationFile();

        if (!isset($info['migrations'])) {
            $info['migrations'] = [];
        }

        if (!empty($info['migrations'])) {
            return max(array_keys($info['migrations']));
        }  else {
            return $this->getLastBatch() + 1;
        }
    }

    protected function applyMigration(Migration $migration): void
    {
        $info = $this->readMigrationFile();

        if (!isset($info['applied'][$migration->getBatch()])) {
            $info['applied'][$migration->getBatch()] = [];
        }

        $info['applied'][$migration->getBatch()][] =
            [
                'migration'=> $migration->getMigrationName(),
                'batch' => $migration->getBatch(),
            ];

        $this->writeMigrationFile($info);
    }

    protected function rollbackMigrationsByBatch(int $batch): void
    {
        $info = $this->readMigrationFile();

        if (!isset($info['applied'][$batch])) {
            throw new \Exception('Batch does not exist in applied migrations');
        }

        unset($info['applied'][$batch]);
        $this->writeMigrationFile($info);
    }

    protected function getLatestMigrations(): array
    {

        if (!isset($this->readMigrationFile()['applied'][$this->getLastBatch()])) {
            throw new \Exception('No migrations found on given batch');
        }

        foreach ($this->readMigrationFile()['applied'][$this->getLastBatch()] as $migration) {
            $result[] = new Migration($migration['batch'], $migration['migration']);
        }

        return $result;
    }

}