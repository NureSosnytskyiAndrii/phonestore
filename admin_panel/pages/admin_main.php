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
        <li><a type="button" href="#">Orders</a></li>
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
<script>
    function showAllPhones() {
        document.getElementById('smartphones_one_brand').removeAttribute("hidden", true);
        document.getElementById('addNewPhone').setAttribute("hidden", true);
        document.getElementById('addNewProvider').setAttribute("hidden", true);
        document.getElementById('showAllBrands').setAttribute("hidden", true);
        document.getElementById('showAllProviders').setAttribute("hidden", true);
    }
    function addNewPhone() {
        document.getElementById('addNewPhone').removeAttribute("hidden", true);
        document.getElementById('smartphones_one_brand').setAttribute("hidden", true);
        document.getElementById('addNewProvider').setAttribute("hidden", true);
        document.getElementById('showAllBrands').setAttribute("hidden", true);
        document.getElementById('showAllProviders').setAttribute("hidden", true);
    }
    function addNewProvider() {
        document.getElementById('addNewPhone').setAttribute("hidden", true);
        document.getElementById('smartphones_one_brand').setAttribute("hidden", true);
        document.getElementById('addNewProvider').removeAttribute("hidden", true);
        document.getElementById('showAllBrands').setAttribute("hidden", true);
        document.getElementById('showAllProviders').setAttribute("hidden", true);
    }
    function showBrands(){
        document.getElementById('addNewPhone').setAttribute("hidden", true);
        document.getElementById('smartphones_one_brand').setAttribute("hidden", true);
        document.getElementById('addNewProvider').setAttribute("hidden", true);
        document.getElementById('showAllBrands').removeAttribute("hidden", true);
        document.getElementById('showAllProviders').setAttribute("hidden", true);
    }
    function showProviders() {
        document.getElementById('addNewPhone').setAttribute("hidden", true);
        document.getElementById('smartphones_one_brand').setAttribute("hidden", true);
        document.getElementById('addNewProvider').setAttribute("hidden", true);
        document.getElementById('showAllBrands').setAttribute("hidden", true);
        document.getElementById('showAllProviders').removeAttribute("hidden", true);
    }
</script>

