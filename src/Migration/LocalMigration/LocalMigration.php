<?php

namespace App\Migration\LocalMigration;

use App\Helpers\MyConfigHelper;
use App\Migration\BaseMigration;
use App\Migration\Contracts\IMigrate;
use Carbon\Carbon;

class LocalMigration extends BaseMigration implements IMigrate
{

    public function create(string $migrationName): void
    {
        $fileName = Carbon::today()->format('Y_m_d_') . $migrationName;

        if (!file_exists($this->getPath($fileName))) {
            $this->createMigrationFile($fileName);
            $this->addRecord($fileName);
        } else {
            throw new \Exception('File already exists.');
        }
    }

    public function migrateUp(): void
    {
        $info = $this->getInfo();

        foreach ($info['non-applied'] as $batch => $migrations) {
            if ($info['current-batch'] === $batch) {

                foreach ($migrations as $migrationName) {
                    $migration = require __DIR__ . '/../../Migration/migrations/' . $migrationName . '.php';
                    $migration->up();
                }

                $info['applied'][$batch] = $migrations;
                unset($info['non-applied'][$batch]);
                $info['current-batch']++;
                $this->storeInfo($info);
            }

        }
    }

    public function migrateDown(): void
    {
        $info = $this->getInfo();
        $currentBatch = --$info['current-batch'];

        foreach ($info['applied'] as $batch => $migrations) {
            if ($currentBatch === $batch) {

                foreach (array_reverse($migrations) as $migrationName) {
                    $migration = require __DIR__ . '/../../Migration/migrations/' . $migrationName . '.php';
                    $migration->down();
                }

                $info['non-applied'][$batch] = $migrations;
                unset($info['applied'][$batch]);
                $this->storeInfo($info);
            }

        }
    }

    protected function addRecord(string $fileName): void
    {
        $info = $this->getInfo();
        $batch = $info['current-batch'] ?? 1;
        $info['non-applied'][$batch][] = $fileName;
        $this->storeInfo($info);
    }

}