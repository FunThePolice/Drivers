<?php

namespace App\Migration\DbMigration;

use App\Builder\Builder;
use App\Factories\DriverFactory;
use App\Helpers\MyConfigHelper;
use App\Migration\BaseMigration;
use App\Migration\Contracts\IMigrate;
use Carbon\Carbon;

class DbMigration extends BaseMigration implements IMigrate
{

    public function create(string $migrationName)
    {
        $fileName = Carbon::today()->format('Y_m_d_') . $migrationName;

        if (!file_exists($this->getPath($fileName))) {
            $this->createMigrationFile($fileName);
            $this->addRecordToDb($fileName);
            $this->addRecord($fileName);
        } else {
            throw new \Exception('File already exists.');
        }

    }

    public function migrateUp(): void
    {
        $info = $this->getInfo();

        foreach ($info['migrations'] as $batch => $migrations) {
            if ($info['current-batch'] === $batch) {

                foreach ($migrations as $migrationName) {
                    $migration = require __DIR__ . '/../../Migration/migrations/' . $migrationName . '.php';
                    $migration->up();
                }

                unset($info['migrations'][$batch]);
                $info['current-batch']++;
                $this->storeInfo($info);
            }

        }
    }

    public function migrateDown(): void
    {
        $latestMigrations = $this->getLatestMigrations();

        foreach ($latestMigrations['migrations'] as $batch => $migrations) {
            if ($this->getLatestBatch() === $batch) {

                foreach (array_reverse($migrations) as $migrationName) {
                    $migration = require __DIR__ . '/../../Migration/migrations/' . $migrationName . '.php';
                    $migration->down();
                }

                $info = $this->getInfo();
                $info['migrations'][$batch] = $migrations;
                $info['current-batch']--;
                $this->storeInfo($info);
            }
        }
    }

    protected function getLatestMigrations(): array
    {
       $migrations = $this->getBuilder()->read('migrations');
       foreach ($migrations as $migration) {
           if ($migration['batch'] === $this->getLatestBatch()) {
               $result['migrations'][$this->getLatestBatch()][] = $migration['migration'];
           }
       }
       return $result;
    }
    protected function addRecordToDb(string $migration): void
    {
        $info = $this->getInfo();
        $data = [
            'migration' => $migration,
            'batch' => $info['current-batch']
        ];
        $this->getBuilder()->create('migrations', $data);
    }

    protected function getLatestBatch(): int
    {
        $row = $this->getBuilder()->rawQuery('select MAX(batch) from migrations');
        return $row['MAX(batch)'];
    }

    protected function addRecord(string $fileName): void
    {
        $info = $this->getInfo();
        $batch = $info['current-batch'] ?? 1;
        $info['migrations'][$batch][] = $fileName;
        $this->storeInfo($info);
    }

    protected function getBuilder(): Builder
    {
        return new Builder(DriverFactory::create());
    }

}