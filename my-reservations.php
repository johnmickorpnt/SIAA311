<?php
session_start();

include("functions/user.php");

if (!isset($_SESSION["user"])) header("Location: index.php");
$reservations = json_decode(get_reservations($_SESSION["user"], null));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <?php
    include("components/links.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>My reservations</title>
</head>

<body>
    <?php
    include("components/navbar.php");
    ?>
    <main class="container">
        <h1>My Reservations</h1>
        <div style="padding:1rem">
            <ul style="font-size: small; list-style: none; font-weight:bold;padding: 1rem; border-radius: 15px;border: solid rgba(0,0,255,0.5) .1rem; margin-bottom:0.25rem;">
                <li>
                    <h3>REMINDERS</h3>
                </li>
                <li style="display:flex; align-items:center; gap:1rem; margin:0.5rem">
                    <i class="fa-solid fa-circle-exclamation" style="font-size: large;"></i>
                    Make sure to make your payments at least 12 hours before.
                </li>
                <li style="display:flex; align-items:center; gap:1rem; margin:0.5rem">
                    <i class="fa-solid fa-circle-xmark" style="font-size: large;"></i>
                    <b> Approved reservations without payment before 12 hours of the reservation date will be automatically cancelled. </b>
                </li>
            </ul>
        </div>
        <table>
            <thead>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
                <th>Action/Remarks</th>
            </thead>
            <tbody>
                <?php
                foreach ($reservations as $key => $val) {
                    $date = date("F d, Y (l)", strtotime($val->date));
                    $startTime = date("H:i a", strtotime($val->startTime));
                    $endTime = date("H:i a", strtotime($val->endTime));
                    $status = $val->status == "0" ? "Waiting for approval" : ($val->status == "1" ? "Approved" : ($val->status == "3" ? "Cancelled" : ($val->status == "4" ? "Waiting for Appointment" : "Absent")));
                    $dateToCompare = date('Y-m-d H:i:s', strtotime("{$val->date} {$startTime}"));
                    echo <<<CONTENT
                    <tr>
                        <td>
                            {$date}
                        </td>
                        <td>
                            {$startTime}
                        </td>
                        <td>
                            {$endTime}
                        </td>
                        <td>
                            {$status}
                        </td>
                    CONTENT;
                    if ($val->status == "0") {
                        echo <<<CONTENT
                            <td>
                                <button class="btn-cancel" data-id="$val->id" data-table="pre_ordered">
                                    Cancel
                                </button>
                            </td>
                        </tr>
                        CONTENT;
                    } else if ($val->status == "1") {
                        echo <<<CONTENT
                                <td>
                                    <a href="payment.php?id=$val->id">
                                        Proceed to payment
                                    </a>
                                </td>
                            </tr>
                        CONTENT;
                    } else echo "<td> None </td> </tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <?php
    include("components/footer.php");
    ?>
    <script>
        let cancelBtn = document.querySelectorAll(".btn-cancel");
        cancelBtn.forEach(btn => {
            btn.addEventListener("click", () => {

                let id = btn.getAttribute("data-id");
                let tbl = btn.getAttribute("data-table");
                let fd = new FormData();
                Swal.fire({
                    title: 'Are you sure you want to cancel this reservation?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: `No`,
                    confirmButtonColor: 'red',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        fd.append("id", id);
                        fd.append("table", tbl);
                        fetch("apis/cancel.php", {
                                method: "POST",
                                body: fd
                            })
                            .then((response) => response.json())
                            .then((response) => {
                                Swal.fire('Saved!', '', 'success').then(() => {
                                    window.location.reload();
                                });
                            })
                    }
                })
            })
        });
    </script>
</body>