<?php

require_once 'System/configuration.php';
require_once 'System/classes/User.php';
require_once 'blocks/header.php';

if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['confirm_password'])){
    if($_POST['password'] !== $_POST['confirm_password']){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Error password not equals
<button type='button' class='close' data-dismiss='alert' aria-label='Close' 
</button></div>";
    }else{

        $username = $_POST['login'];
        $password = $_POST['password'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $user_obj = new User();
        echo $user_obj->registerUser($username,$password,$first_name,$last_name, 'user');
    }
}

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 card">
            <div class="card-header bg-primary text-white">
                Registration
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Login</label>
                        <input type="text" class="form-control" name="login">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">First Name</label>
                        <input type="text" class="form-control" name="first_name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Last Name</label>
                        <input type="text" class="form-control" name="last_name">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'blocks/footer.php';
?>
