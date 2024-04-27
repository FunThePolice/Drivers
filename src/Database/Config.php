<?php

namespace App\Database;

class Config
{

    private string $host;

    private int $port;

    private string $database;

    private string $userName;

    private string $password;

    private static string $charset = 'utf8mb4';

    public function __construct(string $host, int $port, string $database, string $userName, string $password)
    {
        $this->setHost($host)
            ->setPort($port)
            ->setDatabase($database)
            ->setUserName($userName)
            ->setPassword($password);
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): Config
    {
        $this->host = $host;
        return $this;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function setPort(int $port): Config
    {
        $this->port = $port;
        return $this;
    }

    public function getDatabase(): string
    {
        return $this->database;
    }

    public function setDatabase(string $database): Config
    {
        $this->database = $database;
        return $this;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): Config
    {
        $this->userName = $userName;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): Config
    {
        $this->password = $password;
        return $this;
    }

    public static function getCharset(): string
    {
        return static::$charset;
    }

}