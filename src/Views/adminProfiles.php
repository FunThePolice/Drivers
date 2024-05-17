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
    <h1 class="display-1 mt-5">Profiles</h1>
    <div class="my-5">
        <a class="btn btn-secondary p-2 g-col-6" href="/admin" role="button" >To Admin Page</a>
        <a class="btn btn-primary p-2 g-col-6" href="/logout" role="button">Logout</a>
        <a class="btn btn-primary p-2 g-col-6" href="/adminUsers" role="button">Users</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">User id</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Middle Name</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($profileService->getAll() as $item) { ?>
            <tr>
                <th scope="row"><?= $item->getUserId() ?></th>
                <th scope="row"><?= $item->getFirstName() ?></th>
                <th scope="row"><?=$item->getLastName() ?></th>
                <th scope="row"><?= $item->getMiddleName() ?></th>
                <th scope="row">
                    <a class="btn btn-primary p-2 g-col-6" href="<?= sprintf('/adminProfileEdit?user_id=%s', $item->getUserId()) ?>" role="button" >Edit</a>
                </th>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

