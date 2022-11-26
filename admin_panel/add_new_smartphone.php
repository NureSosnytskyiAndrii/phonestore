<?php
global $mysqli;
require_once '../System/configuration.php';

$brand = $_POST['brand'];
$country = $_POST['country'];
$model = $_POST['model'];
$image = $_POST['image'];
$serial_number = $_POST['serial_number'];
$price = $_POST['price'];
$year = $_POST['year'];
$form_factor = $_POST['form_factor'];
$operation_system = $_POST['operation_system'];
$warranty = $_POST['warranty'];
$quantity = $_POST['quantity'];
$provider=$_POST['provider'];
$date_of_providing = $_POST['date_of_providing'];

$brandId = "SELECT brand_id FROM brand WHERE brand_name = '$brand'" ;

echo '<div style="color: #0efa56; font-size: 2em;">
  <strong>Success!</strong> New smartphone has been added!
</div>';


mysqli_query($mysqli, "INSERT INTO `brand` (`brand_id`,`brand_name`, `country`) VALUE (NULL, '$brand', '$country')");
//mysqli_query($mysqli, "")
mysqli_query($mysqli, "INSERT INTO `smartphone` (`smartphone_id`, `model`, `image`, `price`, `year_of_production`, `form_factor`, `operation_system`, `warranty`, `date_of_providing`, `number_of_items`, `brand_id`, `provider_id`) VALUES (NULL, '$model', '$image', '$price', '$year', '$form_factor', '$operation_system', '$warranty', '$date_of_providing', '$quantity',(SELECT brand_id FROM brand WHERE brand_name = '$brand'), (SELECT provider_id FROM provider WHERE email = '$provider') )");
