<?php
include_once("../../../config/Db.php");
include_once("../../../models/User.php");

header('Content-Type: application/json; charset=utf-8');


$valid = array();
$errors = array();
$response = array();
date_default_timezone_set("Asia/Manila");
if (
    isset($_POST["id"]) && isset($_POST["firstname"]) && isset($_POST["lastname"])
    && isset($_POST["email"]) && isset($_POST["number"])
) {
    $id = $_POST["id"];
    $fname = $_POST["firstname"];
    $lname = $_POST["lastname"];
    $email = $_POST["email"];
    $number = $_POST["number"];

    $db = new Db();
    $db = $db->connect();

    $userObj = new User($db);
    $user = $userObj->fetch($id);
    
    $userObj->set_id($id);
    $userObj->set_firstname($fname);
    $userObj->set_lastname($lname);
    $userObj->set_email($email);
    $userObj->set_number($number);


    // Validate inputs
    if (empty($id)) {
        $valid[0] = false;
        array_push($errors, "User ID is Required.");
    }
    if (empty($fname)) {
        $valid[1] = false;
        array_push($errors, "Your First name is Required.");
    } else $valid[0] = true;

    if (empty($lname)) {
        $valid[2] = false;
        array_push($errors, "Your Last name is Required.");
    } else $valid[2] = true;

    if (empty($email)) {
        $valid[3] = false;
        array_push($errors, "Your Email is Required.");
    } else $valid[3] = true;

    if (empty($number)) {
        $valid[4] = false;
        array_push($errors, "Your Phone Number is Required.");
    } else if (strlen($number) > 11 || strlen($number) < 11 || preg_match('/^[0-9]+$/', $number) == 0) {
        $valid[4] = false;
        array_push($errors, "Invalid phone number.");
    } else $valid[4] = true;

    if (!$user) {
        $valid[5] = false;
        array_push($errors, "User Does not exist.");
    } else $valid[5] = true;

    if ($userObj->is_email_not_unique($email)) {
        $valid[6] = false;
        array_push($errors, "Email is already used.");
    } else $valid[6] = true;

    if (in_array(false, $valid)) {
        $response["status"] = false;
        $response["errors"] = $errors;
        http_response_code(422);
        echo json_encode($response);
        return false;
    }

    $result = $userObj->save();

    if (!$result) {
        echo json_encode(["status" => false, "errors" => "Updating data failed. Please try again later."]);
        return false;
    }

    echo json_encode(["status" => true, "msg" => "Updating data Successful."]);
} else {
    http_response_code(105);
    echo json_encode(["msg" => "Missing Body Parameters."]);
}
