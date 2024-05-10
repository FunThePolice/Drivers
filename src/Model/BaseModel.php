<?php

namespace App\Model;

use App\Builder\Builder;
use App\Factories\DriverFactory;
use App\Helpers\MyConfigHelper;

abstract class BaseModel
{

    protected static string $table;

    protected array $fillable;

    public function getBuilder(): Builder
    {
        $configHelper = MyConfigHelper::getDbConfig();
        $connection = DriverFactory::create($configHelper->getDriver());

        return new Builder($connection);
    }

    public static function getTable(): string
    {
        return static::$table;
    }

    public function toArray(): array
    {
        return [];
    }

    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            if (isset($value)) {
                if (empty($this->fillable)) {
                    $this->{$key} = $value;
                } else {
                    $key = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $key));
                    if (in_array($key, $this->fillable)) {
                        $key = \lcfirst(\str_replace('_', '', \ucwords($key, '_')));
                        $mutator = sprintf('set%s', ucfirst($key));
                        if (is_callable(BaseModel::class, $mutator)) {
                            $this->{$mutator}($value);
                        }
                    }
                }
            }
        }

        return $this;
    }

    public function fillFromDb(array $data)
    {
        foreach ($data as $key => $value) {
            if (isset($value)) {
                $key = \lcfirst(\str_replace('_', '', \ucwords($key, '_')));
                $mutator = sprintf('set%s', ucfirst($key));
                    if (is_callable(BaseModel::class, $mutator)) {
                        $this->{$mutator}($value);
                    }
            }
        }

        return $this;
    }

    public function save(): void
    {
        $this->getBuilder()->create(static::getTable(), $this->toArray());
    }

    public function createPair(string $child, array $data): void
    {
        $table = sprintf('%s_%s', static::getTable(), $child);
        $this->getBuilder()->create($table, $data);
    }

    public function getPair(string $child, array $condition): array|null
    {
        $table = sprintf('%s_%s', static::getTable(), $child);

        return $this->getBuilder()->readWhere($table, $condition);
    }

    public function all(): array
    {
        $dbData = $this->getBuilder()->read(static::getTable());
        foreach ($dbData as $value) {
            $item = (new static())->fillFromDb($value);
            $result[] = $item;
        }
        return $result;
    }

    public function find(array $condition): static|bool
    {
        $dbData = $this->getBuilder()->readWhere(static::getTable(), $condition);

        if ($dbData === null) {
            return false;
        }

        return (new static())->fillFromDb($dbData);
    }

    public function update(array $condition): void
    {
        $this->getBuilder()->update(static::getTable(), $this->toArray(), $condition);
    }

    public function delete(array $condition): void
    {
        $this->getBuilder()->delete(static::getTable(), $condition);
    }

}