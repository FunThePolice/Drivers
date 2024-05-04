<?php

namespace App\Factories;

use App\Database\Config;
use App\Database\Drivers\Contracts\IDriver;
use App\Database\Drivers\DriverWrapper;
use App\Database\Drivers\Mysqli\MySqlDriver;
use App\Database\Drivers\PDO\PdoDriver;
use App\Helpers\MyConfigHelper;

class DriverFactory
{

    public static function create(string $driver): IDriver
    {
        return match ($driver) {
            'mysqli' => new MySqlDriver(MyConfigHelper::getDbConfig(), new DriverWrapper()),
            'PDO' => new PdoDriver(MyConfigHelper::getDbConfig(), new DriverWrapper())
        };
    }

}