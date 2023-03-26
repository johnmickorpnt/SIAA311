<?php
include("functions/user.php");
session_start();
if (!isset($_SESSION["user"])) header("refresh:0;url=auth/customerlogin.php");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/reservation.css">
    <?php
    include("components/links.php");
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Hub'z Bistro Reservation</title>
    <style>
        body {
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            width: 100vw;
        }
    </style>
</head>

<body>
    <main class="container" style="padding:1%; border-radius:15px; background-color: white; height:40%; width: 30%; text-align:center; position:relative; display: flex; flex-direction: column;">
        <div style="background-color: #30ff29; border-radius: 50%; padding:1rem; font-size: larger; width:25%; text-align: center; position:absolute; top:-2.5rem; margin:auto; right:0; left:0">
            <i class="fa-solid fa-check fa-3x" style="color:white"></i>
        </div>
        <h1 style="margin-top: 2.5rem;">Payment Success!</h1>
        <p style="margin-top: 2.5rem;">
            Please make sure to attend at <b id="date"> <span id="time">@ </span> </b>
            and pay the remaining 50% of the fee. 
            <br>
            Thanks and enjoy your dine!
        </p>
        <a class="btn" href="reservation.php" style="padding:1rem; background-color: red; margin-top:auto !important; font-size: small;">
            Book Another Reservation
        </a>
        <a class="btn" href="index.php" style="padding:1rem; background-color: #bdbdbd; color:black; font-size: small; margin-top:.25rem !important">
            Go Home
        </a>
    </main>
</body>