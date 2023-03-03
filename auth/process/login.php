<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once "../../db/connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../..//PHPMailer/src/SMTP.php';
$valid = array();
$_SESSION["msg"] = array();
$response = array();

if (isset($_POST['email']) && isset($_POST['pass'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $sql = "Select * from users where email = '$email'";

    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);

    if (empty($row)) {
        http_response_code(401);
        $response = json_encode(["response" => "User Email does not exist. Register below."]);
        echo $response;
        return $response;
    }

    $hashed_pass = $row["password"];

    if (password_verify($pass, $row["password"])) {
        $response = json_encode(["response" => "Login Successful"]);
        $_SESSION["user"] = $row["email"];
    } else {
        http_response_code(401);
        $response = json_encode(["response" => "Invalid Email/Password."]);
    }

    echo $response;

    
}
