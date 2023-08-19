<?php
require_once __DIR__ . '/controller/userController.php';

$uc = UserController::getInstance();

if ($uc->isLogin()) {
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container">
        <div class="row">
            <h3 class="mt-3 text-success text-center">Login Form</h3>
            <p class="text-center" id="msg"></p>
            <form id="loginForm" method="post">

                <div class="mb-3 mt-3">
                    <input type="text" class="form-control" placeholder="Email Address" name="username">
                </div>
                <div class="mb-3 mt-3">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                </div>


                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/login.js"></script>
</body>

</html>