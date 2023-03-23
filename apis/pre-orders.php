<?php
function get_orders()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once "db/connection.php";
    include("functions/user.php");
    if (!isset($_SESSION["user"])) {
        http_response_code(400);
        return "Please make sure that you're logged in before making a reservations.";
    }


    $sql = "SELECT id FROM users WHERE email = '{$_SESSION['user']}';";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);

    if (empty($row)) {
        array_push($_SESSION["msg"], "User Email does not exist. Please go to our registration page before making a reservation.");
        return header('Location: ' . '../views/auth/login.php');
    }

    $userId = $row["id"];
    $sql = "SELECT * FROM `pre_ordered` WHERE userId = '$userId'";


    $pre_ordered = [];
    $result = mysqli_query($db, $sql);
    $rowCount = mysqli_num_rows($result);

    while ($row = $result->fetch_assoc()) {
        array_push($pre_ordered, $row);
    }


    // // IF ROW EXISTS, Return back to page and notify user to add a dish
    if ($rowCount <= 0) {
        // quantify_order($userId, $dishId, $qty, $reservation);
        return json_encode(["status" => 0, "body" => "No Dish available. Please make sure to have a selected dish."]);
    }

    // // Otherwise compute total and return with dishes that were added.
    else {
        $sql = "SELECT dishes.id, dishes.name, dishes.image, dishes.price, pre_ordered.id, pre_ordered.quantity, pre_ordered.isActive 
        FROM dishes INNER JOIN pre_ordered  ON dishes.id = pre_ordered.dishId WHERE userId = {$userId};";
        $items = [];
        $result = mysqli_query($db, $sql);
        $rowCount = mysqli_num_rows($result);

        while ($row = $result->fetch_assoc()) {
            array_push($items, $row);
        }

        return json_encode(["status" => 1, "body" => $items]);
    }
}
