<?php

if ($profileService->updateInfo($profileService->getById($_POST['id'])->fill($_POST))) {
    header('Location: /profile');
} else {
    header('Location: /info');
}
