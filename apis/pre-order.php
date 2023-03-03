<?php
session_start();
require_once("../db/connection.php");
require_once("../functions/user.php");
require_once("../functions/menu.php");

// header('Content-Type: application/json; charset=utf-8');

$responseData = array();
$_SESSION["msg"] = array();
$qty = $_POST["quantity"];
$reservation = $_POST["reservation"];

if (!isset($_SESSION["user"])) {
    http_response_code(400);
    return "Please make sure that you're logged in before making a reservations.";
}

if (!isset($_POST["dishId"])) {
    http_response_code(400);
    return "Dish ID not found.";
}

if (!isset($reservation)) {
    http_response_code(400);
    return "Table reservation not found. Please make a reservation first.";
}

if ($qty <= 0) {
    http_response_code(400);
    return "Please make sure you have selected the appropriate amount of order quantity.";
}


$userId = retrieve_user_id($_SESSION["user"]);
$dishId = $_POST["dishId"];

if (!dish_exists($dishId)) {
    http_response_code(400);
    echo "Dish Doesn't exist. Please reload the page and try again.";
}


$sql = "SELECT * FROM `pre_ordered` WHERE userId = '$userId' AND dishId = '$dishId' AND reservationId = $reservation";

$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$rowCount = mysqli_num_rows($result);

// IF ROW EXISTS, ADD THE QTY.
if ($rowCount > 0) {
    quantify_order($userId, $dishId, $qty, $reservation);
}
// OTHERWISE, INSERT DATA
else {
    create_order($userId, $dishId, $qty, $reservation);
    echo "insert";
}



// FIND EXISTING USER ID AND DISH ID
// IF BOTH EXISTS IN A ROW
// CANCEL ACTION AND REDIRECT BACK.
// OTHERWISE, CONTINUE ACTION AND INSERT DATA.
