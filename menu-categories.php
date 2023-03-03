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
    <title>Our Dishes</title>
</head>

<body>
    <?php
    include("components/navbar.php");
    ?>
    <main class="container">
        <section style="background-color: #FEBE8C; padding:1rem; background-image: url('assets/imgs/app.png'); background-repeat: no-repeat; background-size: cover; background-position: center;">
            <h1 class="h1 cover-header">Our Dishes</h1>
        </section>
        <section style="margin: 2rem;">
            <h3 style="text-align: center; font-weight:bold">Served at any time of the day</h3>
            <h1 class="h1">Categories</h1>
            <h3 style="text-align: center;">We serve vast delectable dishes from the categories below</h3>
        </section>
        <section class="catalouge-wrapper">
            <div class="catalouge-item" style="background-image: url('assets/imgs/tomatoe-and-garlic-soup.png');">
                <a href="menu/appetizers.php">
                    <h2>APPETIZERS</h2>
                </a>
            </div>
            <div class="catalouge-item" style="background-image: url('assets/imgs/main-course-cover.png');">
                <a href="menu/main-courses.php">
                    <h2>MAIN COURSES</h2>
                </a>
            </div>
            <div class="catalouge-item" style="background-image: url('assets/imgs/salad-cover.png');">
                <a href="menu/salads.php">
                    <h2>SALAD</h2>
                </a>
            </div>
            <div class="catalouge-item" style="background-image: url('assets/imgs/seafood-cover.png');">
                <a href="menu/seafoods.php">
                    <h2>SEA FOODS</h2>
                </a>
            </div>
            <div class="catalouge-item" style="background-image: url('assets/imgs/pasta-cover.png');">
                <a href="menu/pastas.php">
                    <h2>PASTAS</h2>
                </a>
            </div>
            <div class="catalouge-item" style="background-image: url('assets/imgs/dessert-cover.png');">
                <a href="menu/desserts.php">
                    <h2>DESSERTS</h2>
                </a>
            </div>
            <div class="catalouge-item">
                <a href="main-menu.php">
                    <h2>
                        View All Dishes <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </h2>
                </a>
            </div>
        </section>
    </main>
    <?php
    include("components/footer.php");
    ?>
</body>
<script src="assets/js/global.js"></script>
<script src="assets/js/modals.js"></script>
</html>