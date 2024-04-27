<?php

namespace App\Model;

use App\Builder\Builder;
use App\Database\Config;
use App\Database\Connection;
use App\Database\Drivers\DriverWrapper;
use App\Helpers\MyConfigHelper;

class BaseModel
{

    protected static string $table;

    protected array $fillable;

    protected Builder $builder;

    public function __construct()
    {
        $this->builder = $this->getBuilder();
    }

    public function getBuilder(): Builder
    {
        $configHelper = MyConfigHelper::getConfig();

        $config = new Config(
            $configHelper['host'],
            $configHelper['port'],
            $configHelper['database'],
            $configHelper['username'],
            $configHelper['password']
        );

        $connection = (new Connection($config, new DriverWrapper()))->connect($configHelper['driver']);
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
        $this->builder->create($this::getTable(), $this->toArray());
    }

    public function all(): array
    {
        return $this->builder->read($this::getTable());
    }

    public function find(array $condition): bool|array|null
    {
        return $this->builder->readWhere($this::getTable(), $condition);
    }

    public function update(array $condition): void
    {
        $this->builder->update($this::getTable(), $this->toArray(), $condition);
    }

    public function delete(array $condition): void
    {
        $this->builder->delete($this::getTable(), $condition);
    }

}