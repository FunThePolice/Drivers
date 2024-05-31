<?php

namespace App\Migration;

use App\Exeptions\NoMigrationsToApply;
use App\Services\FileService;
use Carbon\Carbon;

abstract class BaseMigration
{

    const MIGRATION_TEMPLATE_PATH = '/Migration/migrationTemplate.php';

    const BASE_MIGRATION_PATH = '/Migration/migrations/';

    /**
     * @throws \Exception
     */
    protected function createMigration(string $migrationName): void
    {
        if (!file_exists($this->getPathToMigrations($migrationName))) {
            $this->createMigrationFile($migrationName);
        } else {
            throw new \Exception('File already exists.');
        }
    }

    protected function applyMigrations(): void
    {
        foreach ($this->getMigrationsToApply() as $migration) {
            $migrationFile = $this->getMigrationFile($migration->getMigrationName());
            $migrationFile->up();
            $this->applyMigration($migration);
        }
    }

    protected function rollbackMigrations(): void
    {
        foreach (array_reverse($this->getLatestMigrations()) as $migrationInfo) {
            $migrationFile = $this->getMigrationFile($migrationInfo->getMigrationName());
            $migrationFile->down();
            $this->rollbackMigrationsByBatch($migrationInfo->getBatch());
        }
    }

    protected function refreshMigrations(): void
    {
        foreach ($this->getAppliedMigrations() as $migrationInfo) {
            $migrationFile = $this->getMigrationFile($migrationInfo->getMigrationName());
            $migrationFile->up();
        }
    }

    protected function getMigrationFilesName(): array
    {
        $content = FileService::getDirContent(static::BASE_MIGRATION_PATH);
        foreach ($content as $file) {
            $file = substr($file, 0 , -4);
            $result[] = $file;
        }

        return $result;
    }

    protected function getTemplate(): string
    {
        return FileService::getFile(static::MIGRATION_TEMPLATE_PATH);
    }

    protected function getPathToMigrations(string $migrationName): string
    {
        return FileService::getFilePath(static::BASE_MIGRATION_PATH, $this->createFileName($migrationName));
    }

    protected function getMigrationFile(string $migrationName)
    {
        return FileService::getFile(static::BASE_MIGRATION_PATH . $migrationName . '.php');
    }

    protected function createMigrationFile(string $migrationName): void
    {
        FileService::createFile($this->getPathToMigrations($migrationName), $this->getTemplate());
    }

    protected function createFileName($migrationName): string
    {
        return Carbon::now()->format('Y_m_d_His_') . $migrationName;
    }

    protected function getMigrationsToApply(): array
    {
        $migrations = array_diff($this->getMigrationFilesName(), $this->getAppliedMigrationsList());

        if (empty($migrations)) {
            throw new NoMigrationsToApply();
        }

        foreach ($migrations as $migration) {
            $result[] = new Migration($this->getCurrentBatch(), $migration);
        }

        return $result;
    }
}