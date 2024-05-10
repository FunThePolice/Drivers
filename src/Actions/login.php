<?php

if ($userService->verifyUser($_POST)) {
    $user = $userService->getUserByKey('name', $_POST['name']);

    if ($user->isAdmin()){
        $mySession->setAdminState($_SESSION,true);
        header('Location: /admin');
    } else {
        $mySession->setUserState($_SESSION,true);
        $mySession->setSessionKey($_SESSION, 'id', $user->getId());
        header('Location: /profile');
    }

} else {
    header('Location: /signIn');
}