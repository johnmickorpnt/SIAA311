<?php
include_once("../config/Db.php");
include_once("../models/User.php");

function get_all_users($page, $limit){
    $db = new Db();
    $db = $db->connect();
    $users = new User($db);
    $results = $users->fetchAll($limit);
    return $results;
}
?>