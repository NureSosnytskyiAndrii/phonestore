<?php

global $mysqli;
require_once "System/configuration.php";

$Brand_id = $_GET['id'];

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
                            <button class="btn add-to-cart"><ion-icon name="cart-outline"></ion-icon></button>
                        </div>
                    </div>
                </div>
            </div>
    <?php } ?>
</div>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>

