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
        case "admin_main":
            require_once "admin_panel/pages/admin_main.php";
            break;
        case "add_characteristics":
            require_once "admin_panel/pages/add_characteristics.php";
            break;
        case "phone_info":
            require_once "admin_panel/pages/phone_info.php";
            break;
        case "phone_edit":
            require_once "admin_panel/pages/phone_edit.php";
            break;

        default:
            require_once "Vendor/404.php";
    }
}else{
    echo "<script>location.replace('/?page=main');</script>";
}
require_once 'blocks/footer.php';
?>
