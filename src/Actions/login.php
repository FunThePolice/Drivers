<?php

if ($userService->verifyUser($_POST)) {
    $user = $userService->getUserByKey('name', $_POST['name']);

    $mySession->setUserState($_SESSION,true);
    $mySession->setSessionKey($_SESSION,'user', []);
    $mySession->setSessionKey($_SESSION['user'], 'id', $user->getId());
    $mySession->setSessionKey($_SESSION['user'], 'roles', $user->roles());

    if ($mySession->isAdmin($_SESSION)) {
        header('Location: /admin');
    } else {
        header('Location: /profile');
    }

} else {
    header('Location: /signIn');
}