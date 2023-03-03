<?php
include_once("../config/Db.php");
include_once("../models/Dish.php");

function get_all_dishes($page, $limit){
    $db = new Db();
    $db = $db->connect();
    $users = new Dish($db);
    $results = $users->fetchAll($limit);
    return $results;
}

function get_dish_categories(){
    $db = new Db();
    $db = $db->connect();
    $users = new Dish($db);
    $results = $users->fetchCategories();
    return $results;
}
?>