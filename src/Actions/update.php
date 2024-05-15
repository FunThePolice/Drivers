<?php

if ($profileService->updateInfo($_POST,$_POST['id'])) {
    header('Location: /profile');
} else {
    header('Location: /info');
}
