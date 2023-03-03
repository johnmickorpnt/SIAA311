<?php
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
</head>

<body>
    <?php
    include("components/navbar.php");
    ?>
    <main class="container">
        <h1>Reservation Payment</h1>
        Bank Details

        
        <!-- Show the menu -->
        <!-- Time and date -->
        <!-- Price -->
    </main>
</body>

</html>