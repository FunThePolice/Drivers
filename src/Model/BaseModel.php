<?php

namespace App\Model;

use App\Builder\Builder;

class BaseModel
{
    protected string $table;
    protected array $fillable;

    public function __construct()
    {

    }
    public function getTable(): string
    {
        return $this->table;
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


}