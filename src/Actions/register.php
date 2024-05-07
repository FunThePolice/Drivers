<?php

if (!$userService->isUserNameExist($_POST)) {
    $data = $userService->createUser($_POST);
    $_SESSION = $mySession->setUserState($_SESSION ?? [],true);
    $_SESSION = $mySession->setSessionKey($_SESSION,'id',$data['user']->getId());
    header('Location: /profile');
} else {
    header('Location: /registration');
}