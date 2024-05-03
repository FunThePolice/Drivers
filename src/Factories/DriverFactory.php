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
        $configHelper = MyConfigHelper::getConfig();

        $config = (new Config())
            ->setHost($configHelper['host'])
            ->setPort($configHelper['port'])
            ->setDatabase($configHelper['database'])
            ->setUserName($configHelper['username'])
            ->setPassword($configHelper['password']);

        return match ($driver) {
            'mysqli' => new MySqlDriver($config, new DriverWrapper()),
            'PDO' => new PdoDriver($config, new DriverWrapper())
        };
    }

}