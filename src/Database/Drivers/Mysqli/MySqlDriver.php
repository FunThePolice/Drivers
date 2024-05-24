<?php

namespace App\Database\Drivers\Mysqli;

use App\Database\Config;
use App\Database\Drivers\BaseDriver;
use App\Database\Drivers\Contracts\IDriver;
use mysqli;

class MySqlDriver extends BaseDriver implements IDriver
{

    private mysqli $db;

    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
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
        $stmt = $this->db->prepare(sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            $this->parseFieldsForInsert($data),
            $this->parsePlaceholdersForInsert($data)
        ));
        $stmt->bind_param($this->parseTypes($data),...$this->parseParams($data));
        $stmt->execute();
    }

    public function readWhere(string $table, array $condition): array|bool|null
    {
        $stmt = $this->db->prepare(sprintf(
            'SELECT * FROM %s WHERE %s',
            $table,
            $this->parseColumn($condition)
        ));
        $stmt->bind_param($this->parseTypes($condition),...$this->parseParams($condition));
        $stmt->execute();
        $result = $stmt->get_result();

        while($row = $result->fetch_assoc()) {
            $output[] = $row;
        }

        return $output;
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
        $stmt = $this->db->prepare(sprintf(
            'UPDATE %s SET %s WHERE %s LIMIT 1',
            $table,
            $this->parseFieldsForUpdate($data),
            $this->parseColumn($condition)
        ));

        $stmt->bind_param(
            $this->parseTypes($data) . $this->parseTypes($condition),
            ...$this->parseParamsForUpdate($data,$condition));
        $stmt->execute();
    }

    public function delete(string $table, array $condition): void
    {
        $stmt = $this->db->prepare(sprintf(
            'DELETE FROM %s WHERE %s LIMIT 1',
            $table,
            $this->parseColumn($condition)
        ));
        $stmt->bind_param($this->parseTypes($condition),...$this->parseParams($condition));
        $stmt->execute();
    }

    public function runQuery(string $query, array $params = []): bool|array|null
    {
        return $this->db->query($query);
    }
}