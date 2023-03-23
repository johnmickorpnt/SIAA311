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

    foreach ($data as $row) {
        $startTime = date("H:i a", strtotime($row['startTime']));
        $dateToCompare = date('Y-m-d H:i:s', strtotime("{$row['date']} {$startTime}"));
        if (!is_valid($dateToCompare) && $row["status"] != 3) {
            cancel_reservation($row["id"]);
            header("Refresh:0");
        }
    }

    return json_encode($data);
}
// CHANGE INSERT TO UPDATE
function quantify_order($userId, $dishId, $quantity)
{
    global $db;
    $_SESSION["order-msg"] = array();
    $sql = "SELECT * FROM `pre_ordered` WHERE userId = '{$userId}' AND dishId = '{$dishId}';";
    $result = mysqli_query($db, $sql);

    $row = mysqli_fetch_assoc($result);

    $newQty =  $row["quantity"] + $quantity;

    $insertSql = "UPDATE `pre_ordered` SET quantity = $newQty
					WHERE userId = '$userId'
                    AND dishId = '$dishId';";
    $result = mysqli_query($db, $insertSql);

    array_push($_SESSION["order-msg"], $result ? "Added quantity to order." : "Pre-order Failed. Please reload the page and try again.");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function create_order($userId, $dishId, $quantity)
{
    global $db;
    $_SESSION["order-msg"] = array();
    $insertSql = "INSERT INTO `pre_ordered` (userId, dishId, quantity) 
					VALUES ('$userId','$dishId', '$quantity')";

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
    pre_ordered.isActive,
    dishes.name,
    dishes.image,
    dishes.price
    FROM pre_ordered 
    INNER JOIN dishes ON pre_ordered.dishId = dishes.id 
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

function updateActive($preOrderId, $userId, $val)
{
    global $db;
    $_SESSION["order-msg"] = array();
    $sql = "SELECT * FROM `pre_ordered` WHERE id = '{$preOrderId}' AND userId = '{$userId}';";
    $result = mysqli_query($db, $sql);

    $insertSql = "UPDATE `pre_ordered` SET isActive = $val
					WHERE id = '$preOrderId'
                    AND userId = '$userId';";
    $result = mysqli_query($db, $insertSql);
    return $result;
}

function get_total_payment($userId)
{
    global $db;
    $_SESSION["order-msg"] = array();
    $sql = "SELECT 
    pre_ordered.id,
    pre_ordered.quantity,
    pre_ordered.isActive,
    dishes.name,
    dishes.image,
    dishes.price
    FROM pre_ordered 
    INNER JOIN dishes ON pre_ordered.dishId = dishes.id 
    WHERE userId = {$userId};";
    $result = mysqli_query($db, $sql);

    $toBePayed = 0;
    while (($row = mysqli_fetch_assoc($result))) {
        $toBePayed += $row["isActive"] ? ($row["price"] * $row["quantity"]) / 2 : 0;
    }
    return $toBePayed;
}

function is_valid($dateTime)
{
    $tz = new DateTimeZone('Asia/Manila');
    $now = date('Y-m-d H:i:s');
    $diff = strtotime($now) - strtotime($dateTime);
    if ((int) number_format($diff / (60 * 60), 0) >= 12) return false;
    else return true;
}


function create_payment($id, $bank, $accountNumber, $amount, $date, $depositedBranch, $receipt)
{
    global $db;


    $insertSql =  "INSERT INTO `payments` (`id`, `reservationId`, `account_number`, `amount`, `bank`, `branch`, `date`, `receipt`, `created_at`, `updated_at`) 
    VALUES (NULL, '{$id}', '{$accountNumber}', '{$amount}', '{$bank}', '{$date}', '{$depositedBranch}', '{$receipt}', current_timestamp(), current_timestamp())";
    $result = mysqli_query($db, $insertSql);
    
    array_push($_SESSION["order-msg"], $result ? "Payment success" : "Pre-order Failed. Please reload the page and try again.");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    
}
