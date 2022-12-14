<?php
global $mysqli;
require_once "../System/configuration.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Do sql</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Do sql</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>
<body>
<div class="container-fluid" align="center">
<form action="do_sql.php" method="post">
    <textarea rows="10" cols="75" name="sql" placeholder="Write sql query here">SELECT</textarea>
    <button>Do sql</button>
</form>

<div>
    <button class="btn btn-info" onclick="showBrand()">Brand</button>
    <button class="btn btn-info" onclick="showSmartphone()">Smartphone</button>
    <button class="btn btn-info" onclick="showCharacteristics()">Characteristics</button>
    <button class="btn btn-info" onclick="showUsers()">Users</button>
    <button class="btn btn-info" onclick="showproviders()">Providers</button>
    <button class="btn btn-info" onclick="showorders()">Orders</button>
    <button class="btn btn-info" onclick="showreviews()">Reviews</button>
    <button class="btn btn-info" onclick="showorderitems()">Order items</button>
    <a type="button" class="btn btn-primary" href="http://phonestore.local/?page=main">Main page</a>
</div>
</div>

<table class="table table-striped col-6" hidden="hidden" id="users">
    <thead class="thead-dark">
    <tr>
        <th>ID</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Login</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>

    <?php

    if ($_POST['sql'] != '') {

        $sql = $_POST['sql'];
        $result = $mysqli->query("$sql");

        while ($user = $result->fetch_object()) {
            ?>
            <tr>
                <td><?= $user-> user_id; ?></td>
                <td><?= $user->first_name; ?></td>
                <td><?= $user->last_name; ?></td>
                <td><?= $user->login; ?></td>
                <td><?= $user->status; ?></td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>

<table class="table table-striped col-6" hidden="hidden" id="providers">
    <thead class="thead-dark">
    <tr>
        <th>ID</th>
        <th>Provider name</th>
        <th>Provider name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
    </tr>
    </thead>
    <tbody>

    <?php

    if ($_POST['sql'] != '') {

        $sql = $_POST['sql'];
        $result = $mysqli->query("$sql");

        while ($provider = $result->fetch_object()) {
            ?>
            <tr>
                <td><?= $provider-> provider_id; ?></td>
                <td><?= $provider->provider_name; ?></td>
                <td><?= $provider->provider_surname; ?></td>
                <td><?= $provider->email; ?></td>
                <td><?= $provider->phone; ?></td>
                <td><?= $provider->address; ?></td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>

<table class="table table-striped col-6" hidden="hidden" id="reviews">
    <thead class="thead-dark">
    <tr>
        <th>Review ID</th>
        <th>Rate</th>
        <th>Review_text</th>
        <th>User_id</th>
        <th>Smartphone_id</th>
    </tr>
    </thead>
    <tbody>

    <?php

    if ($_POST['sql'] != '') {

        $sql = $_POST['sql'];
        $result = $mysqli->query("$sql");

        while ($review = $result->fetch_object()) {
            ?>
            <tr>
                <td><?= $review-> review_id; ?></td>
                <td><?= $review->rate; ?></td>
                <td><?= $review->review_text; ?></td>
                <td><?= $review->user_id; ?></td>
                <td><?= $review->smartphone_id; ?></td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>

<table class="table table-striped col-6" hidden="hidden" id="Order_items">
    <thead class="thead-dark">
    <tr>
        <th>Order item ID</th>
        <th>Quantity</th>
        <th>smartphone_id</th>
        <th>order id</th>
    </tr>
    </thead>
    <tbody>

    <?php

    if ($_POST['sql'] != '') {

        $sql = $_POST['sql'];
        $result = $mysqli->query("$sql");

        while ($item = $result->fetch_object()) {
            ?>
            <tr>
                <td><?= $item-> order_item_id; ?></td>
                <td><?= $item->quantity; ?></td>
                <td><?= $item->smartphone_id; ?></td>
                <td><?= $item->order_id; ?></td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>

<table class="table table-striped col-6" hidden="hidden" id="orders">
    <thead class="thead-dark">
    <tr>
        <th>ID</th>
        <th> name</th>
        <th> surname</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Date</th>
        <th>Payment method</th>
        <th>Payment status</th>
        <th>cost</th>
        <th>user id</th>
        <th>city</th>
        <th>street</th>
        <th>flat</th>
    </tr>
    </thead>
    <tbody>

    <?php

    if ($_POST['sql'] != '') {

        $sql = $_POST['sql'];
        $result = $mysqli->query("$sql");

        while ($order = $result->fetch_object()) {
            ?>
            <tr>
                <td><?= $order-> order_id; ?></td>
                <td><?= $order->name; ?></td>
                <td><?= $order->surname; ?></td>
                <td><?= $order->email; ?></td>
                <td><?= $order->phone_number; ?></td>
                <td><?= $order->order_date; ?></td>
                <td><?= $order->payment_method; ?></td>
                <td><?= $order->payment_status; ?></td>
                <td><?= $order->cost; ?></td>
                <td><?= $order->user_id; ?></td>
                <td><?= $order->city; ?></td>
                <td><?= $order->street; ?></td>
                <td><?= $order->flat; ?></td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>


<table class="table table-striped col-6" hidden="hidden" id="brand">
    <thead class="thead-dark">
    <tr>
        <th>ID</th>
        <th>Brand name</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

   <?php

   if ($_POST['sql'] != '') {

       $sql = $_POST['sql'];
       $result = $mysqli->query("$sql");

       while ($brand = $result->fetch_object()) {
       ?>
       <tr>
           <td><?= $brand-> brand_id; ?></td>
           <td><?= $brand->brand_name; ?></td>
           <td><?= $brand->country; ?></td>
       </tr>
    <?php } ?>
   <?php } ?>
    </tbody>
</table>
   <table class="table table-striped" hidden="hidden" id="smartphone">
       <thead class="thead-dark">
       <tr>
           <th>Smartphone ID</th>
           <th>Image</th>
           <th>Model</th>
           <th>Year</th>
           <th>Price</th>
           <th>Form factor</th>
           <th>quantity</th>
           <th>Date of providing</th>
           <th>Operation system</th>
           <th>brand_id</th>
           <th>Provider id</th>
       </tr>
       </thead>
       <tbody>
       <?php
       if ($_POST['sql'] != '') {

       $sql = $_POST['sql'];
       $result = $mysqli->query("$sql");

       while ($phone = $result->fetch_object()) {
           ?>
           <tr>
               <td><?= $phone->smartphone_id; ?></td>
               <td><img style="height: 50px;width: 50px;" src="<?=$phone->image;?>"/></td>
               <td><?= $phone-> model; ?></td>
               <td><?= $phone->year_of_production; ?></td>
               <td><?= $phone->price . '$' ?></td>
               <td><?php echo $phone->form_factor ?: "Not filled"; ?></td>
               <td><?php echo $phone->number_of_items ?: "Not filled"; ?></td>
               <td><?php echo $phone->date_of_providing ?: "Not filled"; ?></td>
               <td><?php echo $phone->operation_system ?: "Not filled"; ?></td>
               <td><?php echo $phone->brand_id ?: "Not filled"; ?></td>
               <td><?php echo $phone->provider_id ?: "Not filled"; ?></td>
           </tr>
       <?php } ?>
       <?php } ?>
       </tbody>
   </table>

   <table class="table table-striped" hidden="hidden" id="characteristics">
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
       if ($_POST['sql'] != '') {

       $sql = $_POST['sql'];
       $result = $mysqli->query("$sql");

       while ($characteristic = $result->fetch_object()) {
           ?>
           <tr>
               <td><?= $characteristic->smartphone_id?></td>
               <td><?= $characteristic->characteristic_id;?></td>
               <td><?php echo $characteristic->characteristic_name?: "Not filled"; ?></td>
               <td><?php echo $characteristic-> description?: "Not filled"; ?></td>
           </tr>
       <?php } ?>
       <?php } ?>
       </tbody>
   </table>

    <script>
        function showBrand() {
            document.getElementById("brand").removeAttribute("hidden", true);
        }
        function showSmartphone() {
            document.getElementById("smartphone").removeAttribute("hidden", true);
        }
        function showCharacteristics() {
            document.getElementById("characteristics").removeAttribute("hidden", true);
        }
        function showUsers() {
            document.getElementById("users").removeAttribute("hidden", true);
        }
        function showproviders() {
            document.getElementById("providers").removeAttribute("hidden", true);
        }
        function showorders() {
            document.getElementById("orders").removeAttribute("hidden", true);
        }
        function showreviews() {
            document.getElementById("reviews").removeAttribute("hidden", true);
        }
        function showorderitems() {
            document.getElementById("Order_items").removeAttribute("hidden", true);
        }
    </script>
</body>
</html>