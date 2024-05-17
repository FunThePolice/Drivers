<?php

if ($userService->verifyUser($_POST)) {
    $_SESSION['user'] = $userService->getUserByKey('name', $_POST['name'])->roles();
    $mySession->setUserState($_SESSION,true);

    if ($mySession->isAdmin($_SESSION)) {
        header('Location: /admin');
    } else {
        header('Location: /profile');
    }

} else {
    header('Location: /signIn');
}