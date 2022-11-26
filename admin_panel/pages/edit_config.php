<?php
global $mysqli;
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit configuration</h1>
</div>

<?php


if(isset($_POST['sitename'])){
    $sitename = $_POST['sitename'];
    $slogan = $_POST['slogan'];
    $email = $_POST['site_email'];
    $phone = $_POST['site_phone'];
    $address = $_POST['site_address'];
    $upd = $mysqli->query("
        UPDATE 
            configuration
        SET 
            sitename = '$sitename',
            slogan = '$slogan',
            site_email = '$email',
            site_phone = '$phone',
            site_address = '$address'
        WHERE
            id = 1");
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Data saved!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}


$config_q = $mysqli->query('SELECT * FROM configuration WHERE id = 1');
$config = $config_q->fetch_object();
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        Edit Config
    </div>
    <div class="card-body">
        <form method="post">
            <div class="form-group">
                <label>Site Name</label>
                <input type="text" name="sitename" class="form-control"  value="<?php echo $config->sitename; ?>"/>
            </div>
            <div class="form-group">
                <label>Slogan</label>
                <input type="text" name="slogan" class="form-control"  value="<?php echo $config->slogan; ?>"/>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="site_email" class="form-control"  value="<?php echo $config->site_email; ?>"/>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="site_phone" class="form-control"  value="<?php echo $config->site_phone; ?>"/>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="site_address" placeholder="Enter address" class="form-control"  value="<?php echo $config->site_address; ?>"/>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block">Save Changes</button>
            </div>
        </form>
    </div>
</div>