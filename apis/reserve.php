<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

session_start();
require_once "../db/connection.php";
require_once "../functions/user.php";

if (!isset($_SESSION["user"])) {
    http_response_code(400);
    return "Please make sure that you're logged in before making a reservations.";
}
header('Content-Type: application/json; charset=utf-8');
$responseData = array();
$_SESSION["msg"] = array();
$user = $_SESSION["user"];

if (!isset($_POST["date"]) || !isset($_POST["time"]) || !isset($_POST["tblId"])) {
    http_response_code(400);
    return "An error occured. Please Try again.";
}

// Validate the reservation by finding overlapping date and times on the same table.

// If date is given, then use it. Otherwise, use the date today and add a day.
$date = date($_POST["date"]);
// If the time is given, then use it. Otherwise, use the 9am time.
$time = date("H:i:s", strtotime($_POST["time"]));
$queryTime = date("{$date} {$time}");
$queryEndTime = date('Y-m-d H:i:s', strtotime($queryTime . ' + 2 hours'));
$tblId = $_POST["tblId"] == "28" ? "11" : $_POST["tblId"];

// SQL to find for overlapping bookings.
$sql = "SELECT * FROM reservations WHERE date = '{$date}' 
    AND '{$queryTime}' < endTime AND tableId = '{$tblId}';";
$result = mysqli_query($db, $sql);
$isNotValid = mysqli_num_rows($result);

// Checks if the number of row is greater than 0.
if ($isNotValid) {
    $responseData["status"] = 0;
    $responseData["msg"] = "It seems you're trying to reserve to a table that has been already booked. Please try a different table or date or time.";

    return json_encode($_SESSION["msg"]);
}

$userId = retrieve_user_id($user);

$result = mysqli_query($db, $sql);


// Once validated, create the reservation.
$sql = "INSERT INTO reservations (date, startTime, endTime, user, tableId) 
VALUES ('{$date}', '$queryTime','$queryEndTime', '{$userId}','$tblId')";
mysqli_query($db, $sql);
$responseData["status"] = 1;
$responseData["msg"] = "Booking has been saved successfully. Please wait for our approval.";

echo json_encode($responseData);
