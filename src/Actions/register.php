<?php

if (!$userService->isUserNameExist($_POST)) {
    $data = $userService->createUser($_POST);

    $mySession->setUserState($_SESSION,true);
    $mySession->setSessionKey($_SESSION,'user', []);
    $mySession->setSessionKey($_SESSION['user'], 'id', $data['user']->getId());
    $mySession->setSessionKey($_SESSION['user'], 'roles', $data['user']->roles());

    if ($mySession->isAdmin($_SESSION)) {
        header('Location: /admin');
    } else {
        header('Location: /profile');
    }

} else {
    header('Location: /register');
}