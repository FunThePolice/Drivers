<?php

namespace App\Model;

class Role extends BaseModel
{

    protected static string $table = 'roles';

    protected array $fillable = ['name'];

    protected string $name;

    protected int $id;

    public function toArray(): array
    {
        foreach ($this->fillable as $value) {
            $value =\lcfirst(\str_replace('_', '', \ucwords($value, '_')));
            if (isset($this->{$value})) {
                $result[$value] = $this->{$value};
            }
        }

        return $result;
    }

    public function getName(): string
    {
        return ucfirst($this->name);
    }

    public function setName(string $name): void
    {
        $this->name = lcfirst($name);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}