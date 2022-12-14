<?php

global $mysqli;
if (isset($_GET['id'])) {

    if (isset($_POST['login'])) {
        $user_id = $_GET['id'];
        $password = $_POST['password'];
        $password_hash = md5($password);
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $login = $_POST['login'];
        $status = $_POST['status'];

    if (!empty($password)) {
        $upd = $mysqli->query("
        UPDATE 
            user
        SET 
        password = '" . $password_hash . "',
        first_name = '" . $first_name . "',
        last_name = '" . $last_name . "',
        login = '" . $login . "',
        status = '" . $status . "'
        WHERE
            user_id =" . $user_id);
    } else {
        $upd = $mysqli->query("
        UPDATE user
        SET 
        first_name = '" . $first_name . "',
        last_name = '" . $last_name . "',
        login = '" . $login . "',
        status = '" . $status . "'
        WHERE
            user_id =" . $user_id);
    }
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Data saved!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';

}

$user = $mysqli->query('SELECT * FROM user WHERE user_id=' . $_GET['id']);

?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 card">
                <div class="card-header bg-primary text-white">
                    User view
                </div>
                <?php
                $user_info = $user->fetch_object();
                ?>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label>ID</label>
                            <input type="text" class="form-control" disabled="disabled" value="<?= $user_info->user_id; ?>">
                        </div>
                        <div class="form-group">
                            <label>Login</label>
                            <input type="text" name="login" class="form-control"  value="<?php echo $user_info->login; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control"  value=""/>
                            <small>Leave empty if you don`t want to change password</small>
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control"  value="<?php echo $user_info->first_name; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control"  value="<?php echo $user_info->last_name; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="admin" <?php if($user_info->status == "admin") { echo  'selected="selected"'; } ?> >Administrator</option>
                                <option value="user" <?php if($user_info->status == "user") { echo  'selected="selected"'; } ?> >User</option>
                            </select>
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
}