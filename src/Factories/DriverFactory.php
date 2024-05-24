<?php

namespace App\Factories;

use App\Database\Drivers\Contracts\IDriver;
use App\Helpers\MyConfigHelper;
use ReflectionClass;
use ReflectionException;

class DriverFactory
{

    /**
     * @throws ReflectionException
     */
    public static function create(): IDriver
    {
        $config = MyConfigHelper::getDbConfig();
        $driverClassName = $config->getDriver() ?? false;
        $reflectionClass = new ReflectionClass($driverClassName);

        if (!$reflectionClass->isInstantiable()) {
            throw new CouldNotInstantiateDriverClassException();
        }

        return new $driverClassName();
    }

}