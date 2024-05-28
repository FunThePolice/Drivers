<?php

namespace App\Migration;

use App\Helpers\MyConfigHelper;
use App\Services\FileService;
use Carbon\Carbon;

abstract class BaseMigration
{

    /**
     * @throws \Exception
     */
    protected function createMigration(string $migrationName): void
    {

        if (!file_exists($this->getPathToMigrations($migrationName))) {
            $this->createMigrationFile($migrationName);
            $this->createMigrationInfo($this->getCurrentBatch(), $migrationName);
        } else {
            throw new \Exception('File already exists.');
        }
    }

    public function applyMigrations(): void
    {
        foreach ($this->getMigrationsByBatch($this->getCurrentBatch()) as $migrationInfo) {
            $migrationFile = $this->getMigrationFile($migrationInfo->getMigrationName());
            $migrationFile->up();
            $this->applyMigration($migrationInfo);
            $this->removeBatchFromInfoFile($migrationInfo->getBatch());
        }
    }

    public function rollbackMigrations(): void
    {

        foreach (array_reverse($this->getLatestMigrations()) as $migrationInfo) {
            $migrationFile = $this->getMigrationFile($migrationInfo->getMigrationName());
            $migrationFile->down();
        }

        foreach ($this->getLatestMigrations() as $migrationInfo) {
            $this->addMigrationToInfoFile($migrationInfo);
            $this->rollbackMigrationsByBatch($migrationInfo->getBatch());
        }

    }

    protected function getTemplate(): string
    {
        return FileService::getFile('/Migration/migrationTemplate.php');
    }

    protected function getPathToMigrations(string $migrationName): string
    {
        return FileService::getFilePath('/Migration/migrations/', $this->createFileName($migrationName));
    }

    protected function getMigrationFile(string $migrationName)
    {
        return FileService::getFile('/Migration/migrations/' . $migrationName . '.php');
    }

    protected function createMigrationFile(string $migrationName): void
    {
        FileService::createFile($this->getPathToMigrations($migrationName), $this->getTemplate());
    }

    protected function createFileName($migrationName): string
    {
        return Carbon::today()->format('Y_m_d_') . $migrationName;
    }

    /**
     * @throws \Exception
     */
    protected function getMigrationsByBatch(int $batch): array
    {
        $data = $this->readMigrationFile();

        if (!isset($data['migrations'])) {
            $data['migrations'] = [];
        }

        if (!isset($data['migrations'][$batch])) {
            throw new \Exception('No migrations were found for batch ' . $batch);
        }

        foreach ($data['migrations'][$batch] as $migration) {
            if ($migration['batch'] === $batch) {
                $result[] = new Migration($batch, $migration['migrationName']);
            }
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
            json_encode($data),
        );
    }

    protected function readMigrationFile(): array
    {
        if (!isset(MyConfigHelper::getMigrationConfig()['path'])) {
            throw new \Exception('File path for migration info is not defined.');
        }

        return json_decode(file_get_contents(MyConfigHelper::getMigrationConfig()['path']) , true);
    }

    protected function addMigrationToInfoFile(Migration $migration): void
    {
       $file = $this->readMigrationFile();

       if (!isset($file['migrations'][$migration->getBatch()])) {
           $file['migrations'][$migration->getBatch()] = [];
       }

        $file['migrations'][$migration->getBatch()][] = $migration;
        $this->writeMigrationFile($file);
    }

    protected function createMigrationInfo(int $batch, string $migrationName): void
    {
        $this->addMigrationToInfoFile(new Migration($batch, $this->createFileName($migrationName)));
    }

    protected function removeBatchFromInfoFile(int $batch): void
    {
        $file = $this->readMigrationFile();

        if (!isset($file['migrations'][$batch])) {
            throw new \Exception('Given batch does not exist in migration file.');
        }

        unset($file['migrations'][$batch]);
        $this->writeMigrationFile($file);
    }

}