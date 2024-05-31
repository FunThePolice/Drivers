<?php

namespace App\Builder;

use App\Database\Drivers\Contracts\IDriver;
use App\Model\BaseModel;

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

    public function getMany(BaseModel $parent, string $related, string $tableName, string $relatedKey, string $parentKey): array|null
    {
        $pivotData = $this->connection->read($tableName);

        foreach ($pivotData as $row) {
            if ($row[$parentKey] === $parent->getId()) {
                $dbData = $this->connection->readWhere($related::getTable(), ['id' => $row[$relatedKey]]);
                $result[] = (new $related())->fillFromDb($dbData);
            }
        }

        return $result;
    }

    public function createRelated(BaseModel $parent, int $relatedValue, string $tableName, string $relatedKey, string $parentKey): void
    {
        $this->connection->create($tableName, [$parentKey => $parent->getId(), $relatedKey => $relatedValue]);
    }

    public function rawQuery(string $sql, array $params = []): bool|array|null
    {
        return $this->connection->runQuery($sql, $params);
    }

}