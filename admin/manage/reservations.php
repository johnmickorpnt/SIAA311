<?php
session_start();

include_once("../functions/global.php");
include_once("../functions/reservations.php");
include_once("../functions/user.php");


$data = sizeof($_GET) <= 0 ? get_all_reservations() : get_with_filter($_GET);
$tbls = get_tables();
$users = get_all_users(1, 25);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("../../components/links.php"); ?>
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Hubz Bistro Reservations</title>
    <style>
        div.flatpickr-calendar {
            z-index: 999999999;
        }
    </style>
</head>

<body>
    <?php
    include("../components/navbar.php");
    ?>
    <main class="container">
        <h1 style="text-align: center;">Manage Reservations</h1>
        <!-- <div class="search-box">
            <label for="">Search:</label>
            <input type="text">
            <button class="btn btn-search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div> -->
        <div style="display: flex; gap: 0.25rem">
            <button class="btn btn-add" id="btn-add">
                <i class="fa-solid fa-plus"></i>
                Add New Reservation
            </button>
            <button class="btn btn-filter">
                <i class="fa-solid fa-eye"></i>
                View All Reservations
            </button>
            <button class="btn btn-filter">
                <i class="fa-sharp fa-solid fa-hourglass-start"></i>
                View Pending Reservations
            </button>
        </div>
        <table style="width:100%;">
            <thead>
                <th>ID</th>
                <th>Date</th>
                <th>Time Start</th>
                <th>Time End</th>
                <th>Status</th>
                <th>Status Actions</th>
                <th width="1rem">Actions</th>
            </thead>
            <tbody>
                <!-- <button class="btn btn-disapprove" data-id="{$val[" id"]}" data-tbl="reservations">
                    <i class="fa-solid fa-x"></i>
                    <span>Disapprove</span>
                </button> -->
                <?php
                if (!empty($data)) {
                    foreach ($data as $key => $val) {
                        $status = $val["status"] == 0 ? "Pending" : ($val["status"] == 1 ? "Approved" : ($val["status"] == 2 ? "Done" : "Cancelled"));
                        $statusCont = $val["status"] == "0" ? <<<CONTENT
                        <button class="btn btn-approve" data-id="{$val["id"]}" data-tbl="reservations">
                            <i class="fa-solid fa-check"></i>
                            <span>Approve</span>
                        </button>
                        
                        CONTENT : ($val["status"] == "1" ? <<<CONTENT
                        <button class="btn btn-done" data-id="{$val["id"]}" data-tbl="reservations">
                            <i class="fa-solid fa-check"></i>
                            <span>Mark as Done</span>
                        </button>    
                        <button class="btn btn-cancel-reservation" data-id="{$val["id"]}" data-tbl="reservations">
                            <i class="fa-solid fa-x"></i>
                            <span>Cancel</span>
                        </button>
                        CONTENT : ($val["status"] == "2" ? "<span>Reservation is done, no actions needed.</span>"
                            : <<<CONTENT
                            <button class="btn btn-approve" data-id="{$val["id"]}" data-tbl="reservations">
                                <i class="fa-solid fa-check"></i>
                                <span>Re-approve</span>
                            </button>
                        CONTENT));
                        echo <<<CONTENT
                        <tr 
                        data-id="{$val["id"]}" 
                        data-created-at="{$val["created_at"]}" 
                        data-updated-at="{$val["updated_at"]}">
                            <td>
                                {$val["id"]}
                            </td>
                            <td>
                                {$val["date"]}
                            </td>
                            <td>
                                {$val["startTime"]}
                            </td>
                            <td>
                                {$val["endTime"]}
                            </td>
                            <td>
                                {$status}
                            </td>
                            <td>
                                <div style="display:flex; flex-direction:column; gap:0.5rem">
                                    {$statusCont}
                                </div>
                            </td>
                            <td class="actions-col">
                                <button class="btn btn-view" data-id="{$val["id"]}" data-tbl="reservations">
                                    <i class="fa-sharp fa-solid fa-list"></i>
                                    <span>View</span>
                                </button>
                                <button class="btn btn-edit" data-id="{$val["id"]}" data-tbl="reservations">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </button>
                                <button class="btn btn-delete" data-id="{$val["id"]}" data-tbl="reservations">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>Delete</span>
                                </button>
                            </td>
                        </tr>
                    CONTENT;
                    }
                } else {
                    echo <<<CONTENT
                    <tr>
                        <td colspan=7>
                            This table is empty.
                        </td>
                    </tr>
                    CONTENT;
                }
                ?>
            </tbody>
        </table>
    </main>
    <dialog class="form-modal">
        <h1 class="form-header">Reservation</h1>
        <form id="main-form">
            <div class="txt_field" id="id-input">
                <input type="number" name="id" id="id" value="1" readonly>
                <span></span>
                <label>ID: </label>
            </div>
            <div class="txt_field date-input">
                <input type="date" name="date" id="date" required>
                <span></span>
                <label>Date: </label>
            </div>
            <div class="form-row">
                <div class="txt_field date-input">
                    <input type="time" name="startTime" id="startTime" required>
                    <span></span>
                    <label>Start Time: </label>
                </div>
                <div class="txt_field date-input">
                    <input type="time" name="endTime" id="endTime" required disabled>
                    <span></span>
                    <label>End Time: </label>
                </div>
            </div>
            <div class="select-form">
                <label>User ID: </label>
                <select name="user" id="user">
                    <?php
                    foreach ($users as $key => $val) {
                        echo <<<CONTENT
                            <option value="{$val['id']}">
                                {$val['firstname']} {$val['lastname']}
                            </option>
                            CONTENT;
                    }
                    ?>

                </select>
                <!-- users -->
            </div>
            <div>
                <label>Table ID: </label>
                <select name="tableId" id="tableId" style="width: 100%; height:50%">
                    <?php
                    foreach ($tbls as $key => $val) {
                        echo <<<CONTENT
                                <option value="{$val["id"]}" style="text-transform: capitalize">
                                    {$val["id"]}
                                </option>
                            CONTENT;
                    }
                    ?>
                </select>
            </div>
            <div style="margin-bottom: 1rem;">
                <label>Status</label>
                <select name="status" id="status" style="width: 100%; height:50%">
                    <option value="0">Pending</option>
                    <option value="1">Approved</option>
                    <option value="2">Done</option>
                    <option value="3">Cancelled</option>
                    <!-- <option value="4">Done</option> -->
                </select>
            </div>

            <input type="hidden" id="table-model" name="table-model" value="reservations">
            <input type="submit" value="Save Changes" name="submit" id="submit-btn">
            <button type="button" name="btn-cancel" class="btn-cancel" id="btn-cancel">Cancel Changes </button>
        </form>
    </dialog>
    <dialog id="loading" class="modal">
        <h1>Sending an approval email...</h1>
    </dialog>
    <script src="../assets/scripts.js"></script>
    <script>
        flatpickr("input[type=date]", {
            minDate: new Date().fp_incr(1),
            defaultDate: new Date().fp_incr(1),
            static: true
        });

        flatpickr("input[type=time]", {
            enableTime: true,
            noCalendar: true,
            defaultDate: "09:00",
            dateFormat: "H:i",
            minTime: "09:00",
            maxTime: "21:00",
            static: true
        });

        window.addEventListener("load", () => {
            let cancelBtn = document.querySelectorAll(".btn-cancel-reservation");
            let approveBtn = document.querySelectorAll(".btn-approve");
            let doneBtn = document.querySelectorAll(".btn-done");
            doneBtn.forEach(btn => {
                btn.addEventListener("click", () => {
                    let conf = confirm("Are you sure that this reservation is DONE?");
                    let id = btn.getAttribute("data-id");
                    if (!conf) return false;
                    fetch("../functions/api/reservations/done.php", {
                            method: "POST",
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "id": id,
                            })
                        })
                        .then((response) => response.json())
                        .then((response) => {
                            alert(response.msg);
                            window.location.reload();
                        });
                });
            });

            approveBtn.forEach(btn => {
                let loadingModal = document.getElementById("loading");
                btn.addEventListener("click", () => {
                    let conf = confirm("Are you sure to approve this reservation?");
                    let id = btn.getAttribute("data-id");
                    if (!conf) return false;
                    loading.showModal();

                    fetch("../functions/api/reservations/approve.php", {
                            method: "POST",
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "id": id,
                            })
                        })
                        .then((response) => response.json())
                        .then((response) => {
                            loading.close();
                            alert(response.msg);
                            window.location.reload();
                        });
                });
            });
            cancelBtn.forEach(btn => {
                btn.addEventListener("click", () => {
                    let conf = confirm("Are you sure to cancel this reservation?");
                    let id = btn.getAttribute("data-id");
                    if (!conf) return false;
                    fetch("../functions/api/reservations/cancel.php", {
                            method: "POST",
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "id": id,
                            })
                        })
                        .then((response) => response.json())
                        .then((response) => {
                            alert(response.msg);
                            window.location.reload();
                        });
                });
            });
        });
    </script>
</body>

</html>