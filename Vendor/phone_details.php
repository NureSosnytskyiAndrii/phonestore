<?php

global $mysqli;
require_once "System/configuration.php";

$phone_id = $_GET['id'];
$brand_id = $_GET['brand_id'];
$user_id = $_GET[''];

if (isset($_SESSION['login']) && $_SESSION['uid']) {
    $user_obj = new User();
    $user = $user_obj->getUserById($_SESSION['uid']);
    $user_id = $user['user_id'];
    $user_status = $user['status'];

    if (isset($_GET['action']) && $_GET['action'] == "delete_review") {
        $mysqli->query("DELETE FROM review WHERE review_id='" . $_GET['id'] . "'") or die($mysqli->error);
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Review has have been removed!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Phone info</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <style>
        .container-buttons {
            display: flex;
            justify-content: space-around;
        }
        .container-buttons button {
            margin: 5px;
        }
        .container {
            float: left;
            margin-left: 200px;
        }
        table {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container col-4">
    <div class="row">
        <?php
        //$all_phones = $mysqli->query("SELECT image, model, price FROM smartphone WHERE smartphone_id = '$phone_id'");
        $avg_rating = $mysqli->query("SELECT AVG(rate) FROM review WHERE smartphone_id='$phone_id'");
        $avg_rating = mysqli_fetch_assoc($avg_rating);
        $all_phones = $mysqli->query("SELECT image, brand.brand_name, model, price, operation_system, form_factor FROM smartphone, brand WHERE smartphone.smartphone_id = '$phone_id' and smartphone.brand_id = brand.brand_id  AND brand.brand_name in (SELECT brand.brand_name FROM brand WHERE brand.brand_id = '$brand_id')");
        while ($phone = $all_phones->fetch_object()) {
        ?>
        <div class="col-md-4">
            <div class="product">
                <div class="image">
                    <img  src="<?php echo $phone->image?>" style="height: 300px; width: 300px;" alt="It is a photo"/>
                </div>

                <div class="info">
                    <h4><?= $phone->brand_name; ?></h4>
                    <h4><?= $phone-> model; ?></h4>

                    <div class="info-price">
                        <span class="price"><b>Price:</b> <?= $phone->price . '$' ?></span>
                        <div>
                            <span class="rate"><b>Rate:</b> <?= $avg_rating['AVG(rate)'] ?: "Not filled"; ?></span>
                        </div>
                        <div>
                            <span><b>Description:</b> <?="Operation system: ". $phone->operation_system ."; form-factor: ". $phone->form_factor;?></span>
                        </div>
                        <div class="container-buttons">
                            <button class="btn btn-success" onclick="showAllCharacteristics()">Show characteristics</button>

                            <?php
                        if (isset($_SESSION['login']) && $_SESSION['uid']) {
                            $user_obj = new User();
                            $user = $user_obj->getUserById($_SESSION['uid']);
                            $user_first_name = $user['first_name'];
                            $user_last_name = $user['last_name'];
                                echo '<button class="btn btn-success" onclick="showReviewForm()">Leave a review</button>';
                        }
                        ?>
                            <a href="#" onclick="showAllReviews()">Show reviews</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<div id="characteristics" hidden="hidden">
<h2 style="color: #f11e1e">Characteristics</h2>
<table class="table table-striped col-6">
    <thead class="thead-light">
    <tr>
        <th>Name</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $all_phones = $mysqli->query("SELECT * FROM `technical_characteristics` WHERE smartphone_id = '$phone_id'");

    while ($phone = $all_phones->fetch_object()) {
        ?>
        <tr>
            <td><?php echo $phone->characteristic_name?: "Not filled"; ?></td>
            <td><?php echo $phone-> description?: "Not filled"; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</div>

<table class="table col-9" hidden="hidden" id="reviews">
    <thead>
    <tr>
        <th scope="col">Username</th>
        <th scope="col">Review</th>
        <th scope="col">Rate</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (isset($_SESSION['login']) && $_SESSION['uid']) {
    $user_obj = new User();
    $user = $user_obj->getUserById($_SESSION['uid']);
    $user_id = $user['user_id'];
        $all_reviews = mysqli_query($mysqli, "SELECT review_id, rate, review_text, user.login, review.user_id  FROM review, user WHERE user.user_id = review.user_id AND smartphone_id = '$phone_id' ORDER BY rate DESC");
        while ($fetch_reviews = $all_reviews->fetch_object()){
    ?>
    <tr>
        <td hidden="hidden"><?=$fetch_reviews->user_id;?></td>
        <td><?=$fetch_reviews->login;?></td>
        <td><?=$fetch_reviews->review_text;?></td>
        <td><?=$fetch_reviews->rate;?></td>
        <td><a type="button" class="btn btn-danger" <?php if($user['user_id'] != $fetch_reviews->user_id){echo 'hidden="hidden"';}?> href="/?page=phone_details&action=delete_review&id=<?=$fetch_reviews->review_id;?>">Delete</a></td>
    </tr>
    <?php } }?>
    </tbody>
</table>

<div id="reviewForm" hidden="hidden" class="col-6" style="margin-left: 400px;margin-top: 300px;">
    <h2 style="color: #007bff;">Leave a review</h2>
<form method="post">
    <div class="form-group">
        <label for="exampleFormControlSelect1">Choose rating</label>
        <select class="form-control" name="rate">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
    </div>
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Your comment</label>
        <textarea class="form-control" name="review_text" rows="3"></textarea>
    </div>
    <div>
        <button style="margin: 5px;" class="btn btn-primary" formmethod="post"> Post a review </button>
    </div>
</form>
    <?php
    if (isset($_SESSION['login']) && $_SESSION['uid']) {
        $user_obj = new User();
        $user = $user_obj->getUserById($_SESSION['uid']);
        $user_id = $user['user_id'];

        if(isset($_POST['review_text'])) {
            $text = $_POST['review_text'];
            $rate = $_POST['rate'];
            mysqli_query($mysqli, "INSERT INTO `review`(review_id, rate, review_text, user_id, smartphone_id) VALUES (NULL,  '$rate', '$text', '$user_id', '$phone_id')");
            echo '<script>alert("New review was added!")</script>';
        }
    }
    ?>
</div>

<script>
    function showAllCharacteristics() {
        document.getElementById('characteristics').removeAttribute("hidden", true);
    }
    function showReviewForm() {
        document.getElementById('reviewForm').removeAttribute("hidden", true);
    }
    function showAllReviews() {
        document.getElementById('reviews').removeAttribute("hidden", true);
    }
</script>
</body>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
