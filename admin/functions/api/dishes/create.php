<?php
include_once("../../../config/Db.php");
include_once("../../../models/Dish.php");

header('Content-Type: application/json; charset=utf-8');
$valid = array();
$errors = array();
$response = array();
date_default_timezone_set("Asia/Manila");

$imageProcess = 0;
clearstatcache();

$hasImg = filesize($_FILES["image"]["tmp_name"]);
$db = new Db();
$db = $db->connect();

$dishObject = new Dish($db);

$dishObject->set_name($_POST["name"]);
$dishObject->set_price($_POST["price"]);
$dishObject->set_category($_POST["category"]);
$dishObject->set_description($_POST["description"]);
if ($hasImg) {
    $new_width = 350;
    $new_height = 250;
    $fileName = $_FILES['image']['tmp_name'];
    $sourceProperties = getimagesize($fileName);
    $resizeFileName = time();
    $uploadPath = "../../../../assets/imgs/";
    $fileExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $uploadImageType = $sourceProperties[2];
    $sourceImageWidth = $sourceProperties[0];
    $sourceImageHeight = $sourceProperties[1];

    switch ($uploadImageType) {
        case IMAGETYPE_JPEG:
            $resourceType = imagecreatefromjpeg($fileName);
            $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight);
            imagejpeg($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
            break;

        case IMAGETYPE_PNG:
            $resourceType = imagecreatefrompng($fileName);
            $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight);
            imagepng($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
            break;

        default:
            echo "ERROR";
            break;
    }
    $dishObject->set_image("assets/imgs/thump_" . $resizeFileName . '.' . $fileExt);
    $results = $dishObject->save();

    if ($results) {
        http_response_code(200);
        echo json_encode(["status" => 1, "msg" => "Creating data Successful."]);
    } else {
        http_response_code(422);
        echo json_encode(["status" => 0, "msg" => "Could not insert data. Please try again later."]);
    }
}

function resizeImage($resourceType, $image_width, $image_height)
{
    $resizeWidth = 350;
    $resizeHeight = 250;
    $imageLayer = imagecreatetruecolor($resizeWidth, $resizeHeight);
    imagecopyresampled($imageLayer, $resourceType, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $image_width, $image_height);
    return $imageLayer;
}
