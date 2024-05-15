<?php

namespace App\Database\Drivers;

use App\Database\Drivers\Contracts\IDriver;

abstract class BaseDriver implements IDriver
{

    protected function parseFieldsForInsert(array $data): string
    {
        return implode(', ', array_keys($data));
    }

    protected function parseFieldsForUpdate(array $data): string
    {
        return implode('= ?, ', array_keys($data)) . '= ?';
    }

    protected function parsePlaceholdersForInsert(array $data): string
    {
        return str_repeat('?,', count(array_keys($data)) - 1).'?';
    }

    protected function parseColumn(array $condition): string
    {
        return implode('=? AND ', array_keys($condition)) . '=?';
    }

    protected function parseParams(array $data): array
    {
        return array_values($data);
    }

    protected function parseParamsForUpdate(array $data, array $condition): array
    {
        return array_merge(array_values($data), array_values($condition));
    }

    protected function parseTypes(array $data): string
    {
        $result = '';
        foreach ($data as $value) {
            switch ($value) {
                case is_string($value):
                    $type = 's';
                    break;
                case is_int($value):
                    $type = 'i';
                    break;
                case is_bool($value):
                    $type = 'i';
            }
            $result .= $type;
        }

        return $result;
    }

}