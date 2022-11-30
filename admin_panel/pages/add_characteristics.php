<?php

global $mysqli;
require_once "System/configuration.php";

$id = $_GET['id'];

if(isset($_GET['action']) && $_GET['action'] == "delete"){
    $mysqli->query("DELETE FROM `technical_characteristics` WHERE characteristic_id='".$_GET['id']."'") or die($mysqli->error);
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Characteristic with ID = '.$_GET['id'].' has been removed!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartphone characteristics</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body>
<table class="table table-striped">
    <thead class="thead-dark">
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $all_phones = $mysqli->query("SELECT * FROM `technical_characteristics` WHERE `smartphone_id` = '$id' ");

    while ($phone = $all_phones->fetch_object()) {
        ?>
        <tr>
            <td><?= $phone-> characteristic_name; ?></td>
            <td><?= $phone->description; ?></td>
            <td> <a type="button" href="/?page=add_characteristics&action=delete&id=<?= $phone->characteristic_id ?>"
                    class="btn btn-danger">Delete</a></td>
            <td> <a type="button" href="/?page=edit_one_characteristic&id=<?= $phone->characteristic_id ?>"
                    class="btn btn-warning">Edit</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<form method="post" style="margin-left: 700px;" name="characteristic">
    <input type="text" name="id" hidden="hidden"  value="<?= $id ?>"/>
    <p>Назва характеристики</p>
    <input type="text" name="name" />
    <p>Опис</p>
    <input type="text" name="description"  />
    <div>
        <button style="margin: 5px;" type="submit" formmethod="post">Add new characreristic</button>
    </div>
</form>

<div><a style="margin: 10px;" type="button" href="#" class="btn btn-block btn-success">Main page</a></div>
<?php
        $id=$_POST['id'];
        $name =$_POST['name'];
        $description = $_POST['description'];
        mysqli_query($mysqli, "INSERT INTO `technical_characteristics` (`characteristic_id`, `characteristic_name`, `description`, `smartphone_id`) VALUES (NULL, '$name', '$description', (SELECT smartphone_id FROM smartphone WHERE smartphone.smartphone_id = '$id' ) )");
?>
</body>
</html>
