<?php

use App\Helpers\MySessionHelper;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use App\Services\ProfileService;
use App\Services\UserService;

require __DIR__.'/../vendor/autoload.php';

session_start();

$userService = new UserService(
    new UserRepository(),
    new ProfileRepository()
);

$profileService = new ProfileService(
    new ProfileRepository(),
);

$mySession = new MySessionHelper();

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require __DIR__.'/../src/Views/welcome.php';
        break;
    case '/registration' :
        require __DIR__.'/../src/Views/registration.php';
        break;
    case '/register' :
        require __DIR__.'/../src/Actions/register.php';
        break;
    case '/profile' :

        if ((new MySessionHelper())->getUserStatus($_SESSION)) {
            require __DIR__ . '/../src/Views/profile.php';
        } else {
            require __DIR__ . '/../src/Views/signIn.php';
        }

        break;
    case '/login' :
        require __DIR__.'/../src/Actions/login.php';
        break;
    case '/signIn' :
        require __DIR__.'/../src/Views/signIn.php';
        break;
    case '/logout' :
        require __DIR__.'/../src/Actions/logout.php';
        break;
    case '/update' :
        require __DIR__.'/../src/Actions/update.php';
        break;
    case '/info' :
        require __DIR__.'/../src/Views/info.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;

}