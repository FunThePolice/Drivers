<?php

namespace App\Database\Drivers\Mysqli;

use App\Database\Config;
use App\Database\Connection;
use App\Database\Drivers\Contracts\IDriver;
use App\Database\Drivers\DriverWrapper;
use mysqli;

class MySqlDriver extends Connection implements IDriver

{
    private mysqli $db;
    protected DriverWrapper $wrapper;
    public function __construct(Config $config, DriverWrapper $wrapper)
    {
        parent::__construct($config,$wrapper);
        $this->db = $this->connect();
    }

    public function connect(): mysqli
   {
       mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

       $db = new mysqli(
           $this->config->getHost(),
           $this->config->getUserName(),
           $this->config->getPassword(),
           $this->config->getDatabase(),
           $this->config->getPort()
       );

       $db->set_charset($this->config->getCharset());
       $db->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);

       return $db;
   }

    public function disconnect($db): void
    {
        $db->close();
    }

    public function create(string $table, array $data): void
    {
        $this->wrapper->prepareDataForInsert($data);
        $stmt = $this->db->prepare("INSERT INTO $table (" .
            $this->wrapper->getFields() . ") VALUES (" .
            $this->wrapper->getPlaceholders() . ")");
        $stmt->execute(...$this->wrapper->getParams());
    }

    public function read(string $table, string $condition, string $value): array
    {
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE  $condition = ?");
        $stmt->execute([$value]);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function readAll(string $table): array
    {
        $stmt = $this->db->prepare("SELECT * FROM $table");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update(string $table, array $data, array $condition): void
    {
        $this->wrapper->prepareDataForUpdate($data, $condition);
        $stmt = $this->db->prepare("UPDATE $table SET " .
            $this->wrapper->getFields() . " WHERE " .
            $this->wrapper->getColumn() ." ");
        $stmt->execute(...$this->wrapper->getParams());
    }

    public function delete(string $table, string $condition, string $value): void
    {
        $stmt = $this->db->prepare("DELETE FROM $table WHERE $condition = ?");
        $stmt->execute([$value]);
    }

    public function deleteAll(string $table): void
    {
        $stmt = $this->db->prepare("DELETE FROM $table");
        $stmt->execute();
    }
}