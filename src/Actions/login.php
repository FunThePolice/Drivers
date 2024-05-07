<?php

if ($userService->verifyUser($_POST)) {
    $data = $userService->getUserByKey('name', $_POST['name']);
    $_SESSION = $mySession->setUserState($_SESSION ?? [],true);
    $_SESSION = $mySession->setSessionKey($_SESSION,'id',$data->getId());
    header('Location: /profile');
} else {
    header('Location: /signIn');
}