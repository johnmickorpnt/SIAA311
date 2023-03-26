<?php
session_start();
include_once("../functions/global.php");
include_once("../functions/pre-ordered.php");

$data = get_all_preorders();
$users = get_all_users(1, 25);
$reservations = get_all_reservations();
$dishes = get_all_dishes(1, 25);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("../../components/links.php"); ?>
    <link rel="stylesheet" href="../assets/styles.css">
    <title>Hubz Bistro Users</title>
</head>

<body>
    <?php
    include("../components/navbar.php");
    ?>
    <main class="container">
        <h1 style="text-align: center;">Manage Pre-orders</h1>
        <!-- <div class="search-box">
            <label for="">Search:</label>
            <input type="text">
            <button class="btn btn-search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div> -->
        <div>
            <button class="btn btn-add" id="btn-add">
                <i class="fa-solid fa-plus"></i>
                Add New Pre-order
            </button>
        </div>
        <table style="width:100%;">
            <thead>
                <th>ID</th>
                <th>User ID</th>
                <th>Dish ID</th>
                <th>Quantity</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th width="1rem">Actions</th>
            </thead>
            <tbody>
                <?php
                if (!empty($data)) {
                    foreach ($data as $key => $val) {
                        echo <<<CONTENT
                        <tr 
                        data-id="{$val["id"]}" 
                        
                        data-created-at="{$val["created_at"]}" 
                        data-updated-at="{$val["updated_at"]}">
                            <td>
                                {$val["id"]}
                            </td>
                            <td>
                                {$val["userId"]}
                            </td>
                            <td>
                                {$val["dishId"]}
                            </td>
                            <td>
                                {$val["quantity"]}
                            </td>
                            <td>
                                {$val["created_at"]}
                            </td>
                            <td class="">
                                
                            </td>
                            <td class="actions-col">
                                <button class="btn btn-view" data-id="{$val["id"]}" data-tbl="pre_ordered">
                                    <i class="fa-sharp fa-solid fa-list"></i>
                                    <span>View</span>
                                </button>
                                <button class="btn btn-edit" data-id="{$val["id"]}" data-tbl="pre_ordered">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </button>
                                <button class="btn btn-delete" data-id="{$val["id"]}" data-tbl="pre_ordered">
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
                        <td colspan=8>
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
            <div class="select-form">
                <label>User ID: </label>
                <select name="userId" id="userId">
                    <!-- <option value=""></option> -->
                    <?php
                        foreach($users as $key => $val){
                            echo <<<CONTENT
                            <option value="{$val['id']}">
                                {$val['id']}
                            </option>
                            CONTENT;
                        }
                    ?>
                </select>
            </div>
            <div class="form-row">
                <div class="select-form">
                    <label>Dish ID: </label>
                    <select name="dishId" id="dishId">
                        <?php
                            foreach($dishes as $key => $val){
                                echo <<<CONTENT
                                <option value="{$val['id']}">
                                    {$val['id']}
                                </option>
                                CONTENT;
                            }
                        ?>
                    </select>
                </div>

            </div>
            <div class="txt_field">
                <input type="text" name="quantity" id="quantity" required>
                <span></span>
                <label>Order Quantity: </label>
            </div>
            <input type="hidden" id="table-model" name="table-model" value="pre_ordered">
            <input type="submit" value="Save Changes" name="submit" id="submit-btn">
            <button type="button" name="btn-cancel" class="btn-cancel" id="btn-cancel">Cancel Changes </button>
        </form>
        <script src="../assets/scripts.js"></script>
    </dialog>
</body>

</html>