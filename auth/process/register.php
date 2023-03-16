<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../..//PHPMailer/src/SMTP.php';
require_once("../../db/connection.php");
session_start();
$valid = array();
$response = array();
if (isset($_POST['email'])) {
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$pass = $_POST['pass'];
	$conpass = $_POST['conpass'];
	$email = $_POST['email'];
	$number = $_POST['number'];
	$_SESSION["msg"] = array();

	if (empty($fname)) {
		$valid[0] = false;
		array_push($response, "Your First name is Required.");
	} else $valid[0] = true;

	if (empty($lname)) {
		$valid[1] = false;
		array_push($response, "Your Last name is Required.");
	} else $valid[1] = true;

	if (empty($email)) {
		$valid[2] = false;
		array_push($response, "Your Email is Required.");
	} else $valid[2] = true;

	if (empty($number)) {
		$valid[3] = false;
		array_push($response, "Your Phone Number is required.");
	} else $valid[3] = true;

	if (empty($pass)) {
		$valid[4] = false;
		array_push($response, "Password is required.");
	} else $valid[4] = true;

	if (empty($conpass)) {
		array_push($response, "Password Confirmation is required.");
		$valid[5] = false;
	} else $valid[5] = true;

	if ($pass != $conpass) {
		$valid[6] = false;
		array_push($response, "Your password and Password Confirmation does not match.");
	} else $valid[6] = true;

	if (strlen($number) != 11) {
		$valid[7] = false;
		array_push($response, "Phone number is invalid. Please make sure your number has 11 digits.");
	} else $valid[7] = true;

	$check_query = mysqli_query($db, "SELECT * FROM users where email ='$email'");
	$rowCount = mysqli_num_rows($check_query);


	if ($rowCount > 0) {
		array_push($response, "A User has already registered with your email.");
		$valid[8] = false;
	}

	// Check if the valid variable is true or false;
	if (in_array(false, $valid)) {
		// header('Location: ' . $_SERVER['HTTP_REFERER']);
		array_push($response, ["status" => false]);
		http_response_code(422);
		echo json_encode($response);
	} else {
		$newPass = password_hash($pass, PASSWORD_DEFAULT);
		$query = "insert into users (firstname, lastname, email, password, number) 
					values ('$fname', '$lname','$email', '$newPass','$number')";
		$result = mysqli_query($db, $query);

		if ($result) {

			$mail = new PHPMailer(true);
			$mail->isHTML(true);
			$mail->isSMTP();
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;
			$mail->Username = 'jacobmartindummy@gmail.com';
			$mail->Password = 'idcrrkgigtumrgut';
			$mail->Port = 587;

			$mail->setFrom('hubzbistro.dummy@gmail.com');
			$mail->addAddress($email);
			$mail->isHTML(true);
			$mail->Subject = "Hubz Bistro Account Creation";
			

			$mail->Body = <<<MSG
				<h1>Hello and Welcome to Hubzbistro.</h1>
				<h3>
					You are now able to create a reservation and pre-order some of our finest dishes!
				</h3>
			MSG;
			try {
				$mail->send();
				echo json_encode(["response" => "Registration Successful.", ["status" => true]]);
			} catch (Exception $e) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
		}
	}
}
