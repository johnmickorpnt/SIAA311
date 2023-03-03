<?php
include_once("../../../config/Db.php");
include_once("../../../models/Dish.php");

header('Content-Type: application/json; charset=utf-8');
// parse_str(file_get_contents('php://input'), $_PATCH);
$valid = array();
$errors = array();
$response = array();
date_default_timezone_set("Asia/Manila");

$imageProcess = 0;
clearstatcache();
// If image exists

if (isset($_POST["id"])) {
    $hasImg = filesize($_FILES["image"]["tmp_name"]);
    $db = new Db();
    $db = $db->connect();

    $dishObject = new Dish($db);
    $dishObject->fetch($_POST["id"]);

    $dishObject->set_name(isset($_POST["name"]) ? $_POST["name"] : $dishObject->get_name());
    $dishObject->set_price(isset($_POST["price"]) ? $_POST["price"] : $dishObject->get_price());
    $dishObject->set_category(isset($_POST["category"]) ? $_POST["category"] : $dishObject->get_category());
    $dishObject->set_description(isset($_POST["description"]) ? $_POST["description"] : $dishObject->get_description());
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
    }
    $results = $dishObject->save();

    if($results){
        http_response_code(200);
        echo json_encode(["status" => 1, "msg" => "Updating data Successful."]);
    }
    else{
        http_response_code(422);
        echo json_encode(["status" => 0, "msg" => "Could not update data. Please try again later."]);
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
