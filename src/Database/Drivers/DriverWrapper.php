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
        $keys = $this->prepareKeys(array_keys($data));
        $this->fields = implode(', ', $keys);
        $this->placeholders = str_repeat('?,', count($keys) - 1).'?';
        $this->types = $this->defineDataTypes($data);
        $this->params = array_values($data);
    }

    public function prepareDataForSelect(array $condition): void
    {
        $keys = $this->prepareKeys(array_keys($condition));
        $this->column = implode('=? AND ', $keys) . '=?';
        $this->types = $this->defineDataTypes($condition);
        $this->params = array_values($condition);
    }

    public function prepareDataForUpdate(array $data, array $condition): void
    {
        $keys = $this->prepareKeys(array_keys($data));
        $this->fields = implode('= ?, ', $keys) . '= ?';
        $this->types = $this->defineDataTypes($data) . $this->defineDataTypes($condition);
        $values = array_values($data);
        $this->column = implode('= ? AND ', $this->prepareKeys(array_keys($condition))) . '= ?';
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

    private function prepareKeys(array $keys): array
    {
        foreach ($keys as $key) {
            $result = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $key));
            $finalKeys[] = $result;
        }
        return $finalKeys;
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