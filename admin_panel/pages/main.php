<?php
 global $mysqli;
 $value = '';
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
        <li><a type="button" href="#" onclick="addNewPhone()">Add phone</a></li>
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
                            <th>Form-factor</th>
                            <th>Operation system</th>
                            <th>Quantity</th>
                            <th>Warranty</th>
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
                                <td><?php echo $phone->form_factor ?: "Not filled"; ?></td>
                                <td><?php echo $phone->operation_system ?: "Not filled"; ?></td>
                                <td><?php echo $phone->number_of_items ?: "Not filled"; ?></td>
                                <td><?php echo $phone->warranty ?: "Not filled"; ?></td>
                                <td><a type="button" href="update_smartphones.php?id=<?= $phone->smartphone_id ?>" class="btn btn-warning">Edit</a> </td>
                                <td> <a type="button" href="Vendor/delete.php?id=<?= $phone->smartphone_id ?>"
                                        class="btn btn-danger">Delete</a></td>
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
</div>
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
            $all_providers = $mysqli->query("SELECT * FROM `provider`");

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
<script>
    function showAllPhones() {
        document.getElementById('smartphones_one_brand').removeAttribute("hidden", true);
        document.getElementById('addNewPhone').setAttribute("hidden", true);
    }
    function addNewPhone() {
        document.getElementById('addNewPhone').removeAttribute("hidden", true);
        document.getElementById('smartphones_one_brand').setAttribute("hidden", true);
    }
</script>

