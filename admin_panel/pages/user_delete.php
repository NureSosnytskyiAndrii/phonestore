<?php

global $mysqli;
$user_id = $_GET['id'];

if(isset($_GET['action']) && $_GET['action'] == "delete") {
    echo '<div style="color: #ff0e15; font-size: 2em;">
  <strong>Success!</strong> User with ID = ' . $_GET['id'] . ' has been removed!
</div>';

   $mysqli->query("DELETE FROM user WHERE user_id='".$_GET['id']."'") or die($mysqli->error);

}