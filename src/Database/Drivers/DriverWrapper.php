<?php

namespace App\Database\Drivers;

class DriverWrapper
{

    public $identifierType;
    public string $column;
    public string $fields;
    public string $placeholders;
    protected string $types;
    protected array $params;
    public function prepareDataForInsert(array $data): void
    {
        $keys = array_keys($data);
        $this->fields = implode(', ', $keys);
        $this->placeholders = str_repeat('?,', count($keys) - 1).'?';
        $this->types = str_repeat('s', count($data));
        $this->params = array_values($data);
    }

    public function prepareDataForSelect($condition): void
    {
        $keys = array_keys($condition);
        $this->column = implode($keys);
        $this->params = array_values($condition);
    }

    public function prepareDataForUpdate(array $data, array $condition): void
    {
        $keys = array_keys($data);
        $this->fields = implode('= ?, ', $keys) . '= ?';
        $this->types = str_repeat('s', count($data));
        $values = array_values($data);
        $this->column = implode('= ?, ', array_keys($condition)) . '= ?';
        $this->params = array_merge($values, array_values($condition));

    }

    public function getColumn(): string
    {
        return $this->column;
    }
    public function getFields(): string
    {
        return $this->fields;
    }
    public function getPlaceholders(): string
    {
        return $this->placeholders;
    }

    public function getTypes(): string
    {
        return $this->types;
    }
    public function getParams(): array
    {
        return $this->params;
    }

    public function getIdentifierType(): string|int
    {
        return $this->identifierType;
    }
}