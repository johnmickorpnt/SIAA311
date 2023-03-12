<?php
session_start();
require_once("../db/connection.php");
require_once("../functions/user.php");
require_once("../functions/menu.php");


$amount = 0;
$sessionUser = $_SESSION["user"];
if (!isset($_SESSION["user"])) {
    http_response_code(400);
    return "Please make sure that you're logged in before making a reservations.";
}

$userId = retrieve_user_id($sessionUser);

if (!isset($_POST["bank"])) {
    http_response_code(400);
    return "Failed to select a bank.";
}

if (!isset($_POST["account_number"])) {
    http_response_code(400);
    return "Account number is missing.";
}


if (!isset($_POST["amount"])) {
    http_response_code(400);
    return "Account number is missing.";
} else $amount = $_POST["amount"];

// If amount is not less than 0 and not less than or greater than the amount to be payed.
if ($amount <= 0 ) {
    http_response_code(400);
    return "Please make sure that the amount is appropriate";
}


?>