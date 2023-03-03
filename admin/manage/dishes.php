<?php
session_start();
include_once("../functions/global.php");
include_once("../functions/dishes.php");

$data = get_all_dishes(1, 25);
$categories = get_dish_categories();

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
        <h1 style="text-align: center;">Manage Dishes</h1>
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
                Add New Dish
            </button>
        </div>
        <table style="width:100%;">
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>

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
                                {$val["name"]}
                            </td>
                            <td>
                                {$val["category"]}
                            </td>
                            <td>
                                {$val["price"]}
                            </td>
                            <td>
                                {$val["created_at"]}
                            </td>
                            <td>
                                {$val["updated_at"]}
                            </td>
                            <td class="actions-col">
                                <button class="btn btn-view" data-id="{$val["id"]}" data-tbl="dishes">
                                    <i class="fa-sharp fa-solid fa-list"></i>
                                    <span>View</span>
                                </button>
                                <button class="btn btn-edit" data-id="{$val["id"]}" data-tbl="dishes">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </button>
                                <button class="btn btn-delete" data-id="{$val["id"]}" data-tbl="dishes">
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
        <h1 class="form-header" id="form-header">Edit Dish</h1>
        <form id="main-form">
            <div>
                <img src="https://via.placeholder.com/350x250" alt="Image" name="image-prev" id="image-prev" style="margin: auto;" width="350" height="250">
                <div class="txt_field">
                    <input type="file" name="image" id="image" style="margin-top: .5rem;" accept="image/png, image/jpeg">
                    <span></span>
                    <label>Image: </label>
                </div>
            </div>
            <div class="txt_field" id="id-input">
                <input type="number" name="id" id="id" readonly>
                <span></span>
                <label>ID: </label>
            </div>
            <div class="txt_field">
                <input type="text" name="name" id="name" required>
                <span></span>
                <label>Name: </label>
            </div>
            <div class="form-row">
                <div class="txt_field">
                    <input type="number" name="price" id="price" class="price" required>
                    <span></span>
                    <label>Price: </label>
                </div>
                <div>
                    <label>Category: </label>
                    <select name="category" id="category" style="width: 100%; height:50%">
                        <?php
                        foreach ($categories as $key => $val) {
                            echo <<<CONTENT
                                <option value="{$val["id"]}" style="text-transform: capitalize">
                                    {$val["category-name"]}
                                </option>
                            CONTENT;
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="txt_field">
                <textarea name="description" id="description" rows="10" style="width: 100%;"></textarea>
                <span></span>
                <label>Description: </label>
            </div>
            <input type="hidden" id="table-model" name="table-model" value="dishes">

            <input type="submit" value="Save Changes" name="submit" id="submit-btn">
            <button type="button" name="submit" class="btn-cancel" id="btn-cancel">Cancel Changes </button>
        </form>
    </dialog>
    <script src="../assets/scripts.js"></script>
    <script>
        let imgInput = document.getElementById("image");
        var imgPrev = document.getElementById("image-prev");
        imgInput.addEventListener("change", () => {
            const [file] = imgInput.files;
            if (file) {
                imgPrev.setAttribute("src", URL.createObjectURL(file));
            }
        });
    </script>
</body>

</html>