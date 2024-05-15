<?php

$userService->getUserById($_POST['user_id'])->setRole($roleService->getRoleByKey('name', $_POST['role']));
header('Location: /adminUsers');
