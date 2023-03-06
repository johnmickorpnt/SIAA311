<?php
session_start();
if (!isset($_GET["id"]))  header("Location: menu-categories.php");

$id = $_GET["id"];
include("functions/menu.php");
include("functions/user.php");
$dish = json_decode(get_menu_item($id));

if (isset($_SESSION["user"]))
    $appointments = json_decode(get_reservations($_SESSION["user"], 1));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href='assets/css/style.css'>
    <?php
    include("components/links.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Dish</title>
</head>

<body>
    <?php
    include("components/navbar.php");

    ?>
    <main class="container">
        <section class="dish-container">
            <div class="dish-img">
                <h1 style="font-family: 'Ubuntu', sans-serif; grid-column: 1 / -1; font-weight:bold; text-transform:uppercase; font-size:xx-large">
                    <?php
                    echo $dish->name;
                    ?>
                </h1>
                <img src="<?php echo assets($dish->image) ?>" alt="<?php echo $dish->image; ?>">
            </div>
            <div class="dish-info">
                <h1 class="dish-title">
                    Description
                </h1>
                <p style="margin-bottom: auto;">
                    <?php
                    echo $dish->description;
                    ?>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum, architecto corporis magni laborum iusto similique!
                </p>
                <span class="price-info">
                    Available for
                    <span class="price">
                        <?php echo $dish->price; ?>
                    </span>
                    only
                </span>
                <?php
                if (isset($_SESSION["user"])) {
                    $options = "";
                    $keys = array_keys($appointments);
                    if (isset($appointments)) {
                        foreach ($appointments as $key => $item) {
                            $options .= "<option value='{$item->id}'>" . date("m/d/y D @ h:i:s", strtotime($item->startTime)) . "</option>";
                        }
                    }
                    $options = $options ?? "<option value=''>No Active reservation</option>";
                    echo <<<CONTENT
                        <form action="apis/pre-order.php" style="display: flex; flex-direction:column" method="POST">
                            <input type="hidden" id="dishId" name="dishId" value="{$_GET['id']}">
                            <div class="form-row">
                                <div class="txt_field">
                                    <input type="number" name="quantity" required min=1 value=1>
                                    <label>Quantity of Orders: </label>
                                </div>
                            </div>
                            <input class="btn" type="submit" value="Add to my table" id="add">
                            <input class="btn dark" type="submit" value="Remove to my table" id="remove">
                        </form>
                        CONTENT;
                } else {
                    echo <<<CONTENT
                            <a class="btn">Login to pre-order this dish to your table!</a>
                        CONTENT;
                }
                ?>
            </div>
        </section>
    </main>
    <section>
        <?php
        if (isset($_SESSION["order-msg"]))
            // var_dump($_SESSION["order-msg"]);
            echo <<<CONTENT
            <script>alert("{$_SESSION["order-msg"][0]}")</script>
            CONTENT;
        unset($_SESSION["order-msg"]);
        ?>
    </section>
    <?php
    include("components/footer.php");
    ?>
</body>
<script src="assets/js/global.js"></script>

</html>