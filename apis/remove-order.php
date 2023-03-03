<?php
session_start();
require_once "../db/connection.php";
include("../functions/user.php");
// $valid = array();
header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set("Asia/Manila");


if(isset($_POST["id"]) && isset($_POST["table"])){
    $id = $_POST["id"];
    $table = $_POST["table"];

    if(!id_exists_on_table($id, $table)) {
        echo json_encode(["msg" => "ID does not exist."]);
        return false;
    }

    $result = remove_order($id);
    if(!$result){
    http_response_code(401);
    echo json_encode(["status" => false, "errors" => "An error occured, please reload the page and try again later."]);
    }

    echo json_encode(["status" => true, "msg" => "Pre-order successfully removed."]);

}
else{
    echo json_encode(["status" => false, "errors" => "ID and Table is missing, please try again."]);
}


?>