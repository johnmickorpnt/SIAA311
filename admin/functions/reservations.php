<?php
include_once("../config/Db.php");
include_once("../models/Reservation.php");

function get_all_reservations()
{
    $db = new Db();
    $db = $db->connect();
    $reservations = new Reservation($db);
    $results = $reservations->fetchAll();
    return $results;
}

function get_with_filter($values)
{
    $db = new Db();
    $db = $db->connect();
    $reservations = new Reservation($db);

    $data = isset($values["status"]) ?
        $reservations->fetch_by_status($values["status"]) : $reservations->fetchAll();

    return $data;

    // return $values;
}

function get_tables()
{
    $db = new Db();
    $db = $db->connect();
    $reservations = new Reservation($db);
    $results = $reservations->get_tables();
    return $results;
}