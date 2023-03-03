<?php
include_once("../../../config/Db.php");
include_once("../../../models/Reservation.php");

header('Content-Type: application/json; charset=utf-8');
$valid = array();
$errors = array();
$response = array();
date_default_timezone_set("Asia/Manila");

try {
    $id = $_POST["id"];
    $date = date($_POST["date"]);
    $startTime = date('H:i:s', strtotime($_POST["startTime"]));
    $endTime = date('H:i:s', strtotime($_POST["endTime"]));
    $user = $_POST["user"];
    $tblId = $_POST["tableId"];
    $status = isset($_POST["status"]) ? $_POST["status"] : '0';
} catch (Exception $e) {
    echo json_encode(["status" => false, "errors" => "Make sure all inputs are filled."]);
    return false;
}


$db = new Db();
$db = $db->connect();

$reservationObj = new Reservation($db);

$reservationObj->set_id($id);
$reservationObj->set_date(date('Y-m-d', strtotime($date)));
$reservationObj->set_startTime(date('Y-m-d H:i:s', strtotime("{$date} {$startTime}")));
$reservationObj->set_endTime(date('Y-m-d H:i:s', strtotime("{$date} {$endTime}")));
$reservationObj->set_user($user);
$reservationObj->set_tblId($tblId);
$reservationObj->set_status($status);


if (empty($date)) {
    $valid[1] = false;
    array_push($errors, "Date is Required.");
} else $valid[0] = true;

if (empty($startTime)) {
    $valid[2] = false;
    array_push($errors, "Start Time is Required.");
} else $valid[2] = true;

if (empty($endTime)) {
    $valid[3] = false;
    array_push($errors, "End Time is Required.");
} else $valid[3] = true;

if (empty($status) && $status !== '0') {
    $valid[4] = false;
    array_push($errors, "Status is Required.");
} else $valid[4] = true;

if (in_array(false, $valid)) {
    $response["status"] = false;
    $response["errors"] = $errors;
    http_response_code(422);
    echo json_encode($response);
    return false;
}



if (!$reservationObj->is_available()) {
    echo json_encode(["status" => false, "errors" => "Date and Time/Table not available."]);
    return false;
}

$result = $reservationObj->new();
if (!$result) {
    echo json_encode(["status" => false, "errors" => "Creating data failed. Please try again later."]);
    return false;
}

echo json_encode(["status" => true, "msg" => "Creating data Successful."]);
