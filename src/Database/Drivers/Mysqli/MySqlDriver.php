<?php

namespace App\Database\Drivers\Mysqli;

use App\Database\Config;
use App\Database\Drivers\Contracts\IDriver;
use App\Database\Drivers\DriverWrapper;
use mysqli;

class MySqlDriver implements IDriver
{

    private mysqli $db;

    protected DriverWrapper $wrapper;

    private Config $config;

    public function __construct(Config $config, DriverWrapper $wrapper)
    {
        $this->config = $config;
        $this->wrapper = $wrapper;
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

    public function create(string $table, array $data): void
    {
        $this->wrapper->prepareDataForInsert($data);

        $stmt = $this->db->prepare(sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            $this->wrapper->getFields(),
            $this->wrapper->getPlaceholders()
        ));
        $stmt->bind_param($this->wrapper->getTypes(),...$this->wrapper->getParams());
        $stmt->execute();
    }

    public function readWhere(string $table, array $condition): array|bool|null
    {
        $this->wrapper->prepareDataForSelect($condition);

        $stmt = $this->db->prepare(sprintf(
            'SELECT * FROM %s WHERE %s LIMIT 1',
            $table,
            $this->wrapper->getColumn()
        ));
        $stmt->bind_param($this->wrapper->getTypes(),...$this->wrapper->getParams());
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function read(string $table): array
    {
        $stmt = $this->db->prepare(sprintf(
            'SELECT * FROM %s',
            $table
        ));
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function update(string $table, array $data, array $condition): void
    {
        $this->wrapper->prepareDataForUpdate($data, $condition);

        $stmt = $this->db->prepare(sprintf(
            'UPDATE %s SET %s WHERE %s LIMIT 1',
            $table,
            $this->wrapper->getFields(),
            $this->wrapper->getColumn()
        ));

        $stmt->bind_param($this->wrapper->getTypes(),...$this->wrapper->getParams());
        $stmt->execute();
    }

    public function delete(string $table, array $condition): void
    {
        $this->wrapper->prepareDataForSelect($condition);

        $stmt = $this->db->prepare(sprintf(
            'DELETE FROM %s WHERE %s LIMIT 1',
            $table,
            $this->wrapper->getColumn()
        ));
        $stmt->bind_param($this->wrapper->getTypes(),...$this->wrapper->getParams());
        $stmt->execute();
    }

}