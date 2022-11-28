<?php

global $mysqli;
$id = $_GET['id'];
if (isset($_GET['id'])) {
$phone = $mysqli->query('SELECT * FROM smartphone WHERE smartphone_id=' . $_GET['id']);

$brand = mysqli_query($mysqli, "SELECT brand_name, country FROM `brand` WHERE `brand_id` = (SELECT brand_id FROM smartphone WHERE `smartphone_id` = '$id')");
$brand = mysqli_fetch_assoc($brand);

$provider = mysqli_query($mysqli, "SELECT * FROM `provider` WHERE `provider_id` = (SELECT provider_id FROM smartphone WHERE smartphone.smartphone_id = '$id')");
$provider = mysqli_fetch_assoc($provider);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartphone info</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body>
 <div class="container-fluid">
        <div class="row">
            <div class="col-12 card">
                <div class="card-header bg-primary text-white">
                    Phone info
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?= $brand['brand_name'] ?>">
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?= $brand['country'] ?>">
                    </div>
                <?php
                $phone_info = $phone->fetch_object();
                ?>
                    <div class="form-group">
                        <label>Smartphone model</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?php echo $phone_info->model ?: "Not filled"; ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?php echo $phone_info->price ?: "Not filled"; ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Year of production</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?php echo $phone_info->year_of_production ?: "Not filled"; ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Smartphone form-factor</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?php echo $phone_info->form_factor ?: "Not filled"; ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Operation system</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?php echo $phone_info->operation_system ?: "Not filled"; ?>"/>
                        </div>
                    <div class="form-group">
                        <label>Warranty</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?php echo $phone_info->warranty ?: "Not filled"; ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Provider name</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?= $provider['provider_name'] ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Provider surname</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?= $provider['provider_surname'] ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?= $provider['email'] ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Provider address</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?= $provider['address'] ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Date of providing</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?= $phone_info->date_of_providing; ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?= $phone_info->number_of_items; ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}?>
</body>
</html>