<?php

namespace App\Database\Drivers\PDO;

use App\Database\Config;
use App\Database\Connection;
use App\Database\Drivers\Contracts\IDriver;
use App\Database\Drivers\DriverWrapper;
use PDO;

class PdoDriver extends Connection implements IDriver
{
    private $db;
    protected DriverWrapper $wrapper;

    public function __construct(Config $config, DriverWrapper $wrapper)
    {
        parent::__construct($config,$wrapper);
        $this->db = $this->connect();
    }
    public function connect(): PDO
    {
        $dsn = "mysql:host=". $this->config->getHost() .
            ";dbname=". $this->config->getDatabase() .
            ";charset=". $this->config->getCharset();

        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return new PDO($dsn, $this->config->getUserName(), $this->config->getPassword(), $opt);

    }

    public function disconnect($db): void
    {
        $this->db = null;
    }

    public function create(string $table, array $data): void
    {
        $this->wrapper->prepareDataForInsert($data);
        $stmt = $this->db->prepare("INSERT INTO $table (" .
            $this->wrapper->getFields() . ") VALUES (" .
            $this->wrapper->getPlaceholders() . ")");
        $stmt->execute($this->wrapper->getParams());
    }

    public function read(string $table, string $condition, string $value): array|bool
    {
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE  $condition = ?");
        $stmt->execute([$value]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function readAll(string $table): array
    {
        $stmt = $this->db->prepare("SELECT * FROM $table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteAll(string $table): void
    {
        $stmt = $this->db->prepare("DELETE FROM $table");
        $stmt->execute();
    }
}