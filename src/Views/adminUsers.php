
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container text-center">
    <h1 class="display-1 mt-5">Users</h1>
    <div class="my-5">
        <a class="btn btn-secondary p-2 g-col-6" href="/admin" role="button" >To Admin Page</a>
        <a class="btn btn-primary p-2 g-col-6" href="/logout" role="button">Logout</a>
        <a class="btn btn-primary p-2 g-col-6" href="/adminProfiles" role="button">Profiles</a>
        <a class="btn btn-primary p-2 g-col-6" href="/adminRoleCreate" role="button">Create Role</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Role</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($userService->getAll() as $item) { ?>
            <tr>
                <th scope="row"><?= $item->getId() ?></th>
                <td><?= $item->getName() ?></td>
                <td>
                    <form action="/adminUserRole" method="post">
                        <div class="input-group">
                            <button class="btn btn-outline-secondary" type="submit">Save</button>
                            <select class="form-select form-select-sm"  aria-label="Role Selection" name="role">
                                <option selected><?= implode('/',$item->getRolesNames($item->roles()->roles))?></option>
                                <?php foreach ($roleService->getAll() as $role) { ?>
                                    <option value="<?= $role->getName() ?>"><?= $role->getName() ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="user_id" value="<?= $item->getId() ?>">
                        </div>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>