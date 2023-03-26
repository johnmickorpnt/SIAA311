<?php
include_once("../../../config/Db.php");
include_once("../../../models/PreOrder.php");

header('Content-Type: application/json; charset=utf-8');
// parse_str(file_get_contents('php://input'), $_PATCH);
$valid = array();
$errors = array();
$response = array();
date_default_timezone_set("Asia/Manila");

// If image exists

if (isset($_POST["id"])) {
    $db = new Db();
    $db = $db->connect();

    $preOrderObject = new PreOrder($db);
    if (!$preOrderObject->fetch($_POST["id"])) {
        return json_encode(["errors" => "ID not found."]);
    }

    $preOrderObject->fetch($_POST["id"]);
    $preOrderObject->setUserId(date(isset($_POST["userId"]) ? $_POST["userId"] : $preOrderObject->getUserId()));
    $preOrderObject->setDishId(isset($_POST["dishId"]) ? $_POST["dishId"] : $preOrderObject->getDishId());
    $preOrderObject->setUserId(isset($_POST["userId"]) ? $_POST["userId"] : $preOrderObject->getUserId());
    $preOrderObject->setQuantity(isset($_POST["quantiy"]) ? $_POST["quantiy"] : $preOrderObject->getQuantity());
    

    $result = $preOrderObject->save($db);
    if (!$result) {
        echo json_encode(["status" => false, "errors" => "Creating data failed. Please try again later."]);
        return false;
    }
    echo json_encode(["status" => true, "msg" => "Updating data Successful."]);
}
