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

    public function getAll(string $tableName): array
    {
        return $this->connection->readAll($tableName);
    }

    public function getById(string $tableName, string $id): array|null
    {
       return $this->connection->read($tableName,'id',$id);
    }

    public function get(string $tableName, string $condition, string $value): bool|array|null
    {
        return $this->connection->read($tableName,$condition,$value);
    }

    public function update(string $tableName, array $data, array $condition): void
    {
        $this->connection->update($tableName,$data,$condition);
    }

    public function updateById(string $tableName, array $data, string $id): void
    {
        $this->connection->update($tableName,$data,['id' => $id]);
    }
    public function deleteAll(string $tableName): void
    {
        $this->connection->deleteAll($tableName);
    }

    public function deleteById(string $tableName, int $id): void
    {
        $this->connection->delete($tableName, 'id', $id);
    }

    public function delete(string $tableName, string $condition, string $value): void
    {
        $this->connection->delete($tableName,$condition,$value);
    }

    public function exist(string $tableName, string $condition, string $value): bool
    {

        if ($this->get($tableName,$condition,$value)) {
            return true;
        } else {
            return false;
        }
    }

}