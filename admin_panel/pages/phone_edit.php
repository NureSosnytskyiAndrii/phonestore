<?php

global $mysqli;
$phone_id = $_GET['id'];
if (isset($_GET['id'])) {

if(isset($_POST['model'])) {
    $brand = $_POST['brand'];
    $image = $_POST['image'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $year_of_production = $_POST['year_of_production'];
    $form_factor = $_POST['form_factor'];
    $operation_system = $_POST['operation_system'];
    $quantity = $_POST['number_of_items'];
    $provider = $_POST['provider'];

    mysqli_query($mysqli, "UPDATE `smartphone` SET `model` = '$model', `image` = '$image', `year_of_production` = '$year_of_production', `price`='$price',  `form_factor`='$form_factor', `number_of_items`='$quantity' WHERE smartphone_id = '$phone_id'");
    mysqli_query($mysqli, "UPDATE `smartphone` SET `brand_id` = (SELECT brand_id FROM `brand` WHERE brand_name = '$brand') WHERE `smartphone`.`smartphone_id` = '$phone_id'");
    mysqli_query($mysqli, "UPDATE `smartphone` SET `provider_id` = (SELECT provider_id FROM provider WHERE email = '$provider') WHERE `smartphone`.`smartphone_id` = '$phone_id'");

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Data saved!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
$phone = mysqli_query($mysqli, "SELECT * FROM `smartphone` WHERE `smartphone_id` = '$phone_id'");

$brand = mysqli_query($mysqli, "SELECT brand_name FROM `brand` WHERE `brand_id` = (SELECT brand_id FROM smartphone WHERE `smartphone_id` = '$phone_id')");
$brand = mysqli_fetch_assoc($brand);

$provider = mysqli_query($mysqli, "SELECT * FROM `provider` WHERE `provider_id` = (SELECT provider_id FROM smartphone WHERE smartphone.smartphone_id = '$phone_id')");
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
                   Smartphone edit
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label>Brand</label>
                            <select name="brand">
                                <option value=""><?= $brand['brand_name'] ?></option>
                                <?php
                                $all_brands = $mysqli->query("SELECT * FROM `brand` WHERE `brand_id` != (SELECT brand_id FROM `smartphone` WHERE `smartphone_id` = '$phone_id') ");

                                while ($Brand = $all_brands->fetch_object()) {
                                    ?>
                                    <option><?= $Brand->brand_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                <?php
                $phone_info = $phone->fetch_object();
                ?>
                        <div class="form-group">
                            <label>ID</label>
                            <input type="text" class="form-control" disabled="disabled" value="<?= $phone_info->smartphone_id; ?>">
                        </div>
                        <div class="form-group">
                            <label>Smartphone model</label>
                            <input type="text" name="model" class="form-control"  value="<?php echo $phone_info->model; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="text" name="image" class="form-control" value="<?= $phone_info->image; ?>">
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control"  value="<?php echo $phone_info->price; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Year of production</label>
                            <input type="text" name="year_of_production" class="form-control"  value="<?php echo $phone_info->year_of_production; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Smartphone form-factor</label>
                            <input type="text" name="form_factor" placeholder="Enter email..." class="form-control"  value="<?php echo $phone_info->form_factor; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Operation system</label>
                            <input type="text" name="operation_system" placeholder="Enter scores..." class="form-control"  value="<?php echo $phone_info->operation_system; ?>"/>
                            </div>
                        <div class="form-group">
                            <label>Provider</label>
                            <select name="provider">
                                <option><?= $provider['email']?></option>
                                <?php
                                $all_providers = $mysqli->query("SELECT * FROM `provider` WHERE provider.provider_id != (SELECT provider_id FROM smartphone WHERE smartphone_id = '$phone_id')");

                                while ($Provider = $all_providers->fetch_object()) {
                                    ?>
                                    <option><?= $Provider->email; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" name="number_of_items" placeholder="Enter phone..." class="form-control"  value="<?php echo $phone_info->number_of_items; ?>"/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
} ?>
</body>
</html>

