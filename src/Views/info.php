<?php $profile = (new \App\Model\Profile())->find(['user_id' => $_SESSION['user']['id']]) ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container text-center">
    <form action="/update" method="post">
        <div class="col-sm-3 mt-5 mx-auto">
            <label class="form-label" for="first_name">First Name:</label>
            <input class="form-control" name="first_name" id="first_name" type="text" value="<?= $profile->getFirstName() ?>"/><br/>
        </div>

        <div class="col-sm-3 mx-auto">
            <label class="form-label" for="last_name">Second Name:</label>
            <input class="form-control" name="last_name" id="last_name" type="text" value="<?= $profile->getLastName() ?>"/><br/>
        </div>

        <div class="col-sm-3 mx-auto">
            <label class="form-label" for="middle_name">Middle Name:</label>
            <input class="form-control" name="middle_name" id="middle_name" type="text" value="<?= $profile->getMiddleName() ?>"/><br/>
        </div>

        <input type="hidden" name="id" value="<?= $profile->getId() ?>"/>
        <div class="mb-3">
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
    </form>

    <form action="/profile" method="post">
        <button type="submit" class="btn btn-secondary">Back</button>
    </form>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
