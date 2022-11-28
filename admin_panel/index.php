<?php

session_start();

require_once '../System/configuration.php';
require_once '../System/classes/App.php';
require_once '../System/classes/User.php';
require_once '../blocks/header.php';

if(isset($_GET['page'])) {
    switch ($_GET['page']) {
        case "admin_main":
            require_once "pages/admin_main.php";
            break;
        case "add_characteristics":
            require_once "pages/add_characteristics.php";
            break;
        case "phone_info":
            require_once "pages/phone_info.php";
            break;
        case "phone_edit":
            require_once "pages/phone_edit.php";
            break;
        default:
            require_once "/pages/404.php";
    }
}else{
    echo "<script>location.replace('/admin_panel/?page=admin_main');</script>";
}
require_once 'blocks/footer.php';
?>