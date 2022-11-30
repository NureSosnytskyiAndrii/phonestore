<?php

global $mysqli;
require_once "System/configuration.php";

$phone_id = $_GET['id'];
$brand_id = $_GET['brand_id'];

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Phone info</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body>
<div class="container col-4 form-inline">
    <div class="row">
        <?php
        //$all_phones = $mysqli->query("SELECT image, model, price FROM smartphone WHERE smartphone_id = '$phone_id'");
        $all_phones = $mysqli->query("SELECT image, brand.brand_name, model, price FROM smartphone, brand WHERE smartphone_id = '$phone_id' and smartphone.brand_id = brand.brand_id AND brand.brand_name in (SELECT brand.brand_name FROM brand WHERE brand.brand_id = '$brand_id')");
        while ($phone = $all_phones->fetch_object()) {
        ?>
        <div class="col-md-4">
            <div class="product">
                <div class="image">
                    <img  src="<?php echo $phone->image?>" style="height: 300px; width: 300px;" alt="It is a photo"/>
                </div>

                <div class="info">
                    <h4><?= $phone->brand_name; ?></h4>
                    <h4><?= $phone-> model; ?></h4>

                    <div class="info-price">
                        <span class="price">Price <?= $phone->price . '$' ?></span>

                        <?php
                        if (isset($_SESSION['login']) && $_SESSION['uid']) {
                            $user_obj = new User();
                            $user = $user_obj->getUserById($_SESSION['uid']);
                            $user_first_name = $user['first_name'];
                            $user_last_name = $user['last_name'];

                            echo '<button class="btn add-to-cart" >Add to chart</button>';
                        }
                        ?>
                        <button class="btn btn-primary" onclick="showAllCharacteristics()">Show characteristics</button>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<table class="table table-striped" id="characteristics" hidden="hidden">
    <thead class="thead-dark">
    <tr>
        <th>Smartphone ID</th>
        <th>Characteristic ID</th>
        <th>Name</th>
        <th>Description</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $all_phones = $mysqli->query("SELECT * FROM `technical_characteristics` WHERE smartphone_id = '$phone_id'");

    while ($phone = $all_phones->fetch_object()) {
        ?>
        <tr>
            <td><?= $phone->smartphone_id?></td>
            <td><?= $phone->characteristic_id;?></td>
            <td><?php echo $phone->characteristic_name?: "Not filled"; ?></td>
            <td><?php echo $phone-> description?: "Not filled"; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script>
    function showAllCharacteristics() {
        document.getElementById('characteristics').removeAttribute("hidden", true);
    }
</script>
</body>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
