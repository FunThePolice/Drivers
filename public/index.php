<?php

use App\Helpers\Dumper;
use App\Helpers\MySessionHelper;
use App\Model\User;
use App\Repositories\ProfileRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Services\ProfileService;
use App\Services\RoleService;
use App\Services\UserService;
use App\Database\Drivers\PDO\PdoDriver;

require __DIR__.'/../vendor/autoload.php';

session_start();

$userService = new UserService(
    new UserRepository(),
    new ProfileRepository(),
    new RoleRepository()
);

$profileService = new ProfileService(
    new ProfileRepository(),
);

$roleService = new RoleService(
    new RoleRepository(),
);

$mySession = new MySessionHelper();

$request = $_SERVER['PATH_INFO'];

switch ($request) {
    case '' :
        require __DIR__.'/../src/Views/welcome.php';
        break;
    case '/registration' :
        require __DIR__.'/../src/Views/registration.php';
        break;
    case '/register' :
        require __DIR__.'/../src/Actions/register.php';
        break;
    case '/profile' :

        if ($mySession->isUserAuth($_SESSION)) {
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
    case '/admin' :
        if ($mySession->isAdmin($_SESSION)) {
            require __DIR__.'/../src/Views/admin.php';
        } else {
            require __DIR__ . '/../src/Views/signIn.php';
        }

        break;
    case '/adminProfiles' :
        require __DIR__.'/../src/Views/adminProfiles.php';
        break;
    case '/adminUsers' :
        require __DIR__.'/../src/Views/adminUsers.php';
        break;
    case '/adminUserRole' :
        require __DIR__.'/../src/Actions/adminUserRole.php';
        break;
    case '/adminProfileEdit' :
        require __DIR__.'/../src/Views/adminProfileEdit.php';
        break;
    case '/adminProfileUpdate' :
        require __DIR__ . '/../src/Actions/adminProfileUpdate.php';
        break;
    case '/adminRoleCreate' :
        require __DIR__ . '/../src/Views/adminRoleCreate.php';
        break;
    case '/roleCreate' :
        require __DIR__ . '/../src/Actions/adminRoleCreate.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;

}