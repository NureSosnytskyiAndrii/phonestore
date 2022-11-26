<?php

session_start();
require_once '../system/configuration.php';
require_once '../system/classes/User.php';
/** Auth handler Begin **/

$user = new User();

if(isset($_SESSION['uid'])){
    $authorized_user = $user->getUserById($_SESSION['uid']);
    if($authorized_user['status'] == "admin"){
        echo "<script>location.replace('/admin_panel/?page=main');</script>";
    }
}

if(isset($_POST['login']) && isset($_POST['password'])){

    global $mysqli;
    $login = $_POST['login'];
    $password = $_POST['password'];
    $user->authAdmin($login, $password);
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Signin Template · Bootstrap v4.6</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">
</head>
<body class="text-center">

<form class="form-signin" method="post">
    <h1 class="h3 mb-3 font-weight-normal text-danger">Admin Panel</h1>
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputLogin" class="sr-only">Login</label>
    <input type="text" name="login" id="inputLogin" class="form-control" placeholder="Login" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; <?php echo date('Y'); ?></p>
</form>



</body>
</html>
