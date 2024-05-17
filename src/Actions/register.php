<?php

if (!$userService->isUserNameExist($_POST)) {
    $data = $userService->createUser($_POST);

    $_SESSION['user'] = $data['user']->roles();
    $mySession->setUserState($_SESSION,true);

    if ($mySession->isAdmin($_SESSION)) {
        header('Location: /admin');
    } else {
        header('Location: /profile');
    }

} else {
    header('Location: /register');
}