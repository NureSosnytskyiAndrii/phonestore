<?php

global $mysqli;
require_once "System/configuration.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhoneStore</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <style>
        form {
            margin: 10px;
        }
        a {
            margin: 5px;
        }
    </style>
</head>
<body>

<h2 align="center" class="text-primary">Choose brand</h2>
<div class="container">
    <?php
    $all_brands = $mysqli->query("SELECT * FROM `brand`");

    while ($brand = $all_brands->fetch_object()) {
    ?>
    <div>
        <a type="button" href="/?page=seperate_phones&id=<?= $brand->brand_id ?>"
           class="btn btn-primary"><?=$brand->brand_name?></a></td>
    </div>
    <?php } ?>
</div>

<h2 align="center" class="text-primary">Newest smartphones</h2>
<div class="container form-inline" style="margin-top: 50px;margin-left: 300px;">
    <?php
        $newestPhone = mysqli_query($mysqli, "SELECT smartphone_id,smartphone.brand_id, image,price,model,brand_name FROM smartphone, brand where smartphone.brand_id=brand.brand_id ORDER BY smartphone_id DESC LIMIT 3");
        while ($phone = $newestPhone->fetch_object()) {
        ?>

    <div class="phone_card">
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
    </form>
    <?php
    }?>
</div>

<h2 align="center" class="text-primary" style="margin-top: 100px;">Top best-rated smartphones</h2>
<div class="container form-inline" style="margin-top: 50px;margin-left: 300px;">
    <?php
    $bestRatedPhone = mysqli_query($mysqli, "SELECT smartphone.smartphone_id,smartphone.brand_id, image,price,model,brand_name, AVG(rate) FROM smartphone, brand, review where smartphone.brand_id=brand.brand_id AND smartphone.smartphone_id=review.smartphone_id GROUP BY  smartphone.smartphone_id,smartphone.brand_id, image,price,model,brand_name HAVING AVG(rate) > 4 ORDER BY smartphone_id DESC LIMIT 5 ");
    while ($phone = mysqli_fetch_assoc($bestRatedPhone)) {
    ?>

    <div class="phone_card">
        <div class="product">
            <div class="image">
                <img  src="<?php echo $phone['image']?>" style="height: 200px; width: 200px;" alt="It is a photo"/>
            </div>

            <div class="info">
                <h3><?= $phone['brand_name']; ?></h3>
                <!-- <h4><a href="../Vendor/phone_details.php?id=<?= $phone['smartphone_id']. '&brand_id='. $phone['brand_id']; ?>"><?= $phone['model']; ?></a></h4>-->
                <h4><a href="/?page=phone_details&id=<?= $phone['smartphone_id']. '&brand_id='. $phone['brand_id']; ?>"><?= $phone['model']; ?></a></h4>

                <div class="info-price">
                    <span class="price"><?= $phone['price'] . '$' ?></span>
                    <span class="rate">Rate: <?= $phone['AVG(rate)']; ?></span>
                </div>
            </div>
        </div>
    </div>
    <form method="post">
        <input type="hidden" style="display: none" name="phone_id" value="<?php echo $phone['smartphone_id']; ?>"/>
        <input type="hidden" style="display: none" name="phone_image" value="<?php echo $phone['image']; ?>"/>
        <input type="hidden" style="display: none" name="phone_model" value="<?php echo $phone['model']; ?>"/>
        <input type="hidden" style="display: none" name="phone_price" value="<?php echo $phone['price']; ?>"/>
    </form>
    <?php } ?>
</div>



