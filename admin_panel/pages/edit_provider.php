<?php

global $mysqli;
$provider_id = $_GET['id'];

if(isset($_GET['id'])) {

if(isset($_POST['provider_name'])) {
   $provider_surname = $_POST['provider_surname'];
   $provider_name = $_POST['provider_name'];
   $email = $_POST['email'];
   $provider_phone = $_POST['phone'];
   $address = $_POST['address'];

    mysqli_query($mysqli, "UPDATE `provider` SET `provider_name` = '$provider_name', `provider_surname` = '$provider_surname', `email` = '$email', `phone`='$provider_phone',  `address`='$address' WHERE provider_id = '$provider_id'");

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Data saved!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
$provider = mysqli_query($mysqli, "SELECT * FROM `provider` WHERE `provider_id` = '$provider_id'");

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
                    <?php
                    $provider_info = $provider->fetch_object();
                    ?>
                    <div class="form-group">
                        <label>ID</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?= $provider_info->provider_id; ?>">
                    </div>
                    <div class="form-group">
                        <label>Smartphone model</label>
                        <input type="text" name="provider_name" class="form-control"  value="<?php echo $provider_info->provider_name; ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="text" name="provider_surname" class="form-control" value="<?= $provider_info->provider_surname; ?>">
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="email" class="form-control"  value="<?php echo $provider_info->email; ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Year of production</label>
                        <input type="text" name="phone" class="form-control"  value="<?php echo $provider_info-> phone; ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Smartphone form-factor</label>
                        <input type="text" name="address" placeholder="Enter email..." class="form-control"  value="<?php echo $provider_info->address; ?>"/>
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
