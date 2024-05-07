<?php

namespace App\Database\Drivers\PDO;

use App\Database\Config;
use App\Database\Drivers\Contracts\IDriver;
use App\Database\Drivers\DriverWrapper;
use PDO;

class PdoDriver implements IDriver
{

    private PDO $db;

    private DriverWrapper $wrapper;

    private Config $config;

    public function __construct(Config $config, DriverWrapper $wrapper)
    {
        $this->config = $config;
        $this->wrapper = $wrapper;
        $this->db = $this->connect();
    }

    public function connect(): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
                    $this->config->getHost(),
                    $this->config->getDatabase(),
                    $this->config::getCharset()
        );

        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return new PDO($dsn, $this->config->getUserName(), $this->config->getPassword(), $opt);
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
        $stmt->bindParam($this->wrapper->getTypes(),...$this->wrapper->getParams());
        $stmt->execute();
    }

    public function readWhere(string $table, array $condition): array|bool
    {
        $this->wrapper->prepareDataForSelect($condition);

        $stmt = $this->db->prepare(sprintf(
            'SELECT * FROM %s WHERE %s LIMIT 1',
            $table,
            $this->wrapper->getColumn()
        ));
        $stmt->bindParam($this->wrapper->getTypes(),...$this->wrapper->getParams());
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(string $table, array $data, array $condition): void
    {
        $this->wrapper->prepareDataForUpdate($data, $condition);

        $stmt = $this->db->prepare(sprintf(
            'UPDATE %s SET %s WHERE %s = ? LIMIT 1',
            $table,
            $this->wrapper->getFields(),
            $this->wrapper->getColumn()
        ));
        $stmt->bindParam($this->wrapper->getTypes(),...$this->wrapper->getParams());
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
        $stmt->bindParam($this->wrapper->getTypes(),...$this->wrapper->getParams());
        $stmt->execute();
    }

    public function read(string $table): array
    {
        $stmt = $this->db->prepare(sprintf(
            'SELECT * FROM %s',
            $table
        ));
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}