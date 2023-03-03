<?php
include_once("../../config/Db.php");
include_once("../../models/User.php");
include_once("../../models/Reservation.php");
include_once("../../models/Dish.php");
include_once("../../models/PreOrder.php");


header('Content-Type: application/json; charset=utf-8');
$postData = json_decode(file_get_contents('php://input'), true);
if (isset($postData["id"]) && isset($postData["table"])) {
    $response = array();
    $table = $postData["table"];
    $id = $postData["id"];
    $db = new Db();
    $db = $db->connect();
    $tableObj = ($table == "users") ? new User($db) : 
    ($table == "reservations" ? new Reservation($db) : 
        ($table == "dishes" ? new Dish($db) : 
            ($table == "pre_ordered" ? new PreOrder($db) : null)));

    // Checks if table is not null
    if(!isset($tableObj)) {
        echo json_encode(["msg" => "Table cannot be found."]);
        return false;
    }

    // Tries to fetch the data. if it returns false, return error message.
    $data = $tableObj->fetch($id);

    if(!$data){
        http_response_code(404);
        echo json_encode(["msg" => "ID ($id) cannot be found. On table {$table}"]);
        return false;
    }
    
    http_response_code(200);
    echo json_encode(["msg" => "Data fetched,", "data" => $data]);
}

// If post data is missing.
else{
    http_response_code(105);
    echo json_encode(["msg" => "Missing Body Parameters"]);
}
