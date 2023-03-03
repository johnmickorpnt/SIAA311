<?php
include_once("../../config/Db.php");
include_once("../../models/User.php");
include_once("../../models/Reservation.php");
include_once("../../models/Dish.php");
include_once("../../models/PreOrder.php");

header('Content-Type: application/json; charset=utf-8');
$postData = json_decode(file_get_contents('php://input'), true);
$valid = array();
$errors = array();
$response = array();
date_default_timezone_set("Asia/Manila");

if (isset($postData["id"]) && isset($postData["table"])) {
    $response = array();
    $table = $postData["table"];
    $id = $postData["id"];
    $db = new Db();
    $db = $db->connect();
    $tableObj = ($table == "users") ? new User($db) : ($table == "reservations" ? new Reservation($db) : ($table == "dishes" ? new Dish($db) : ($table == "pre_ordered" ? new PreOrder($db) : null)));
    if($table === "pre_ordered") $tableObj->setId($id);
    else $tableObj->set_id($id);
    $objData = $tableObj->fetch($id);

    if(!$objData){
        http_response_code(422);
        echo json_encode(["status"=>"0", "msg" => "ID cannot be found. Please reload the page and try again."]);
        return false;
    }

    $result = $tableObj->delete();

    if(!$result){
        http_response_code(422);
        echo json_encode(["status"=>"0", "msg" => "Failed to delete. Please try again."]);
        return false;
    }

    http_response_code(200);
    echo json_encode(["status"=>"1", "msg" => "Row has been successfully deleted."]);

}

// If post data is missing.
else {
    http_response_code(105);
    echo json_encode(["msg" => "Missing Body Parameters"]);
}
