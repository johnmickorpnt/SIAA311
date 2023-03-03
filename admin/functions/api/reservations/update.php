<?php
include_once("../../../config/Db.php");
include_once("../../../models/Reservation.php");

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

    $reservationObject = new Reservation($db);
    if (!$reservationObject->fetch($_POST["id"])) {
        return json_encode(["errors" => "ID not found."]);
    }

    $reservationObject->fetch($_POST["id"]);
    $reservationObject->set_date(date(isset($_POST["date"]) ? $_POST["date"] : $reservationObject->get_date()));
    $t = date('H:i:s', strtotime(isset($_POST["startTime"]) ? $_POST["startTime"] : $reservationObject->get_startTime()));
    $et = date('H:i:s', strtotime(isset($_POST["endTime"]) ? $_POST["endTime"] : $reservationObject->get_endTime()));
    $reservationObject->set_startTime(date('Y-m-d H:i:s', strtotime("{$reservationObject->get_date()} {$t}")));
    $reservationObject->set_endTime(date('Y-m-d H:i:s', strtotime("{$reservationObject->get_date()} {$et}")));
    $reservationObject->set_user(isset($_POST["user"]) ? $_POST["user"] : $reservationObject->get_user());
    $reservationObject->set_tblId(isset($_POST["tableId"]) ? $_POST["tableId"] : $reservationObject->get_tblId());
    $reservationObject->set_status(isset($_POST["status"]) ? $_POST["status"] : $reservationObject->get_status());

    if (!$reservationObject->is_available()) {
        echo json_encode(["status" => false, "errors" => "Date and Time/Table not available."]);
        return false;
    }

    $result = $reservationObject->save($db);
    if (!$result) {
        echo json_encode(["status" => false, "errors" => "Updating data failed. Please try again later."]);
        return false;
    }
    echo json_encode(["status" => true, "msg" => "Updating data Successful."]);
}
