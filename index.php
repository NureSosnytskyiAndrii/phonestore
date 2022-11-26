<?php

session_start();
//define("ABSPATH",true);
require_once 'System/configuration.php';
require_once 'System/classes/User.php';
require_once 'blocks/header.php';

if(isset($_GET['page'])) {
    switch ($_GET['page']) {
        case "main":
            require_once "Vendor/preview.php";
            break;
        /*case "users_list":
            require_once "pages/users_list.php";
            break;
        case "user_edit":
            require_once "pages/user_edit.php";
            break;
        case "user_view":
            require_once "pages/user_view.php";
            break;
*/

        default:
            require_once "Vendor/404.php";
    }
}else{
    echo "<script>location.replace('/?page=main');</script>";
}
require_once 'blocks/footer.php';
?>
