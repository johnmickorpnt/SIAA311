<?php
include_once("../config/Db.php");
include_once("../models/PreOrder.php");
include_once("../models/User.php");
include_once("../models/Reservation.php");
include_once("../models/Dish.php");

function get_all_preorders(){
    $db = new Db();
    $db = $db->connect();
    $preOrders = new PreOrder($db);
    $results = $preOrders->fetchAll();
    return $results;
}

function get_all_users($page, $limit){
    $db = new Db();
    $db = $db->connect();
    $users = new User($db);
    $results = $users->fetchAll($limit);
    return $results;
}

function get_all_reservations()
{
    $db = new Db();
    $db = $db->connect();
    $reservations = new Reservation($db);
    $results = $reservations->fetchAll();
    return $results;
}

function get_all_dishes($page, $limit){
    $db = new Db();
    $db = $db->connect();
    $dish = new Dish($db);
    $results = $dish->fetchAll($limit);
    return $results;
}

