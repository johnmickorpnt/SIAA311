<?php
session_start();
require_once("../db/connection.php");
require_once("../functions/user.php");
require_once("../functions/menu.php");


$amount = 0;
$sessionUser = $_SESSION["user"];
if (!isset($_SESSION["user"])) {
    http_response_code(400);
    echo "Please make sure that you're logged in before making a reservations.";
}

$userId = retrieve_user_id($sessionUser);

if (!isset($_POST["id"])) {
    http_response_code(400);
    echo "Reservation ID not found.";
}
if (!isset($_POST["bank"])) {
    http_response_code(400);
    echo "Failed to select a bank.";
}

if (!isset($_POST["account_number"])) {
    http_response_code(400);
    echo "Account number is missing.";
}

if (!isset($_POST["amount"])) {
    http_response_code(400);
    echo "Amount to be payed is missing.";
} else $amount = $_POST["amount"];

if (!isset($_POST["date"])) {
    http_response_code(400);
    echo "Date payed missing.";
} else $amount = $_POST["amount"];

if (!isset($_POST["deposited_branch"])) {
    http_response_code(400);
    echo "Deposited Branch not found.";
} else $amount = $_POST["amount"];

// If amount is not less than 0 and not less than or greater than the amount to be payed.
if ($amount <= 0 ) {
    http_response_code(400);
    echo "Please make sure that the amount is appropriate";
}

$toPay = get_total_payment($userId);

if($amount != $toPay){
    http_response_code(400);
    echo "Please make sure that you're paying half of the total from your selected dishes.";
}

create_payment($_POST["id"], $_POST["bank"], $_POST["account_number"], $_POST["amount"], $_POST["date"], $_POST["deposited_branch"], "yes");
