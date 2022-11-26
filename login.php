<?php

session_start();
require_once 'System/configuration.php';
require_once 'System/classes/User.php';
/** Auth handler Begin **/

if(isset($_POST['login']) && isset($_POST['password'])){

    global $mysqli;
    $login = $_POST['login'];
    $password = $_POST['password'];
    $user = new User();
    $user->authUser($login, $password);
}

/** Auth handler End **/


require_once 'blocks/header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 card">
            <div class="card-header bg-success text-white">
                Log in
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
                    <button type="submit" class="btn btn-primary">Log in -></button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php
require_once 'blocks/footer.php';
?>
