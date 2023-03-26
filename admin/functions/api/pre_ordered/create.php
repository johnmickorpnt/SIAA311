<?php
include_once("../../../config/Db.php");
include_once("../../../models/PreOrder.php");

$valid = array();
$errors = array();
$response = array();
date_default_timezone_set("Asia/Manila");

$id = $_POST["id"];
$userId = $_POST["userId"];
$dishId = $_POST["dishId"];
$quantity = $_POST["quantity"];

$db = new Db();
$db = $db->connect();

$preOrderObj = new PreOrder($db);

$preOrderObj->setUserId($userId);
$preOrderObj->setDishId($dishId);
$preOrderObj->setQuantity($quantity);

if (empty($userId)) {
    $valid[1] = false;
    array_push($errors, "User ID is required.");
} else $valid[0] = true;

if (empty($dishId)) {
    $valid[2] = false;
    array_push($errors, "Dish ID is required.");
} else $valid[2] = true;


if (empty($quantity)) {
    $valid[3] = false;
    array_push($errors, "Quantity is required.");
} else if (strlen($quantity) <= 0) {
    $valid[3] = false;
    array_push($errors, "Invalid quantity number, it must be at least 1.");
} else $valid[3] = true;

if (in_array(false, $valid)) {
    $response["status"] = false;
    $response["errors"] = $errors;
    http_response_code(422);
    echo json_encode($response);
    return false;
}

$result = $preOrderObj->save();
if (!$result) {
    echo json_encode(["status" => false, "errors" => "Creating data failed. Please try again later."]);
    return false;
}

echo json_encode(["status" => true, "msg" => "Creating data Successful."]);


