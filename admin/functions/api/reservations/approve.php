<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once("../../../config/Db.php");
include_once("../../../models/Reservation.php");


require '../../../../PHPMailer/src/Exception.php';
require '../../../../PHPMailer/src/PHPMailer.php';
require '../../../../PHPMailer/src/SMTP.php';

header('Content-Type: application/json; charset=utf-8');
$valid = array();
$errors = array();
$response = array();
date_default_timezone_set("Asia/Manila");

$_POST = json_decode(file_get_contents("php://input"), true);
if (isset($_POST["id"])) {
    $db = new Db();
    $db = $db->connect();

    $reservationObject = new Reservation($db);
    if (!$reservationObject->fetch($_POST["id"])) {
        return json_encode(["errors" => "ID not found."]);
    }

    $reservationObject->fetch($_POST["id"]);
    $reservationObject->set_status('1');
    $user = $reservationObject->fetch_user();
    if (!$reservationObject->is_available()) {
        echo json_encode(["status" => false, "errors" => "Date and Time/Table not available."]);
        return false;
    }

    $result = $reservationObject->save($db);
    if (!$result) {
        echo json_encode(["status" => false, "errors" => "Updating data failed. Please try again later."]);
        return false;
    }
    $mail = new PHPMailer(true);
    $mail->isHTML(true);
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = 'hh.events.bistro.antipolo@gmail.com';
    $mail->Password = 'qcqdnvelnzmadchi';
    $mail->Port = 587;

    $mail->setFrom('hh.events.bistro.antipolo@gmail.com');
    $mail->addAddress($user["email"]);
    $mail->isHTML(true);
    $mail->Subject = "Hubz Bistro Reservation";
    $formattedQt = date("H:i a", strtotime($reservationObject->get_startTime()));
    $formattedEqt = date("H:i a", strtotime($reservationObject->get_endTime()));

    $mail->Body = <<<MESSAGE
        <h1>Reservation has been successfully made. Please wait for our approval.</h1>
        <table>
            <tbody>
                <tr>
                    <td>
                        <h3>
                            Time of Appointment: 
                        </h3>
                    </td>
                    <td>
                        {$formattedQt} to {$formattedEqt}
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>
                            Date of Appointment: 
                        </h3>
                    </td>
                    <td>
                        {$reservationObject->get_date()}
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>
                            Table Number.:
                        </h3>
                    </td>
                    <td>
                        {$reservationObject->get_tblId()}
                    </td>
                </tr>
            </tbody>
        </table>
    MESSAGE;
    try {
        $mail->send();
        echo json_encode(["status" => true, "msg" => "Reservation Approved."]);
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
