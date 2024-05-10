<?php

if ($profileService->updateInfo($_POST, $_POST['user_id'])) {
    header('Location: /adminProfiles');
} else {
    header('Location: /adminProfilesEdit');
}