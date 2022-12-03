<?php

global $mysqli;
require_once "System/configuration.php";

$Brand_id = $_GET['id'];


if (isset($_SESSION['login']) && $_SESSION['uid']) {
    $user_obj = new User();
    $user = $user_obj->getUserById($_SESSION['uid']);
    $user_id = $user['user_id'];
    echo $user_id;

    $basket_id = mysqli_query($mysqli, "SELECT basket_id FROM basket WHERE user_id='$user_id'");
    $basket_id = mysqli_fetch_assoc($basket_id);
    echo $basket_id['basket_id'];

    if (isset($_POST['add_to_cart'])) {
        $phone_id = $_POST['phone_id'];
        $phone_model = $_POST['phone_model'];
        $phone_price = $_POST['phone_price'];
        $phone_image = $_POST['phone_image'];

        $selected_cart = mysqli_query($mysqli, "SELECT * FROM `basket_device` WHERE basket_device.smartphone_id = '$phone_id' AND basket_id='$basket_id[basket_id]'");
        if (mysqli_num_rows($selected_cart) > 0) {
            echo "product already added to cart!";
        } else {
            mysqli_query($mysqli, "INSERT INTO `basket_device` VALUES(NULL, '$basket_id[basket_id]',  (SELECT smartphone_id FROM smartphone WHERE smartphone.smartphone_id = '$phone_id'),1 )");
            echo "product added to cart!";
        }
    }
}
    if (isset($_POST['update_cart'])) {
        $update_quantity = $_POST['cart_quantity'];
        $update_id = $_POST['cart_id'];
        mysqli_query($mysqli, "UPDATE `basket_device` SET quantity = '$update_quantity' WHERE basket_device_id='$update_id'");
    }
    if (isset($_GET['action']) && $_GET['action'] == "delete") {
        $mysqli->query("DELETE FROM basket_device WHERE basket_device_id='" . $_GET['id'] . "'") or die($mysqli->error);
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Device with ID = ' . $_GET['id'] . ' has been removed!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Phones</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../styles/preview.css">
    <style>
        #phone_card {
            float: left;
            position: relative;
            width: 30%;
            padding-bottom: 30%;
            margin: 1.66%;
        }

    </style>
</head>
<body>
<div class="container  form-inline">
    <?php
    $all_phones = $mysqli->query("SELECT smartphone_id, smartphone.brand_id, model, price, image, brand.brand_name FROM `smartphone`, `brand` WHERE smartphone.brand_id=brand.brand_id AND brand.brand_name in (SELECT brand.brand_name FROM brand WHERE brand.brand_id = '$Brand_id') ");

    while ($phone = $all_phones->fetch_object()) {
        ?>

            <div id="phone_card">
                <div class="product">
                    <div class="image">
                        <img  src="<?php echo $phone->image?>" style="height: 200px; width: 200px;" alt="It is a photo"/>
                    </div>

                    <div class="info">
                        <h3><?= $phone->brand_name; ?></h3>
                       <!-- <h4><a href="../Vendor/phone_details.php?id=<?= $phone->smartphone_id. '&brand_id='. $phone->brand_id; ?>"><?= $phone-> model; ?></a></h4>-->
                        <h4><a href="/?page=phone_details&id=<?= $phone->smartphone_id. '&brand_id='. $phone->brand_id; ?>"><?= $phone-> model; ?></a></h4>

                        <div class="info-price">
                            <span class="price"><?= $phone->price . '$' ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <form method="post">
            <input type="hidden" style="display: none" name="phone_id" value="<?php echo $phone->smartphone_id; ?>"/>
        <input type="hidden" style="display: none" name="phone_image" value="<?php echo $phone->image; ?>"/>
        <input type="hidden" style="display: none" name="phone_model" value="<?php echo $phone->model; ?>"/>
        <input type="hidden" style="display: none" name="phone_price" value="<?php echo $phone->price; ?>"/>
            <button type="submit" class="btn add-to-cart" name="add_to_cart"><ion-icon name="cart-outline"></ion-icon></button>
        </form>
    <?php } ?>
</div>

<div class="shopping-cart" align="center" style="margin: 10px;">
    <h1 class="heading">shopping cart</h1>

    <table>
        <thead>
        <th>image</th>
        <th>name</th>
        <th>price</th>
        <th>total price</th>
        <th>action</th>
        </thead>
        <tbody>
        <?php
        if (isset($_SESSION['login']) && $_SESSION['uid']) {
        $user_obj = new User();
        $user = $user_obj->getUserById($_SESSION['uid']);
        $user_id = $user['user_id'];
        echo $user_id;

        $basket = mysqli_query($mysqli, "SELECT basket_id FROM basket WHERE user_id='$user_id'");
        $basket = mysqli_fetch_assoc($basket);
        echo $basket['basket_id'];

            $grand_total = 0;
        $cart_query =  $mysqli->query("SELECT * FROM smartphone, basket_device WHERE smartphone.smartphone_id = basket_device.smartphone_id AND basket_device.smartphone_id IN (SELECT smartphone_id FROM basket_device WHERE basket_device.basket_id = '$basket[basket_id]' )");
        while($fetch_product = $cart_query->fetch_object()){
            ?>
            <tr>
                <td><img src="<?= $fetch_product->image; ?>" style="height: 80px; width: 80px;"/></td>
                <td><?= $fetch_product->model;?></td>
                <td><?= $fetch_product->price;?></td>
                <td><form action="" method="post">
                        <input type="hidden" name="cart_id" value="<?php echo $fetch_product->basket_device_id; ?>"/>
                        <input type="number" name="cart_quantity" min="1" max="<?= $fetch_product->number_of_items; ?>"  value="<?php echo $fetch_product->quantity; ?>"/>
                        <input type="submit" name="update_cart" value="update" class="btn btn-primary">
                    </form></td>
                <td>$<?php echo $sub_total = ($fetch_product->price) * ($fetch_product->quantity)?></td>
                <td><a href="/?page=seperate_phones&action=delete&id=<?php echo $fetch_product->basket_device_id; ?>" onclick="return confirm('remove item from cart?');">remove</a></td>
            </tr>
            <?php
            $grand_total += $sub_total;
            }

        }
        ?>
        <tr>
            <td colspan="4">grand total:</td>
            <td><?php echo $grand_total; ?></td>
            <!--<td><a href="/?page=seperate_phones&action=delete_all" onclick="return confirm('delete all?')" class="btn btn-danger">delete all</a></td>-->
        </tr>
        </tbody>
    </table>
    <div>
        <a href="#" type="button" class="btn btn-success <?php echo ($grand_total > 1)?'': 'disabled' ?>">Proceed to checkout</a>
    </div>
</div>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>

