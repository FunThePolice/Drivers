<?php
\App\Helpers\Dumper::dd($_POST);
if ($profileService->updateInfo($_POST, $_POST['id'])) {
    header('Location: /adminProfiles');
} else {
    header('Location: /adminProfilesEdit');
}