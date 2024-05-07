<?php

if ($profileService->updateInfo($_POST,$_SESSION['id'])) {
    header('Location: /profile');
} else {
    header('Location: /info');
}
