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
        <table>
            <thead>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                foreach ($reservations as $key => $val) {
                    $date = date("F d, Y (l)", strtotime($val->date));
                    $startTime = date("H:i a", strtotime($val->startTime));
                    $endTime = date("H:i a", strtotime($val->endTime));
                    $status = $val->status == "0" ? "Waiting for approval" : ($val->status == "1" ? "Approved" : ($val->status == "3" ? "Cancelled" : "Absent"));
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
                let conf = confirm("Cancel this reservation?");
                if (!conf) return false;

                let id = btn.getAttribute("data-id");
                let tbl = btn.getAttribute("data-table");
                let fd = new FormData();
                fd.append("id", id);
                fd.append("table", tbl);
                fetch("apis/cancel.php", {
                        method: "POST",
                        body: fd
                    })
                    .then((response) => response.json())
                    .then((response) => {
                        alert(response.status ? response.msg : response.errors);
                        if (response.status)
                            window.location.reload();
                    })
            })
        });
    </script>
</body>