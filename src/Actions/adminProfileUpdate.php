<?php

if ($profileService->updateInfo($profileService->getById($_POST['id'])->fill($_POST))) {
    header('Location: /adminProfiles');
} else {
    header('Location: /adminProfilesEdit');
}