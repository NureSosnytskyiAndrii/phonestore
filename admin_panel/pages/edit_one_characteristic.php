<?php

global $mysqli;
$characteristic_id = $_GET['id'];
if (isset($_GET['id'])) {

if(isset($_POST['characteristic_name'])) {
    $characteristic_name = $_POST['characteristic_name'];
    $characteristic_description = $_POST['description'];

    mysqli_query($mysqli, "UPDATE `technical_characteristics` SET `characteristic_name` = '$characteristic_name', `description` = '$characteristic_description' WHERE characteristic_id = '$characteristic_id'");

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Data saved!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
    $characteristic = mysqli_query($mysqli, "SELECT * FROM `technical_characteristics` WHERE characteristic_id = '$characteristic_id'");
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
                    $characteristic_info = $characteristic->fetch_object();
                    ?>
                    <div class="form-group">
                        <label>ID</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?= $characteristic_info->characteristic_id; ?>">
                    </div>
                    <div class="form-group">
                        <label>Smartphone model</label>
                        <input type="text" name="characteristic_name" class="form-control"  value="<?php echo $characteristic_info->characteristic_name; ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Smartphone model</label>
                        <input type="text" name="description" class="form-control"  value="<?php echo $characteristic_info->description; ?>"/>
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
