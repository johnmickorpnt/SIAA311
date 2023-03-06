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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Hub'z Bistro Reservation</title>
</head>

<body>
    <?php
    include("components/navbar.php");
    ?>
    <div class="container-sm" style="padding: 1.25rem">
        <h1>Book your reservation</h1>
        <form id="form-reservation-finder">
            <div class="inline-form-group">
                <label for="date" style="font-weight: bold;">Please select the date of your preservation <span class="important-marker">*</span>:</label>
                <input type="date" class="form-input" id="date" name="date" min="<?= date('Y-m-d', strtotime("+1 day")); ?>">
            </div>
            <div class="inline-form-group">
                <label for="birthday" style="font-weight: bold;">Please select your preffered time of reservation: <span class="important-marker">*</span></label>
                <input type="time" id="time" name="time" class="form-input" required>
            </div>
        </form>
    </div>

    <main class="container" id="main-container">
        <!-- WHERE THE TABLE MAPPING WILL BE RENDERED -->
    </main>

    <dialog class="modal" id="loading-modal">
        <object data="<?php echo assets('/assets/svgs/loading.svg'); ?>" height="50%"></object>
        <h1>Loading...</h1>
    </dialog>

    <dialog class="modal" id="msg-modal">
        <span class="close-modal" onclick="closeMsg();">x</span>
        <img src="<?php echo assets('assets/gifs/done.gif') ?>" height="50%" width="60%" alt="Booking Successful.">
        <h3 id="msg">
        </h3>
    </dialog>

    <dialog class="modal" id="confirm-modal">
        <div style="padding: 1rem;">
            <p id="conf-msg">
                Are you sure to reserve <br>
                TABLE <span id="id-span"></span> <br>
                on <span id="date-span"></span> <br>
                @ <span id="time-span"></span>?
            </p>
            <div class="btn-group">
                <button class="btn cancel" id="cancel-btn">
                    CANCEL
                </button>
                <button class="btn confirm" id="confirm-btn">
                    OK
                </button>
            </div>
        </div>
    </dialog>

    <?php
    include("components/footer.php");
    ?>
    <script src="assets/js/reservation.js"></script>
    <script src="assets/js/global.js"></script>
</body>
</html>