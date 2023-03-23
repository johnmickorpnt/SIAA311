<?php
session_start();
require_once("../db/connection.php");
require_once("../functions/user.php");
require_once("../functions/menu.php");



$sessionUser = $_SESSION["user"];
$preOrderId = 0;

if (!isset($_SESSION["user"])) {
    http_response_code(400);
    return "Please make sure that you're logged in before making a reservations.";
}

$userId = retrieve_user_id($sessionUser);

if (!isset($_POST["data-id"])) {
    http_response_code(400);
    echo "Failed to select an item. Please try again.";
    return false;
}

if (!isset($_POST["isActive"])) {
    http_response_code(400);
    echo "Failed to check if row is active or inactive.";
    return false;
}


$preOrderId = $_POST["data-id"];
$sql = "SELECT * FROM `pre_ordered` WHERE id = {$preOrderId} AND userId = {$userId}";
$result = mysqli_query($db, $sql);
$pre_ordered = mysqli_fetch_assoc($result);
$rowCount = mysqli_num_rows($result);
$val = $pre_ordered["isActive"] ? 0 : 1;

// // IF ROW EXISTS, Return back to page and notify user to add a dish
if ($rowCount <= 0) {
    // quantify_order($userId, $dishId, $qty, $reservation);
    return json_encode(["status" => 0, "body" => "Pre-Order ID cannot be found."]);
} else {
    echo json_encode(
        [
            "status" => updateActive($preOrderId, $userId, $val),
            "data" => get_pre_orders($sessionUser)
        ]
    );
}
