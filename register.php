<?php
require_once('connection.php');
$newConnection->registerUser();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Register</title>
</head>

<body>
    <form action="" method="post">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="fname" class="form-label">First name</label>
                        <input type="text" class="form-control" id="fname" name="firstname">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="lname" name="lastname">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="bday" class="form-label">Birthdate</label>
                        <input type="date" class="form-control" id="bday" name="bday">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="lname" class="form-label">Gender</label>
                        <select class="form-select" aria-label="Default select example" name="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <button type="submit" class="btn btn-primary" name="register_user">
                        Register
                    </button>
                    <a href="login.php">naay account?</a>
                </div>
            </div>
        </div>
    </form>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>