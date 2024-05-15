<?php

namespace App\Builder;

use App\Database\Drivers\Contracts\IDriver;
use App\Helpers\Dumper;
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
        $pivotData = $this->connection->readWhere($tableName, [$parentKey => $parent->getId()]);

        if (is_null($pivotData)) {
            return null;
        }

        foreach ($pivotData as $row) {
            $value = $this->connection->readWhere($related::getTable(), ['id' => $row[$relatedKey]]);
            $result[] = $value[0];
        }

        return $result;
    }

    public function setRelated(BaseModel $parent, int $relatedValue, string $tableName, string $relatedKey, string $parentKey): void
    {
        $this->connection->create($tableName, [$parentKey => $parent->getId(), $relatedKey => $relatedValue]);
    }

}