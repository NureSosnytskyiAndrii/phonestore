<?php

session_start();

require_once '../System/configuration.php';
require_once '../System/classes/App.php';
require_once '../System/classes/User.php';
require_once '../blocks/header.php';

if(isset($_GET['page'])) {
    switch ($_GET['page']) {
        case "main":
            require_once "pages/main.php";
            break;
        case "edit_config":
            require_once "pages/edit_config.php";
            break;
        default:
            require_once "/pages/404.php";
    }
}else{
    echo "<script>location.replace('/admin_panel/?page=main');</script>";
}
require_once 'blocks/footer.php';
?>