<?php
session_start();

include("functions/user.php");
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
                <th>Action</th>
                <th></th>
            </thead>
            <tbody>
                <?php
                if (isset($preOrders)) {
                    foreach ($preOrders as $key => $val) {

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
                let conf = false;
                let id = btn.getAttribute("data-id");
                let tbl = btn.getAttribute("data-table");
                let fd = new FormData();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You can still add this dish later in the menu.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fd.append("id", id);
                        fd.append("table", tbl);
                        fetch("apis/remove-order.php", {
                                method: "POST",
                                body: fd
                            })
                            .then((response) => response.json())
                            .then((response) => {
                                Swal.fire('Saved!', '', 'success').then(() => window.location.reload())
                                // alert(response.status ? response.msg : response.errors);
                                // if (response.status)
                            })
                    }
                })

            })
        });
    </script>
</body>