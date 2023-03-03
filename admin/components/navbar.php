<?php
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$file = str_contains($url, "SIAA311") ?
    substr($url, strpos($url, "SIAA311") + 7) : substr($url, strpos($url, "/"));
$logo = strrpos($file, "/") > 0 ? "../assets/logo.png" : "assets/logo.png";
?>
<nav>
    <aside class="sidenav">
        <div class="home">
            <a href="#" style="display: flex; flex-direction:column; align-items:center">
                <img src="<?php echo $logo; ?>" alt="Hubz Bistro">
            </a>
        </div>
        <a class="nav-toggle" id="nav-toggle" href="javascript:void(0)">
            <i class="fa-solid fa-chevron-left"></i>
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <a class="nav-item <?php echo str_contains($url, "user") ? 'active' : '';?>" href="../manage/users.php">
            <i class="fa-solid fa-user"></i>
            <span>Users</span>
        </a>
        <a class="nav-item <?php echo str_contains($url, "reservations") ? 'active' : '';?>" href="../manage/reservations.php">
            <i class="fa-solid fa-calendar"></i>
            <span>Reservations</span>
        </a>
        <a class="nav-item <?php echo str_contains($url, "pre-ordered") ? 'active' : '';?>" href="../manage/pre-ordered.php">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Pre-ordered</span>
        </a>
        <a class="nav-item <?php echo str_contains($url, "dishes") ? 'active' : '';?>" href="../manage/dishes.php">
            <i class="fa-sharp fa-solid fa-bowl-food"></i>
            <span>Dishes</span>
        </a>
        <a class="nav-item " href="../auth/logout.php">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>
    </aside>
</nav>