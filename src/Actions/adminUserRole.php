<?php

$userService->giveRole($userService->getUserById($_POST['user_id']),$roleService->getRoleByKey('name', $_POST['role']));
header('Location: /adminUsers');
