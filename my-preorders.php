<?php
session_start();

include("functions/user.php");
$reservations = json_decode(get_reservations($_SESSION["user"], null));
$preOrders = json_decode(get_pre_orders($_SESSION["user"]));
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
    <title>My pre-orders</title>
</head>

<body>
    <?php
    include("components/navbar.php");
    ?>
    <h1>My Pre-orders</h1>
    <main class="container">
        <table>
            <thead>
                <th>Name</th>
                <th>Quantity</th>
                <th>For Reservation Date</th>
                <th></th>
            </thead>
            <tbody>
                <?php
                if (isset($preOrders)) {
                    foreach ($preOrders as $key => $val) {
                        $date = date("M d y (l)", strtotime($val->date));
                        $startTime = date("H:i a", strtotime($val->startTime));
                        echo <<<CONTENT
                    <tr>
                        <td style="display:flex; flex-direction:column; align-items:center">
                            <image src="{$val->image}" width="150" height="100" style="border-radius:5px"/>
                            {$val->name}
                        </td>
                        <td>
                            {$val->quantity} Order/s
                        </td>
                        <td>
                            {$date}
                            <br>@ {$startTime}
                        </td>
                        <td>
                            <button class="btn-remove" data-id="$val->id" data-table="pre_ordered">
                                <i class="fa-solid fa-x"></i>
                            </button>
                        </td>
                    </tr>
                    CONTENT;
                    }
                } else {
                    echo <<<CONTENT
                    <tr>
                        <td>
                            No Pre-orders made. Pre-order <a href="menu-categories.php">now!</a>
                        </td>
                    </tr>
                    CONTENT;
                }
                ?>
            </tbody>
        </table>
    </main>
    <?php
    include("components/footer.php");
    ?>
    <script>
        let cancelBtn = document.querySelectorAll(".btn-remove");
        cancelBtn.forEach(btn => {
            btn.addEventListener("click", () => {
                let conf = confirm("Remove this pre-order?");
                if (!conf) return false;

                let id = btn.getAttribute("data-id");
                let tbl = btn.getAttribute("data-table");
                let fd = new FormData();
                fd.append("id", id);
                fd.append("table", tbl);
                fetch("apis/remove-order.php", {
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