<?php

namespace App\Helpers;

class MyConfigHelper
{

    public static function getConfig()
    {
        $config = require __DIR__ . "/../Database/Drivers/config.php";
        $key = $config['selected_driver'];
        return $config['connections'][$key];
    }

}