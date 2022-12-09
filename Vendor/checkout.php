<?php

global $mysqli;
require_once "System/configuration.php";

if (isset($_SESSION['login']) && $_SESSION['uid']) {
    $user_obj = new User();
    $user = $user_obj->getUserById($_SESSION['uid']);
    $user_id = $user['user_id'];
    echo $user_id;
    $basket_id = mysqli_query($mysqli, "SELECT basket_id FROM basket WHERE user_id='$user_id'");
    $basket_id = mysqli_fetch_assoc($basket_id);
    echo $basket_id['basket_id'];
    $selected_cart = mysqli_query($mysqli, "SELECT smartphone_id,quantity FROM basket_device WHERE basket_id = '$basket_id[basket_id]'");
    //$selected_cart = mysqli_fetch_assoc($selected_cart);

    //echo $selected_cart['quantity'];
    //echo $selected_cart['smartphone_id'];

    if (isset($_POST['order'])) {
        $name = $_POST['name'];
       // $name = filter_var($name, FILTER_SANITIZE_STRING);
        $surname = $_POST['surname'];
        //$surname = filter_var($surname, FILTER_SANITIZE_STRING);
        $number = $_POST['number'];
        //$number = filter_var($number, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        //$email = filter_var($email, FILTER_SANITIZE_STRING);
        $method = $_POST['method'];
        //$method = filter_var($method, FILTER_SANITIZE_STRING);
        $city = $_POST['city'];
        // $city = filter_var($city, FILTER_SANITIZE_STRING);
        $street = $_POST['street'];
        // $street = filter_var($street, FILTER_SANITIZE_STRING);
        $flat = $_POST['flat'];
        //$flat = filter_var($flat, FILTER_SANITIZE_STRING);
        $total_price = $_POST['total_price'];
       // $total_price = filter_var($total_price, FILTER_SANITIZE_STRING);

        $tz = 'Europe/Kiev';
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone($tz));
        $dt->setTimestamp($timestamp);
        $current_datetime = $dt->format('Y-m-d H:i:s');

        mysqli_query($mysqli, "INSERT INTO `order`(order_id, name, surname, email, phone_number, order_date , cost, payment_method, payment_status, user_id, city, street, flat)
        VALUES (NULL, '$name', '$surname', '$email', '$number', '$current_datetime', '$total_price', '$method', 'pending', '$user_id', '$city', '$street', '$flat')");

        // $insert_order_items = mysqli_query($mysqli, "INSERT INTO `order_items`(order_item_id, quantity, smartphone_id, order_id) VALUES (NULL, ())");
        //mysqli_query($mysqli,"INSERT INTO `order_items`VALUES (NULL,  (SELECT basket_device.quantity FROM basket_device WHERE basket_id = '$basket_id[basket_id]'), (SELECT basket_device.smartphone_id FROM basket_device WHERE basket_id = '$basket_id[basket_id]' ), 18)");

           // mysqli_query($mysqli, "INSERT INTO `order_items` VALUES (NULL, '$selected_cart[quantity]', '$selected_cart[smartphone_id]',18)");
        if(mysqli_num_rows($selected_cart) > 0) {
            while ($row = mysqli_fetch_assoc($selected_cart)) {
                //printf("%s (%s)\n", $row["smartphone_id"], $row["quantity"]);
                mysqli_query($mysqli, "INSERT INTO `order_items` VALUES (NULL, '$row[quantity]', '$row[smartphone_id]', (SELECT MAX(order_id) FROM `order`))");
                mysqli_query($mysqli, "UPDATE `smartphone` SET number_of_items = number_of_items - '$row[quantity]' WHERE smartphone_id ='$row[smartphone_id]'");
            }
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Order placed successfully!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
            $delete_cart = mysqli_query($mysqli, "DELETE FROM `basket_device` WHERE basket_id='$basket_id[basket_id]'");
        }
    }
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

<!--checkout section starts -->
<section class="checkout">
    <h1 class="heading" align="center">Your orders</h1>
    <div class="display-orders" align="center">
        <div class="row">
        <?php
        if (isset($_SESSION['login']) && $_SESSION['uid']) {
        $user_obj = new User();
        $user = $user_obj->getUserById($_SESSION['uid']);
        $user_id = $user['user_id'];

        $grand_total = 0;
        $cart_items[] = '';
        $basket = mysqli_query($mysqli, "SELECT basket_id FROM basket WHERE user_id='$user_id'");
        $basket = mysqli_fetch_assoc($basket);
        //echo $basket['basket_id'];

        $cart_query =  $mysqli->query("SELECT * FROM smartphone, basket_device WHERE smartphone.smartphone_id = basket_device.smartphone_id  AND basket_device.smartphone_id IN (SELECT smartphone_id FROM basket_device WHERE basket_device.basket_id = '$basket[basket_id]' )");
        while($fetch_product = $cart_query->fetch_object()){
        ?>
            <div class="col-2"><img src="<?=$fetch_product->image;?>" style="width: 90px;height: 90px;"/>
            <p><?=$fetch_product->model;?></p>
                <hr/>
            <p><?=$fetch_product->price .' $';?> /-x <?=$fetch_product->quantity;?></p>
                <hr/>
            </div>
            <?php $sub_total = ($fetch_product->price) * ($fetch_product->quantity)?>
        <?php
            $grand_total += $sub_total;
        } } ?>
        </div>
        <div class="grand-total"><?php echo 'Total:'. $grand_total . ' $'; ?></div>
    </div>

    <form action="" method="post">
        <input type="hidden" name="total_price" value="<?=$grand_total?>">

        <div class="flex">
            <div class="inputBox">
                <span>Your name:</span>
                <input type="text" maxlength="20" placeholder="Enter your name" required class="box" name="name"/>
            </div>
            <div class="inputBox">
                <span>Your surname:</span>
                <input type="text" maxlength="20" placeholder="Enter your surname" required class="box" name="surname"/>
            </div>
            <div class="inputBox">
                <span>Your phone number:</span>
                <input type="number" min="0" onkeypress="if(this.value.length == 10) return false;" placeholder="Enter your number" required class="box" name="number"/>
            </div>
            <div class="inputBox">
                <span>Your email:</span>
                <input type="email" maxlength="55" placeholder="Enter your email" required class="box" name="email"/>
            </div>
            <div class="inputBox">
                <span>Payment method:</span>
            <select name="method" class="box">
                <option value="cash on delivery">cash on delivery</option>
                <option value="credit card">credit card</option>
            </select>
            </div>
            <div class="inputBox">
                <span>address line 01:</span>
                <input type="text" maxlength="50" placeholder="e.g. flat no." required class="box" name="flat"/>
            </div>
            <div class="inputBox">
                <span>address line 02:</span>
                <input type="text" maxlength="50" placeholder="e.g. street name" required class="box" name="street"/>
            </div>
            <div class="inputBox">
                <span>city:</span>
                <input type="text" maxlength="50" placeholder="e.g. Kharkiv" required class="box" name="city"/>
            </div>
        </div>

        <input type="submit" value="place order" class="btn btn-block btn-success <?php echo ($grand_total > 1)?'': 'disabled' ?>" name="order">

    </form>

</section>
<!-- checkout section ends -->

</body>
</html>

