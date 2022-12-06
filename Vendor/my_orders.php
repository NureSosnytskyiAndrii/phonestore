<?php

global $mysqli;
require_once "System/configuration.php";

if (isset($_SESSION['login']) && $_SESSION['uid']) {
    $user_obj = new User();
    $user = $user_obj->getUserById($_SESSION['uid']);
    $user_id = $user['user_id'];
    echo $user_id;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Phones</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Checkout</title>
    <link rel="stylesheet" href="../styles/orders.css">
</head>
<body>

<!-- Order section starts -->

<section class="show-orders">
    <h1 align="center">Your orders</h1>
    <div class="box-container">
        <?php
        if (isset($_SESSION['login']) && $_SESSION['uid']) {
            $user_obj = new User();
            $user = $user_obj->getUserById($_SESSION['uid']);
            $user_id = $user['user_id'];

            //$selected_goods = mysqli_query($mysqli,"select * from `order_items` where order_id=(select order_id from `order` where user_id='$user_id')");

            $show_orders = mysqli_query($mysqli, "select * from `order` where user_id='$user_id'");

            if(mysqli_num_rows($show_orders) > 0){
                while ($fetch_orders = $show_orders->fetch_object()){
                    ?>
                    <div class="box col-6">
                        <p hidden="hidden"> user id <span><?=$fetch_orders->user_id;?></span></p>
                        <p> name: <span><?=$fetch_orders->name;?></span></p>
                        <p> surname: <span><?=$fetch_orders->surname;?></span></p>
                        <p> phone number: <span><?=$fetch_orders->number;?></span></p>
                        <p> email: <span><?=$fetch_orders->email;?></span></p>
                        <p> city: <span><?=$fetch_orders->city;?></span></p>
                        <p> street: <span><?=$fetch_orders->street;?></span></p>
                        <p> flat: <span><?=$fetch_orders->flat;?></span></p>
                        <p> payment method: <span><?=$fetch_orders->payment_method;?></span></p>
                        <p> payment status: <span style="color: <?php if($fetch_orders->payment_status == 'pending'){echo 'red';}else{echo 'green';}?>"><?=$fetch_orders->payment_status;?></span></p>
                        <p> order date: <span><?=$fetch_orders->order_date;?></span></p>
                        <p> order time: <span><?=$fetch_orders->order_time;?></span></p>
                        <p> total cost: <span>$ <?=$fetch_orders->cost;?></span></p>
                        <p> total cost: <span><?=$fetch_orders->smartphone_id;?></span></p>
                    </div>
        <?php
                    echo '<div><b>Items:</b></div>';
                    $selected_goods = mysqli_query($mysqli,"select order_items.quantity, smartphone.model from order_items, smartphone WHERE
                     order_items.order_id = '$fetch_orders->order_id' AND smartphone.smartphone_id =order_items.smartphone_id ");

                if (mysqli_num_rows($selected_goods) > 0) {
                    while ($row = mysqli_fetch_assoc($selected_goods)) {
                        printf("%s (%s)\n", $row["model"], $row["quantity"]);
                    }
                  }
                }

               ?>

              <?php
                }else{
                echo '<p align="center" class="empty"> No orders placed yet!</p>';
            }
        }
        ?>

    </div>
</section>

<!-- Order section ends -->

</body>

