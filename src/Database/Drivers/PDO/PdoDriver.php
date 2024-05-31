<?php

namespace App\Database\Drivers\PDO;

use App\Database\Config;
use App\Database\Drivers\BaseDriver;
use App\Database\Drivers\Contracts\IDriver;
use App\Helpers\Dumper;
use App\Helpers\MyConfigHelper;
use PDO;

class PdoDriver extends BaseDriver implements IDriver
{

    private PDO $db;

    private Config $config;

    public function __construct()
    {
        $this->config = MyConfigHelper::getDbConfig();
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
        $stmt = $this->db->prepare(sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            $this->parseFieldsForInsert($data),
            $this->parsePlaceholdersForInsert($data)
        ));
        $stmt->execute($this->parseParams($data));
    }

    public function readWhere(string $table, array $condition): array|bool|null
    {
        $stmt = $this->db->prepare(sprintf(
            'SELECT * FROM %s WHERE %s',
            $table,
            $this->parseColumn($condition)
        ));
        $stmt->execute($this->parseParams($condition));

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(string $table, array $data, array $condition): void
    {
        $stmt = $this->db->prepare(sprintf(
            'UPDATE %s SET %s WHERE %s LIMIT 1',
            $table,
            $this->parseFieldsForUpdate($data),
            $this->parseColumn($condition)
        ));

        $stmt->execute($this->parseParamsForUpdate($data, $condition));
    }

    public function delete(string $table, array $condition): void
    {
        $stmt = $this->db->prepare(sprintf(
            'DELETE FROM %s WHERE %s LIMIT 1',
            $table,
            $this->parseColumn($condition)
        ));

        $stmt->execute($this->parseParams($condition));
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

    public function runQuery(string $query, array $params = []): bool|array|null
    {
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}