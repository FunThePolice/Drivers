<?php

use App\Helpers\MySessionHelper;
use App\Model\Profile;
use App\Model\User;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use App\Services\UserService;

require __DIR__.'/../vendor/autoload.php';

session_start();

$serv = new UserService(
    new UserRepository(new User()),
    new ProfileRepository(new Profile())
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
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;

}



