<?php

namespace App\Model;

use App\Builder\Builder;
use App\Factories\DriverFactory;
use App\Helpers\Dumper;

abstract class BaseModel
{

    protected static string $table;

    protected array $fillable;

    /**
     * @throws \ReflectionException
     */
    public function getBuilder(): Builder
    {
        $connection = DriverFactory::create();

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