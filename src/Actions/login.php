<?php

if ($serv->verifyUser($_POST)) {
    $_SESSION = $mySession->setUserState($_SESSION ?? [],true);
    header('Location: /profile');
} else {
    header('Location: /signIn');
}

