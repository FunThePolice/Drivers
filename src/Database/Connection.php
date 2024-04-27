<?php

namespace App\Database;

use App\Database\Drivers\DriverWrapper;

class Connection
{

    protected Config $config;

    protected DriverWrapper $wrapper;

    public function __construct(Config $config, DriverWrapper $wrapper)
    {
        $this->config = $config;
        $this->wrapper = $wrapper;

    }
   public function connect($driver)
   {
       return new $driver($this->config, $this->wrapper);
   }

}