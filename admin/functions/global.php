<?php
is_logged_in();

function is_logged_in()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION["admin"])) {
        return header("Location: " . "../auth/login.php");
    } else return true;
}

function assets($link)
{
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $file = str_contains($url, "SIAA311") ?
        substr($url, strpos($url, "SIAA311") + 7) : substr($url, strpos($url, "/"));
    return strrpos($file, "/") > 0 ? "../$link" : $link;
}
