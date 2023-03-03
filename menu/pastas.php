<?php
session_start();
include("../functions/menu.php");
$data = get_dishes(7);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <?php
    include("../components/links.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Pastas</title>
</head>

<body>
    <?php
    include("../components/navbar.php");
    ?>
    <main class="container">
        <section class="section-header" style="background-image: url('../assets/imgs/pasta-cover.png');">
            <h1 class="h1 cover-header">PASTAS</h1>
        </section>
        <section class="menu-grid">
            <?php
            if (isset($data)) {
                foreach ($data as $key => $val) {
                    $img = assets($val->image);
                    echo <<<CONTENT
                    <a href="../dish.php?id={$val->id}" class="menu-grid-item">
                        <div desc="{$val->description}">
                            <img src="{$img}" alt="Pumpkin Soup" width="100%">
                        </div>
                        <span class="name">{$val->name}</span>
                        <span class="price">{$val->price}</span>
                    </a>
                    CONTENT;
                }
            } else {
                echo <<<CONTENT
                    <h1>Whoops! Looks like this category is still under development. Come back soon!</h1>
                CONTENT;
            }
            ?>
        </section>
    </main>
    <?php
    include("../components/footer.php");
    ?>
</body>
<script src="../assets/js/global.js"></script>

</html>