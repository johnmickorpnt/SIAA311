<?php
include_once("../../../config/Db.php");
include_once("../../../models/Reservation.php");

header('Content-Type: application/json; charset=utf-8');
$valid = array();
$errors = array();
$response = array();
date_default_timezone_set("Asia/Manila");

$_POST = json_decode(file_get_contents("php://input"), true);
if (isset($_POST["id"])) {
    $db = new Db();
    $db = $db->connect();

    $reservationObject = new Reservation($db);
    if (!$reservationObject->fetch($_POST["id"])) {
        return json_encode(["errors" => "ID not found."]);
    }

    $reservationObject->fetch($_POST["id"]);
    $reservationObject->set_status('2');

    if (!$reservationObject->is_available()) {
        echo json_encode(["status" => false, "errors" => "Date and Time/Table not available."]);
        return false;
    }

    $result = $reservationObject->save($db);
    if (!$result) {
        echo json_encode(["status" => false, "errors" => "Updating data failed. Please try again later."]);
        return false;
    }
    echo json_encode(["status" => true, "msg" => "Reservation is marked as DONE."]);
}


?>