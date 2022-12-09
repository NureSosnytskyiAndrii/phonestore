<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!--<script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-grid.min.css"> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script defer src="https://pro.fontawesome.com/releases/v5.10.0/js/all.js" integrity="sha384-G/ZR3ntz68JZrH4pfPJyRbjW+c0+ojii5f+GYiYwldYU69A+Ejat6yIfLSxljXxD" crossorigin="anonymous"></script>
    <style>
        .dropdown-menu{
            background:
                    linear-gradient(217deg, rgba(255,0,0,.8), rgba(255,0,0,0) 70.71%),
                    linear-gradient(127deg, rgba(0,255,0,.8), rgba(0,255,0,0) 70.71%),
                    linear-gradient(336deg, rgba(0,0,255,.8), rgba(0,0,255,0) 70.71%);
            opacity: 0.9;
            border: none;
            border-radius: 5px;
        }
        .dropdown-item{
            color:coral;
            font-family: "Comic Sans MS";
            font-weight: bold;
            font-size: 1.4em;
        }
    </style>

    <title>Phone store</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">PhoneStore</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="http://phoneStore.local/?page=main">Home &nbsp; <i class="fas fa-home"></i> <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/?page=my_orders">My orders</a>
            </li>

        </ul>
        <form class="form-inline my-2 my-lg-0">
            <?php
            global $mysqli;
            if (isset($_SESSION['login']) && $_SESSION['uid']) {
                $user_obj = new User();
                $user = $user_obj->getUserById($_SESSION['uid']);
                $user_first_name = $user['first_name'];
                $user_last_name = $user['last_name'];
                $user_id = $user['user_id'];
                $count_cart_items = mysqli_query($mysqli, "SELECT COUNT(*) FROM `basket_device` WHERE basket_id in (SELECT basket_id FROM basket WHERE user_id='$user_id')");
                $count_cart_items = mysqli_fetch_assoc($count_cart_items);
                ?>
                <span class="text-white"><?php echo $user_first_name . '&nbsp;' . $user_last_name; ?></span>&nbsp;&nbsp;&nbsp;
                <span class="text-white"><i class="far fa-shopping-cart"></i>(<?php echo $count_cart_items['COUNT(*)']; ?>)</span>
                <?php
                if($user['status'] == "admin"){
                    echo '<a class="btn btn-outline-info my-2 my-sm-0" href="/admin_panel/">Admin panel</a>';
                }
                ?>

                <a class="btn btn-outline-danger my-2 my-sm-0" href="../logout.php">Log out -></a>
            <?php } else { ?>
                <a class="btn btn-outline-success my-2 my-sm-0" href="../login.php">Login</a> &nbsp;&nbsp;&nbsp;
                <a class="btn btn-outline-primary my-2 my-sm-0" href="../register.php">Register</a>
            <?php } ?>
        </form>
    </div>
</nav>
