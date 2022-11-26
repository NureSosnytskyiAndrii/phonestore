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

<div class="container">
    <?php
    $all_brands = $mysqli->query("SELECT * FROM `brand`");

    while ($brand = $all_brands->fetch_object()) {
    ?>
    <div class="form-inline">
        <a type="button" href="Vendor/seperate_phones.php?id=<?= $brand->brand_id ?>"
           class="btn btn-primary"><?=$brand->brand_name?></a></td>
    </div>
    <?php } ?>
</div>

<!--<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success">
                    <span class="text-white">Smartphones</span>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                        <tr>
                            <th>Smartphone ID</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>Price</th>
                            <th>Smartphone type</th>
                            <th>Quantity</th>
                            <th>brand_id</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $all_phones = $mysqli->query("SELECT * FROM `smartphone` ");

                        while ($phone = $all_phones->fetch_object()) {
                            ?>
                            <tr>
                                <td><?= $phone->smartphone_id; ?></td>
                                <td><?= $phone-> model; ?></td>
                                <td><?= $phone->year; ?></td>
                                <td><?= $phone->price . '$' ?></td>
                                <td><?php echo $phone->type ?: "Not filled"; ?></td>
                                <td><?php echo $phone->quantity ?: "Not filled"; ?></td>
                                <td><?php echo $phone->brand_id ?: "Not filled"; ?></td>
                                <td><img style="height: 100px; width: 150px" src="<?php echo $phone->image?>"/></td>
                                <td> <a type="button" href="seperate_characteristic.php?id=<?= $phone->smartphone_id ?>"
                                        class="btn btn-info">Characteristics</a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>-->

