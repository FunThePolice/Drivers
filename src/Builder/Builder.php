<?php

namespace App\Builder;

use App\Database\Drivers\Contracts\IDriver;

class Builder
{

    private IDriver $connection;

    public function __construct(IDriver $connection)
    {
        $this->connection = $connection;
    }

    public function create(string $tableName, array $data): void
    {
        $this->connection->create($tableName, $data);
    }

    public function read(string $tableName): array
    {
        return $this->connection->read($tableName);
    }

    public function readWhere(string $tableName, array $condition): bool|array|null
    {
        return $this->connection->readWhere($tableName,$condition);
    }

    public function update(string $tableName, array $data, array $condition): void
    {
        $this->connection->update($tableName,$data,$condition);
    }

    public function delete(string $tableName, array $condition): void
    {
        $this->connection->delete($tableName,$condition);
    }

}