<?php

namespace App\Services;

class FileService
{

    public static function createFile(string $path, mixed $content): void
    {
        file_put_contents($path, $content);
    }

    public static function getFile(string $path)
    {
        return require dirname(__DIR__) . $path;
    }

    public static function getFilePath(string $path, string $fileName): string
    {
        return dirname(__DIR__) . $path . $fileName . '.php';
    }

}