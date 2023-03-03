<?php
$fn = 'fn';
function assets($link)
{
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $file = str_contains($url, "SIAA311") ?
        substr($url, strpos($url, "SIAA311") + 7) : substr($url, strpos($url, "/"));
    return strrpos($file, "/") > 0 ? "../$link" : $link;
}

/**
 * @param link - Accepts a string to find the file.
 */
function route($link)
{
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $file = str_contains($url, "SIAA311") ?
        substr($url, strpos($url, "SIAA311") + 7) : substr($url, strpos($url, "/"));
    return strrpos($file, "/") > 0 ? "../$link" : $link;
}