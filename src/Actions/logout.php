<?php


use App\Builder\Builder;
use App\Database\Config;
use App\Database\Connection;
use App\Database\Drivers\DriverWrapper;
use App\Helpers\MySessionHelper;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use App\Services\UserService;

$config = new Config('localhost', 3306, 'users', 'root', '');

$builder = new Builder((new Connection($config, new DriverWrapper()))->pdoConnect());
$serv = new UserService(
    new UserRepository($builder),
    new ProfileRepository($builder)
);
$mySession = new MySessionHelper();

session_destroy();
header('Location: /');