<?php

global $mysqli;
require_once "System/configuration.php";

$id = $_GET['id'];

echo '<div style="color: #ff0e15; font-size: 2em;">
  <strong>Success!</strong> Provider with ID = ' .$_GET['id'].' has been removed!
</div>';

mysqli_query($mysqli, "DELETE FROM `provider` WHERE `provider`. `provider_id` = '$id'");
