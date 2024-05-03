<?php

namespace App\Model;

use App\Builder\Builder;
use App\Database\Config;
use App\Database\Drivers\DriverWrapper;
use App\Helpers\MyConfigHelper;

abstract class BaseModel
{

    protected static string $table;

    protected array $fillable;

    public function getBuilder(): Builder
    {
        $configHelper = MyConfigHelper::getConfig();

        $config = (new Config())
            ->setHost($configHelper['host'])
            ->setPort($configHelper['port'])
            ->setDatabase($configHelper['database'])
            ->setUserName($configHelper['username'])
            ->setPassword($configHelper['password']);

        $connection = $configHelper['driver']::establish($config, new DriverWrapper());
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
        return $this;
    }

    public function save(): void
    {
        $this->getBuilder()->create(static::getTable(), $this->toArray());
    }

    public function all(): array
    {
        return $this->getBuilder()->read(static::getTable());
    }

    public function find(array $condition): BaseModel|bool
    {
       $dbData = $this->getBuilder()->readWhere(static::getTable(), $condition);

       if ($dbData === null) {
           return false;
       }

       return (new static())->fill($dbData)->setId($dbData['id']);
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