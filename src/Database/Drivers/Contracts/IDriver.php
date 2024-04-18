<?php

namespace App\Database\Drivers\Contracts;

use mysqli;

interface IDriver
{
    public function connect();
    public function disconnect($db): void;
    public function create(string $table, array $data): void;
    public function read(string $table, string $condition, string $value): array|bool;
    public function readAll(string $table): array;
    public function update(string $table, array $data, array $condition): void;
    public function delete(string $table, string $condition, string $value): void;
    public function deleteAll(string $table): void;

}