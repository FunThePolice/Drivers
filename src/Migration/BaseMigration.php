<?php

namespace App\Migration;

use App\Helpers\MyConfigHelper;

abstract class BaseMigration
{

    protected function getTemplate(): string
    {
        return '<?php

use App\Builder\Builder;
use App\Factories\DriverFactory;

return new class
{

    public function up(): void
        {
//            (new Builder(DriverFactory::create()))->rawQuery(
//            
//            );
        }

    public function down(): void
        {
//            (new Builder(DriverFactory::create()))->rawQuery(
//            
//            );
        }

};';
    }

    protected function getPath(string $migrationName): string
    {
        return '/home/funp/PhpstormProjects/Model-Pages/src/Migration/migrations/' . $migrationName . '.php';
    }

    protected function createMigrationFile(string $migrationName): void
    {
        file_put_contents($this->getPath($migrationName), $this->getTemplate());
    }

    protected function getInfo(): array
    {
        return json_decode(file_get_contents(MyConfigHelper::getMigrationConfig()['path']), true);
    }

    protected function storeInfo(array $info): void
    {
        file_put_contents(
            MyConfigHelper::getMigrationConfig()['path'],
            json_encode($info),
        );
    }
}