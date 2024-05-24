<?php

namespace App\Factories;

use App\Helpers\MyConfigHelper;
use ReflectionClass;
use ReflectionException;

class MigrationFactory
{

    /**
     * @throws ReflectionException
     */
    public static function create()
    {
        $config = MyConfigHelper::getMigrationConfig();
        $handlerClassName = $config['handler'] ?? false;
        $reflectionClass = new ReflectionClass($handlerClassName);

        if (!$reflectionClass->isInstantiable()) {
            throw new CouldNotInstantiateHandlerClassException();
        }

        return new $handlerClassName();
    }

}