<?php
require_once('connection.php');
$newConnection->userLogin();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>

<body>

    <div class="flex min-h-[100svh] justify-center items-center flex-col gap-2">
        <form action="" method="post" class="">
            <div>
                <label for="username" class="block text-sm/6 font-medium text-white">Username</label>
                <div class="">
                    <input type="text" name="username" class="">
                </div>
            </div>
            <div>
                <label for="password" class="">Password</label>
                <div class="">
                    <input type="password" name="password" id="password" class="">
                </div>
            </div>
            <div>
                <button type="submit" name="user_login" class="">Login</button>
                <a href="register.php">no account?</a>
            </div>
        </form>
    </div>

</body>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>