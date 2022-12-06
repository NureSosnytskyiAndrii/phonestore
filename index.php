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
        case "phone_details":
            require_once "Vendor/phone_details.php";
            break;
        case "seperate_phones":
            require_once "Vendor/seperate_phones.php";
            break;
        case "checkout":
            require_once "Vendor/checkout.php";
            break;
        case "my_orders":
            require_once "Vendor/my_orders.php";
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
        case "remove_brand":
            require_once "admin_panel/pages/remove_brand.php";
            break;
        case "remove_provider":
            require_once "admin_panel/pages/remove_provider.php";
            break;
        case "edit_provider":
            require_once "admin_panel/pages/edit_provider.php";
            break;
        case "edit_one_characteristic":
            require_once "admin_panel/pages/edit_one_characteristic.php";
            break;

        default:
            require_once "Vendor/404.php";
    }
}else{
    echo "<script>location.replace('/?page=main');</script>";
}
require_once 'blocks/footer.php';
?>
