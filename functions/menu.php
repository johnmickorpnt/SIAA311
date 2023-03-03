<?php
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$file = str_contains($url, "SIAA311") ?
    substr($url, strpos($url, "SIAA311") + 7) : substr($url, strpos($url, "/"));
require(strrpos($file, "/") > 0 ? "../db/connection.php" : "db/connection.php");

function get_menu_item($id)
{

    global $db;

    $sql = "SELECT * FROM dishes WHERE id = '{$id}';";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);

    return json_encode($row);
}

function dish_exists($id)
{
    global $db;

    $sql = "SELECT * FROM dishes WHERE id = '{$id}';";
    $result = mysqli_query($db, $sql);
    $rowCount = mysqli_num_rows($result);

    return $rowCount > 0 ? true : false;
}

function get_dishes($category)
{
    global $db;

    $data = array();
    $sql = isset($category) ? "SELECT * FROM dishes WHERE category = '{$category}';" :
        "SELECT * FROM dishes;";

    $result = mysqli_query($db, $sql);
    while ($row = mysqli_fetch_object($result)) {
        array_push($data, $row);
    }
    return $data;
}
