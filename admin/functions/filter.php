<?php
include_once("reservations.php");

$filter_errors = $_SESSION["filter_errors"];
$filter_status = $_SESSION["filter_msg"];
if(!isset($_GET["status"])){
    array_push($filter_errors, "Status not found.");
}
$status = $_GET["status"];
get_with_filter($status);
array_push($filter_msg, "Filtered");

?>