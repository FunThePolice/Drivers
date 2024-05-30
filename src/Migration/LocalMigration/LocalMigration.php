<?php

namespace App\Migration\LocalMigration;

use App\Helpers\MyConfigHelper;
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

    public function migrateFresh(): void
    {
        $this->refreshMigrations();
    }

    protected function getLastBatch(): int
    {
        $info = $this->readMigrationFile();

        if (!isset($info['migrations'])) {
            $info['migrations'] = [];
        }

        if (!empty($info['migrations'])) {
            foreach ($info['migrations'] as $migration) {
                $batches[] = $migration['batch'];
            }
            return max($batches);
        }  else {
            return 0;
        }

    }

    protected function getCurrentBatch(): int
    {
      $lastBatch = $this->getLastBatch();

      return ++$lastBatch;
    }

    protected function applyMigration(Migration $migration): void
    {
        $info = $this->readMigrationFile();

        if (!isset($info['migrations'])) {
            $info['migrations'] = [];
        }

        $info['migrations'][] = $migration;
        $this->writeMigrationFile($info);
    }

    protected function rollbackMigrationsByBatch(int $batch): void
    {
        $info = $this->readMigrationFile();

        if (!isset($info['migrations'])) {
            throw new \Exception('Batch does not exist in applied migrations');
        }

        foreach ($info['migrations'] as $migration) {
            if ($migration['batch'] === $batch) {
                foreach (array_keys($info['migrations'], $migration) as $key) {
                    unset($info['migrations'][$key]);
                }
            }
        }

        $this->writeMigrationFile($info);
    }

    protected function getLatestMigrations(): array
    {

        if (!isset($this->readMigrationFile()['migrations'])) {
            throw new \Exception('No migrations found on given batch');
        }

        foreach ($this->readMigrationFile()['migrations'] as $migration) {
            if ($migration['batch'] === $this->getLastBatch()) {
                $result[] = new Migration($migration['batch'], $migration['migration']);
            }
        }

        return $result;
    }

    protected function getAppliedMigrations(): array
    {
        if (!isset($this->readMigrationFile()['migrations'])) {
            throw new \Exception('No migrations found on given batch');
        }

        foreach ($this->readMigrationFile()['migrations'] as $migration) {
            $result[] = new Migration($migration['batch'], $migration['migration']);
        }

        return $result;
    }

    protected function writeMigrationFile(array $data): void
    {
        if (!isset(MyConfigHelper::getMigrationConfig()['path'])) {
            throw new \Exception('File path for migration info is not defined.');
        }

        file_put_contents(
            MyConfigHelper::getMigrationConfig()['path'],
            json_encode($data, JSON_PRETTY_PRINT),
        );
    }

    protected function readMigrationFile(): array
    {
        if (!isset(MyConfigHelper::getMigrationConfig()['path'])) {
            throw new \Exception('File path for migration info is not defined.');
        }

        return json_decode(file_get_contents(MyConfigHelper::getMigrationConfig()['path']) , true);
    }

    protected function getAppliedMigrationsList(): array
    {
        $info = $this->readMigrationFile();

        if (!isset($info['migrations'])) {
            $info['migrations'] = [];
        }

        foreach ($info['migrations'] as $migration) {
            $result[] = $migration['migration'];
        }

        return $result ?? [];
    }

}