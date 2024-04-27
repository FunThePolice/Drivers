<?php

if (!$serv->checkIfUserExist($_POST)) {
    $serv->createUser($_POST);
    header('location: /profile');
    $_SESSION = $mySession->setUserState($_SESSION,true);
} else {
    header('location: /registration');
}


