<?php

namespace App\Helpers;

use App\Database\Config;

class MyConfigHelper
{

    public static function getConfig()
    {
        $config = require __DIR__ . "/../Database/Drivers/config.php";
        $key = $config['selected_driver'];
        return $config['connections'][$key];
    }

    public static function getDbConfig(): Config
    {
        $configHelper = MyConfigHelper::getConfig();

         return (new Config())
             ->setHost($configHelper['host'])
             ->setPort($configHelper['port'])
             ->setDatabase($configHelper['database'])
             ->setUserName($configHelper['username'])
             ->setPassword($configHelper['password'])
             ->setDriver($configHelper['driver']);
    }

}