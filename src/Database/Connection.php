<?php

namespace App\Database;



use App\Database\Drivers\DriverWrapper;
use App\Database\Drivers\Mysqli\MySqlDriver;
use App\Database\Drivers\PDO\PdoDriver;

class Connection
{

    protected Config $config;
    protected DriverWrapper $wrapper;
    public function __construct(Config $config,DriverWrapper $wrapper)
    {
        $this->config = $config;
        $this->wrapper = $wrapper;
    }
    public function mysqliConnect(): MySqlDriver
    {
        return new MySqlDriver($this->config, $this->wrapper);
    }

    public function pdoConnect(): PdoDriver
    {
        return new PdoDriver($this->config, $this->wrapper);
    }

}