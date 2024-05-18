<?php

namespace App\Logger;

use Carbon\Carbon;

class Logger
{

    public static function log(string $error): void
    {
        $config = require 'loggerConfig.php';
        $filePath = $config['path'] . Carbon::today()->format('Y-m-d') . '_log';
        $error = sprintf('[%s] %s', Carbon::now()->toDate()->format('Y-m-d H:i:s'), $error);
        file_put_contents($filePath, $error . "\n", FILE_APPEND);
    }

}