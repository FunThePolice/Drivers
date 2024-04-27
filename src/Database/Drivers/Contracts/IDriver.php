<?php

namespace App\Database\Drivers\Contracts;

interface IDriver
{

    public function connect();

    public function create(string $table, array $data): void;

    public function readWhere(string $table, array $condition): array|bool|null;

    public function read(string $table): array;

    public function update(string $table, array $data, array $condition): void;

    public function delete(string $table, array $condition): void;

}