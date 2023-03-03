<?php
session_start();
include_once("../functions/global.php");
include_once("../functions/user.php");
$data = get_all_users(1, 25);

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
        <h1 style="text-align: center;">Manage Users</h1>
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
                Add New User
            </button>
        </div>
        <table style="width:100%;">
            <thead>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Created at</th>
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
                            data-fname="{$val["firstname"]}" 
                            data-lname="{$val["lastname"]}" 
                            data-email="{$val["email"]}" 
                            data-pass="{$val["password"]}" 
                            data-number="{$val["number"]}"
                            data-created-at="{$val["created_at"]}" 
                            data-updated-at="{$val["updated_at"]}">
                                <td>
                                    {$val["id"]}
                                </td>
                                <td>
                                    {$val["firstname"]}
                                </td>
                                <td>
                                    {$val["lastname"]}
                                </td>
                                <td>
                                    {$val["email"]}
                                </td>
                                
                                <td>
                                    {$val["created_at"]}
                                </td>
                                <td>
                                    {$val["updated_at"]}
                                </td>
                                <td class="actions-col">
                                    <button class="btn btn-view" data-id="{$val["id"]}" data-tbl="users">
                                        <i class="fa-sharp fa-solid fa-list"></i>
                                        <span>View</span>
                                    </button>
                                    <button class="btn btn-edit" data-id="{$val["id"]}" data-tbl="users">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Edit</span>
                                    </button>
                                    <button class="btn btn-delete" data-id="{$val["id"]}" data-tbl="users">
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
        <h1 class="form-header">Edit User</h1>
        <form id="main-form" enctype="multipart/form-data">
            <div class="txt_field" id="id-input">
                <input type="number" name="id" id="id" readonly>
                <span></span>
                <label>ID: </label>
            </div>
            <div class="form-row">
                <div class="txt_field">
                    <input type="text" name="firstname" id="firstname" required>
                    <span></span>
                    <label>Firstname: </label>
                </div>
                <div class="txt_field">
                    <input type="text" name="lastname" id="lastname" required>
                    <span></span>
                    <label>Lastname: </label>
                </div>
            </div>
            <div class="txt_field">
                <input type="text" name="email" id="email" required>
                <span></span>
                <label>Email: </label>
            </div>
            <!-- <div class="txt_field">
                <input type="text" name="password" id="password" required disabled>
                <span></span>
                <label>Password: </label>
            </div> -->
            <div class="txt_field">
                <input type="text" name="number" id="number" required>
                <span></span>
                <label>Number: </label>
            </div>
            <div class="txt_field" id="password-input">
                <input type="password" name="password" id="password" disabled>
                <span></span>
                <label>Password: </label>
            </div>
            <input type="hidden" id="table-model" name="table-model" value="users">
            <input type="submit" value="Save Changes" name="submit" id="submit-btn">
            <button type="button" name="submit" class="btn-cancel" id="btn-cancel">Cancel Changes </button>
        </form>
    </dialog>
    <script src="../assets/scripts.js"></script>
</body>

</html>