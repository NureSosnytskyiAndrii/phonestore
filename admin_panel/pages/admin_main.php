<?php
 global $mysqli;
 //$value = '';

if(isset($_GET['action']) && $_GET['action'] == "delete") {
    $mysqli->query("DELETE FROM smartphone WHERE smartphone_id='" . $_GET['id'] . "'") or die($mysqli->error);
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Phone with ID = ' . $_GET['id'] . ' has been removed!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}

if((isset($_GET['action']) && $_GET['action'] == "delete_one_order") && isset($_GET['payment_status']) && $_GET['payment_status']=="completed"){
    $mysqli->query("DELETE FROM `order` WHERE order_id='" .$_GET['id']."'");
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Order with ID = ' . $_GET['id'] . ' and status "Completed" has been removed!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}

if((isset($_GET['action']) && $_GET['action'] == "delete_one_order") && isset($_GET['payment_status']) && $_GET['payment_status']=="pending"){
    $selected_goods = mysqli_query($mysqli,"select order_items.quantity, smartphone.smartphone_id from order_items, smartphone WHERE
                     order_items.order_id = '" .$_GET['id']."' AND smartphone.smartphone_id =order_items.smartphone_id ");
    if (mysqli_num_rows($selected_goods) > 0) {
        while ($row = mysqli_fetch_assoc($selected_goods)) {
           mysqli_query($mysqli,"UPDATE `smartphone` SET number_of_items = number_of_items + '$row[quantity]' WHERE smartphone_id ='$row[smartphone_id]'");
        }
    }
    $mysqli->query("DELETE FROM `order` WHERE order_id='" .$_GET['id']."'");
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Order with ID = ' . $_GET['id'] . ' and status "Pending" has been removed!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
?>
<h1 class="text-info">Welcome to Admin Panel!</h1>
<style>
    .sidebar {
        position: fixed;
        left: 0;
        width: 250px;
        height: 100%;
        background: #4b4b4b;
    }
    * {
        text-decoration: none;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .sidebar header {
        font-size: 22px;
        color: #87D877;
        text-align: center;
        line-height: 70px;
        user-select: none;
    }
    .sidebar ul a {
        display: block;
        height: 100%;
        width: 100%;
        line-height: 65px;
        font-size: 20px;
        color: white;
        padding-left: 40px;
        box-sizing: border-box;
        border-top: 1px solid rgba(255,255,255,.1);
        border-bottom: 1px solid #FFFFFF19;
        transition: .4s;
    }
    ul li:hover a {
        padding-left: 50px;
    }
    .sidebar ul a ion-icon {
        margin-right: 16px;
    }
    .show-orders .box-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        align-items: flex-start;
        margin: 20px;
    }
    .show-orders .box-container .box {
        background-color: whitesmoke;
        border-radius: .5rem;
        padding: 2rem;
        border: 1px solid black;
    }
    .show-orders .box-container .box p span {
        color: #0e97fa;
    }
</style>
<div class="sidebar">
    <header>Admin panel</header>
    <p id="Email" style="color: #e4e7e0; font-style: italic;margin-left: 20px; font-size: 1.1em;"></p>
    <ul>
        <li><a type="button" href="#" onclick="showAllPhones()">Show phones</a></li>
        <li><a type="button" href="#" onclick="showBrands()">Show brands</a></li>
        <li><a type="button" href="#" onclick="showProviders()">Show providers</a></li>
        <li><a type="button" href="#" onclick="addNewPhone()">Add phone</a></li>
        <li><a type="button" href="#" onclick="addNewProvider()">Add provider</a></li>
        <li><a type="button" href="#" onclick="showOrders()">Orders</a></li>
        <li><a type="button" href="#" onclick="showCompletedOrders()">Completed orders</a></li>
        <li><a type="button" href="#" onclick="createOrderToProvider()">Order to provider</a></li>
        <li><a type="button" href="#" onclick="showAllUsers()">Show users</a></li>
    </ul>
</div>

<div style="margin-left: 300px;" class="container col-9" id="smartphones_one_brand" hidden="hidden">
<div class="container">
    <form method="post">
    <select name="brand">
        <?php
        $all_brands = $mysqli->query("SELECT * FROM `brand`");

        while ($Brand = $all_brands->fetch_object()) {
            ?>
            <option><?= $Brand->brand_name;?></option>

        <?php } ?>
    </select>
        <button class="btn btn-primary" formmethod="post">Show smartphones</button>
    </form>
    <?php
    if (isset($_POST['brand'])) {
        $value = $_POST['brand'];
    }
    ?>
</div>

<div class="container-fluid">
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
                            <th>Image</th>
                            <th>Model</th>
                            <th>Year of prod.</th>
                            <th>Price</th>
                            <th>Operation system</th>
                            <th>Quantity</th>
                            <th>Warranty</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $all_phones = $mysqli->query("SELECT * FROM `smartphone` WHERE brand_id = (SELECT brand_id FROM brand WHERE brand_name='$value')");

                        while ($phone = $all_phones->fetch_object()) {
                            ?>
                            <tr>
                                <td><img src="<?= $phone->image; ?>" style="height: 100px;width: 100px;"/></td>
                                <td><?= $phone-> model; ?></td>
                                <td><?= $phone->year_of_production; ?></td>
                                <td><?= $phone->price . '$' ?></td>
                                <td><?php echo $phone->operation_system ?: "Not filled"; ?></td>
                                <td><?php echo $phone->number_of_items ?: "Not filled"; ?></td>
                                <td><?php echo $phone->warranty ?: "Not filled"; ?></td>
                                <td><a type="button" class="btn btn-primary" href="/?page=phone_info&id=<?= $phone->smartphone_id;?>">Info</a></td>
                                <td><a type="button" class="btn btn-warning" href="/?page=phone_edit&id=<?= $phone->smartphone_id ?>">Edit</a></td>
                                <td>  <a href="/?page=admin_main&action=delete&id=<?= $phone->smartphone_id; ?>"
                                         class="btn btn-danger">Delete</a></td>
                                <td> <a type="button" href="/?page=add_characteristics&id=<?= $phone->smartphone_id ?>"
                                        class="btn btn-info">Characteristics</a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div style="margin-left: 300px;" class="container col-9" id="showAllBrands" hidden="hidden">
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th>Brand name</th>
            <th>Country</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $all_brands = $mysqli->query("SELECT * FROM `brand` ");

        while ($brand = $all_brands->fetch_object()) {
            ?>
            <tr>
                <td><?= $brand->brand_name; ?></td>
                <td><?= $brand->country; ?></td>
                <td> <a type="button" href="/?page=remove_brand&id=<?= $brand->brand_id; ?>"
                        class="btn btn-danger">Delete</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<div style="margin-left: 300px;" class="container col-9" id="showAllProviders" hidden="hidden">
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th>Provider name</th>
            <th>Provider surname</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $all_providers = $mysqli->query("SELECT * FROM `provider` ");

        while ($provider = $all_providers->fetch_object()) {
            ?>
            <tr>
                <td><?= $provider->provider_name; ?></td>
                <td><?= $provider->provider_surname; ?></td>
                <td><?= $provider->email; ?></td>
                <td><?= $provider->phone; ?></td>
                <td><?= $provider->address; ?></td>
                <td><a type="button" href="/?page=remove_provider&id=<?= $provider->provider_id; ?>"
                       class="btn btn-danger">Delete</a></td>
                <td><a type="button" href="/?page=edit_provider&id=<?= $provider->provider_id; ?>"
                       class="btn btn-warning">Edit</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<div style="margin-left: 300px;" class="container col-9" id="addNewPhone" hidden="hidden">
    <form action="add_new_smartphone.php" method="post" id="form" align="center">
        <p>Smartphone brand</p>
        <input type="text" name="brand"/>
        <p>Country</p>
        <input type="text" name="country"/>
        <p>Smartphone model</p>
        <input type="text" name="model"/>
        <p>Image</p>
        <input type="text" name="image"/>
        <p>Price</p>
        <input type="number" name="price"/>
        <p>Year of production</p>
        <input type="number" name="year"/>
        <p>Form factor</p>
        <input type="text" name="form_factor"/>
        <p>Operation system</p>
        <input type="text" name="operation_system"/>
        <p>Warranty</p>
        <input type="text" name="warranty"/>
        <p>Number_of_items</p>
        <input type="number" name="quantity"/>
        <p>Provider</p>
        <select name="provider">
            <?php
            $all_providers = $mysqli->query("SELECT * FROM `provider` WHERE provider.email IS NOT NULL");

            while ($Provider = $all_providers->fetch_object()) {
                ?>
                <option><?= $Provider->email; ?></option>
            <?php } ?>
        </select>
        <p>Date of providing</p>
        <input type="date" name="date_of_providing"/>
        <br/> <br/>
        <button type="submit" class="btn btn-success" style="margin: 10px;">Add new smartphone</button>
    </form>
</div>

<div style="margin-left: 300px;" class="container col-9" id="addNewProvider" hidden="hidden">
    <form method="post" id="form" align="center">
        <p>Provider name</p>
        <input type="text" name="provider_name"/>
        <p>Provider surname</p>
        <input type="text" name="provider_surname"/>
        <p>Email</p>
        <input type="email" name="email"/>
        <p>Phone</p>
        <input type="text" name="provider_phone"/>
        <p>Address</p>
        <input type="text" name="provider_address"/>
        <br/> <br/>
        <button type="submit" class="btn btn-success">Add new provider</button>
    </form>
</div>
<?php
    $provider_name = $_POST['provider_name'];
    $provider_surname = $_POST['provider_surname'];
    $email = $_POST['email'];
    $provider_phone = $_POST['provider_phone'];
    $provider_address = $_POST['provider_address'];
if(($provider_name &&  $provider_surname && $email && $provider_phone && $provider_address) != '') {
    mysqli_query($mysqli, "INSERT INTO `provider`(`provider_id`, `provider_name`, `provider_surname`, `email`, `phone`, `address`) VALUES (NULL, '$provider_name', '$provider_surname', '$email', '$provider_phone', '$provider_address')");
}
?>

<div style="margin-left: 300px;" class="container col-9 show-orders" id="showOrders" hidden="hidden">
    <div class="box-container">
    <?php
        $orders = mysqli_query($mysqli, "SELECT * FROM `order`");
        while ($show_orders = $orders->fetch_object()){
    ?>
        <form method="post" class="col-9">
            <div class="box">
                <input type="hidden" name = "order_id" value="<?=$show_orders->order_id?>"/>
                <p hidden="hidden"> user id <span><?=$show_orders->user_id;?></span></p>
                <p> name: <span><?=$show_orders->name;?></span></p>
                <p> surname: <span><?=$show_orders->surname;?></span></p>
                <p> phone number: <span><?=$show_orders->phone_number;?></span></p>
                <p> email: <span><?=$show_orders->email;?></span></p>
                <p> city: <span><?=$show_orders->city;?></span></p>
                <p> street: <span><?=$show_orders->street;?></span></p>
                <p> flat: <span><?=$show_orders->flat;?></span></p>
                <p> payment method: <span><?=$show_orders->payment_method;?></span></p>
                <p> payment status:
                    <select name="change_order_status" id="change_order">
                        <option>pending</option>
                        <option>completed</option>
                    </select>
                    <?= $show_orders->payment_status; ?>
                </p>
                <p> order date: <span><?=$show_orders->order_date;?></span></p>
                <p> order time: <span><?=$show_orders->order_time;?></span></p>
                <p> total cost: <span>$ <?=$show_orders->cost;?></span></p>
              <button class="btn btn-warning" formmethod="post">Update</button>
                <a type="button" class="btn btn-danger" href="/?page=admin_main&action=delete_one_order&id=<?=$show_orders->order_id;?>&payment_status=<?=$show_orders->payment_status;?>">Delete</a>
            </div>
        </form>
        <?php
                    echo '<div><b>Items:</b></div>';
                    $selected_goods = mysqli_query($mysqli,"select order_items.quantity, smartphone.model from order_items, smartphone WHERE
                     order_items.order_id = '$show_orders->order_id' AND smartphone.smartphone_id =order_items.smartphone_id ");

                if (mysqli_num_rows($selected_goods) > 0) {
                    while ($row = mysqli_fetch_assoc($selected_goods)) {
                        printf("%s (%s)\n", $row["model"], $row["quantity"]);
                    }
                 }
           }
        ?>
    </div>
    <?php
       if(isset($_POST['change_order_status'])){
            $val = $_POST['change_order_status'];
            echo $val;
            $order_id = $_POST['order_id'];
            echo $order_id;
            mysqli_query($mysqli, "UPDATE `order` SET payment_status = '$val' WHERE `order`.order_id = '$order_id'");
        }
    ?>
</div>

<div style="margin-left: 300px;" class="container col-9 show-orders" id="showCompletedOrders" hidden="hidden">
    <table class="table table-bordered">
        <thead>
        <tr class="text-primary">
            <th>Name</th>
            <th>Surname</th>
            <th>Phone number</th>
            <th>Email</th>
            <th>City</th>
            <th>Street</th>
            <th>Flat</th>
            <th>Payment status</th>
            <th>Order date</th>
            <th>Cost</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $all_completed_orders = $mysqli->query("SELECT * FROM `order` WHERE payment_status= 'completed' ORDER BY `order`.order_date");

        $earned_sum = 0;
        while ($show_orders = $all_completed_orders->fetch_object()) {
            ?>
        <tr>
            <td hidden="hidden"><?=$show_orders->order_id;?></td>
            <td><b><?=$show_orders->name;?></b></td>
            <td><b><?=$show_orders->surname;?></b></td>
            <td><b><?=$show_orders->phone_number;?></b></td>
            <td><b><?=$show_orders->email;?></b></td>
            <td><b><?=$show_orders->city;?></b></td>
            <td><b><?=$show_orders->street;?></b></td>
            <td><b><?=$show_orders->flat;?></b></td>
            <td><b><?= $show_orders->payment_status; ?></b></td>
            <td><b><?=$show_orders->order_date;?></b></td>
            <td><b><?=$show_orders->cost;?></b></td>
        </tr>
        <tr>
            <td><span class="badge badge-success">Items:</span></td>
        <?php
        $earned_sum += $show_orders->cost;
        $selected_goods = mysqli_query($mysqli,"select order_items.quantity, smartphone.model from order_items, smartphone WHERE
                     order_items.order_id = '$show_orders->order_id' AND smartphone.smartphone_id =order_items.smartphone_id ");
        if (mysqli_num_rows($selected_goods) > 0) {
            while ($row = mysqli_fetch_assoc($selected_goods)) {
                ?>
                <td><?=$row['model'].'('.$row['quantity'].')';?></td>
            <?php
            }
          }
        }
        ?>
        </tr>
        </tbody>
    </table>
    <h2 style="float: right;">Total earnings:<?php echo $earned_sum.'$'; ?></h2>
</div>

<div style="margin-left: 300px;" class="container col-9 show-orders" id="createOrderToProvider" hidden="hidden">
    <h3>Remained phones</h3>
    <table class="table table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>Model</th>
            <th>Quantity</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $remained_phones = $mysqli->query("SELECT * FROM `smartphone` WHERE number_of_items <= 3 ORDER BY number_of_items DESC");

        while ($Remained = $remained_phones->fetch_object()) {
            ?>
            <tr>
                <td><?=$Remained->model; ?></td>
                <td><?=$Remained->number_of_items; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <h3 align="center">Choose a provider</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Phone</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $all_providers = $mysqli->query("SELECT * FROM `provider` WHERE provider.email IS NOT NULL");

        while ($Provider = $all_providers->fetch_object()) {
            ?>
            <tr>
                <td><?=$Provider->provider_name; ?></td>
                <td><?=$Provider->provider_surname; ?></td>
                <td><?= $Provider->email; ?></td>
                <td><?=$Provider->phone; ?></td>
                <td><a type="button" class="btn btn-success" href="/?page=create_ord&id=<?=$Provider->provider_id;?>">Create order to provider</a></td>
            </tr>
    <?php } ?>
        </tbody>
    </table>
</div>

<div style="margin-left: 300px;" class="container col-9 show-orders" id="showUsers" hidden="hidden">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success">
                    <span class="text-white">Users</span>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Login</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $all_users = $mysqli->query("SELECT * FROM user ORDER BY user_id ASC ");

                        while ($user = $all_users->fetch_object()) {
                            ?>
                            <tr>
                                <td><?= $user->user_id; ?></td>
                                <td><?= $user->first_name; ?></td>
                                <td><?= $user->last_name; ?></td>
                                <td><?php echo $user->login ?: "Not filled"; ?></td>
                                <td><?php echo $user->status ?: "Not filled"; ?></td>
                                <td>
                                    <a href="/?page=user_edit&id=<?= $user->user_id; ?>" class="btn btn-primary" <?php if($user->user_id == 1){echo 'hidden="hidden"';}?>>Edit</a>
                                    <a href="/?page=user_delete&action=delete&id=<?= $user->user_id; ?>"
                                       class="btn btn-danger" <?php if($user->user_id == 1){echo 'hidden="hidden"';} ?>>Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showAllPhones() {
        document.getElementById('smartphones_one_brand').removeAttribute("hidden", true);
        document.getElementById('addNewPhone').setAttribute("hidden", true);
        document.getElementById('addNewProvider').setAttribute("hidden", true);
        document.getElementById('showAllBrands').setAttribute("hidden", true);
        document.getElementById('showAllProviders').setAttribute("hidden", true);
        document.getElementById('showOrders').setAttribute("hidden", true);
        document.getElementById('showCompletedOrders').setAttribute("hidden", true);
        document.getElementById('createOrderToProvider').setAttribute("hidden", true);
        document.getElementById('showUsers').setAttribute("hidden", true);
    }
    function addNewPhone() {
        document.getElementById('addNewPhone').removeAttribute("hidden", true);
        document.getElementById('smartphones_one_brand').setAttribute("hidden", true);
        document.getElementById('addNewProvider').setAttribute("hidden", true);
        document.getElementById('showAllBrands').setAttribute("hidden", true);
        document.getElementById('showAllProviders').setAttribute("hidden", true);
        document.getElementById('showOrders').setAttribute("hidden", true);
        document.getElementById('showCompletedOrders').setAttribute("hidden", true);
        document.getElementById('createOrderToProvider').setAttribute("hidden", true);
        document.getElementById('showUsers').setAttribute("hidden", true);
    }
    function addNewProvider() {
        document.getElementById('addNewPhone').setAttribute("hidden", true);
        document.getElementById('smartphones_one_brand').setAttribute("hidden", true);
        document.getElementById('addNewProvider').removeAttribute("hidden", true);
        document.getElementById('showAllBrands').setAttribute("hidden", true);
        document.getElementById('showAllProviders').setAttribute("hidden", true);
        document.getElementById('showOrders').setAttribute("hidden", true);
        document.getElementById('showCompletedOrders').setAttribute("hidden", true);
        document.getElementById('createOrderToProvider').setAttribute("hidden", true);
        document.getElementById('showUsers').setAttribute("hidden", true);
    }
    function showBrands(){
        document.getElementById('addNewPhone').setAttribute("hidden", true);
        document.getElementById('smartphones_one_brand').setAttribute("hidden", true);
        document.getElementById('addNewProvider').setAttribute("hidden", true);
        document.getElementById('showAllBrands').removeAttribute("hidden", true);
        document.getElementById('showAllProviders').setAttribute("hidden", true);
        document.getElementById('showOrders').setAttribute("hidden", true);
        document.getElementById('showCompletedOrders').setAttribute("hidden", true);
        document.getElementById('createOrderToProvider').setAttribute("hidden", true);
        document.getElementById('showUsers').setAttribute("hidden", true);
    }
    function showProviders() {
        document.getElementById('addNewPhone').setAttribute("hidden", true);
        document.getElementById('smartphones_one_brand').setAttribute("hidden", true);
        document.getElementById('addNewProvider').setAttribute("hidden", true);
        document.getElementById('showAllBrands').setAttribute("hidden", true);
        document.getElementById('showAllProviders').removeAttribute("hidden", true);
        document.getElementById('showOrders').setAttribute("hidden", true);
        document.getElementById('showCompletedOrders').setAttribute("hidden", true);
        document.getElementById('createOrderToProvider').setAttribute("hidden", true);
        document.getElementById('showUsers').setAttribute("hidden", true);
    }
    function showOrders() {
        document.getElementById('addNewPhone').setAttribute("hidden", true);
        document.getElementById('smartphones_one_brand').setAttribute("hidden", true);
        document.getElementById('addNewProvider').setAttribute("hidden", true);
        document.getElementById('showAllBrands').setAttribute("hidden", true);
        document.getElementById('showAllProviders').setAttribute("hidden", true);
        document.getElementById('showOrders').removeAttribute("hidden", true);
        document.getElementById('showCompletedOrders').setAttribute("hidden", true);
        document.getElementById('createOrderToProvider').setAttribute("hidden", true);
        document.getElementById('showUsers').setAttribute("hidden", true);
    }
    function showCompletedOrders() {
        document.getElementById('addNewPhone').setAttribute("hidden", true);
        document.getElementById('smartphones_one_brand').setAttribute("hidden", true);
        document.getElementById('addNewProvider').setAttribute("hidden", true);
        document.getElementById('showAllBrands').setAttribute("hidden", true);
        document.getElementById('showAllProviders').setAttribute("hidden", true);
        document.getElementById('showOrders').setAttribute("hidden", true);
        document.getElementById('showCompletedOrders').removeAttribute("hidden", true);
        document.getElementById('createOrderToProvider').setAttribute("hidden", true);
        document.getElementById('showUsers').setAttribute("hidden", true);
    }
    function createOrderToProvider() {
        document.getElementById('addNewPhone').setAttribute("hidden", true);
        document.getElementById('smartphones_one_brand').setAttribute("hidden", true);
        document.getElementById('addNewProvider').setAttribute("hidden", true);
        document.getElementById('showAllBrands').setAttribute("hidden", true);
        document.getElementById('showAllProviders').setAttribute("hidden", true);
        document.getElementById('showOrders').setAttribute("hidden", true);
        document.getElementById('showCompletedOrders').setAttribute("hidden", true);
        document.getElementById('createOrderToProvider').removeAttribute("hidden", true);
        document.getElementById('showUsers').setAttribute("hidden", true);
    }
    function showAllUsers() {
        document.getElementById('addNewPhone').setAttribute("hidden", true);
        document.getElementById('smartphones_one_brand').setAttribute("hidden", true);
        document.getElementById('addNewProvider').setAttribute("hidden", true);
        document.getElementById('showAllBrands').setAttribute("hidden", true);
        document.getElementById('showAllProviders').setAttribute("hidden", true);
        document.getElementById('showOrders').setAttribute("hidden", true);
        document.getElementById('showCompletedOrders').setAttribute("hidden", true);
        document.getElementById('createOrderToProvider').setAttribute("hidden", true);
        document.getElementById('showUsers').removeAttribute("hidden", true);
    }
</script>

