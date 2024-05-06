<?php

namespace App\Database\Drivers;

class DriverWrapper
{

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
        $this->types = $this->defineDataTypes($data);
        $this->params = array_values($data);
    }

    public function prepareDataForSelect(array $condition): void
    {
        $this->column = implode('=? AND ', array_keys($condition)) . '=?';
        $this->types = $this->defineDataTypes($condition);
        $this->params = array_values($condition);
    }

    public function prepareDataForUpdate(array $data, array $condition): void
    {
        $keys = array_keys($data);
        $this->fields = implode('= ?, ', $keys) . '= ?';
        $this->types = $this->defineDataTypes($data);
        $values = array_values($data);
        $this->column = implode('= ? AND ', array_keys($condition)) . '= ?';
        $this->params = array_merge($values, array_values($condition));
    }

    public function defineDataTypes(array $data): string
    {
        $result = '';
        foreach ($data as $value) {
            switch (gettype($value)) {
                case 'string':
                    $type = 's';
                    break;
                case 'integer':
                    $type = 'i';
                    break;
                case 'boolean':
                    $type = 'i';
            }
            $result .= $type;
        }

        return $result;
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

}