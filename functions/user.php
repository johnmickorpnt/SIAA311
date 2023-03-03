<?php
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$file = str_contains($url, "SIAA311") ?
    substr($url, strpos($url, "SIAA311") + 7) : substr($url, strpos($url, "/"));
require(strrpos($file, "/") > 0 ? "../db/connection.php" : "db/connection.php");

function retrieve_user_id($email)
{
    global $db;
    $sql = "SELECT id FROM users WHERE email = '{$email}';";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);

    if (empty($row)) {
        array_push($_SESSION["msg"], "User Email does not exist. Please go to our registration page before making a reservation.");
        return header('Location: ' . '../views/auth/login.php');
    }
    return $row["id"];
}

function get_reservations($email, $status)
{
    $id = retrieve_user_id($email);
    global $db;
    $status = $status !== null ? "AND status = '{$status}'" : "";
    // Select all reservations depending on the status passed
    $sql = "SELECT * FROM reservations WHERE user = '{$id}' {$status}";
    $result = mysqli_query($db, $sql);
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($data, $row);
    }

    return json_encode($data);
}
// CHANGE INSERT TO UPDATE
function quantify_order($userId, $dishId, $quantity, $reservationId)
{
    global $db;
    $_SESSION["order-msg"] = array();
    $sql = "SELECT * FROM `pre_ordered` WHERE userId = '{$userId}' AND dishId = '{$dishId}';";
    $result = mysqli_query($db, $sql);

    $row = mysqli_fetch_assoc($result);

    $newQty =  $row["quantity"] + $quantity;

    $insertSql = "UPDATE `pre_ordered` SET quantity = $newQty
					WHERE userId = '$userId' AND reservationId = '$reservationId';";
    $result = mysqli_query($db, $insertSql);

    array_push($_SESSION["order-msg"], $result ? "Added quantity to order." : "Pre-order Failed. Please reload the page and try again.");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function create_order($userId, $dishId, $quantity, $reservationId)
{
    global $db;
    $_SESSION["order-msg"] = array();
    $insertSql = "INSERT INTO `pre_ordered` (userId, dishId, reservationId, quantity) 
					VALUES ('$userId','$dishId','$reservationId', '$quantity')";

    $result = mysqli_query($db, $insertSql);

    array_push($_SESSION["order-msg"], $result ? "Pre-order success." : "Pre-order Failed. Please reload the page and try again.");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function get_pre_orders($user)
{
    global $db;
    $id = retrieve_user_id($user);

    $sql = "SELECT 
    pre_ordered.id,
    pre_ordered.quantity,
    dishes.name,
    dishes.image,
    reservations.id as 'reservationId',
    reservations.date,
    reservations.startTime,
    reservations.endTime
    FROM pre_ordered 
    INNER JOIN dishes ON pre_ordered.dishId = dishes.id 
    INNER JOIN reservations ON pre_ordered.reservationId = reservations.id 
    WHERE userId = {$id};";
    $result = mysqli_query($db, $sql);
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($data, $row);
    }

    return json_encode($data);
}

function id_exists_on_table($id, $table)
{
    global $db;
    $sql = "SELECT * FROM `{$table}` WHERE id = '{$id}';";
    $result = mysqli_query($db, $sql);
    if ($result) return true;
    else return false;
}

function cancel_reservation($id)
{
    global $db;

    $updated_at = date("Y-m-d H:i:s");
    $sql = "UPDATE reservations SET
    `status` = '3',
    `updated_at` = '{$updated_at}'
    WHERE ID = {$id}";
    $result = mysqli_query($db, $sql);
    return $result;
}


function remove_order($id)
{
    global $db;
    $sql = "DELETE FROM pre_ordered 
    WHERE ID = {$id}";
    $result = mysqli_query($db, $sql);
    return $result;
}
