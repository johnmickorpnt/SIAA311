<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
require(str_contains($link, "/menu/") ? "../functions/linking.php" : "functions/linking.php");
$loggedIn = !empty($_SESSION["user"]);
$homeLink = route("index.php");

?>
<nav style="position: sticky; top:0;">
    <div class="topnav">
        <div class="logo">
            <a href="<?php echo $homeLink; ?>">
                <img src="<?php echo assets("assets/imgs/logo.png"); ?>" height="45rem" width="200rem">
            </a>
        </div>
        <?php
        $loginLink = route('auth/customerlogin.php');
        $registerLink = route('auth/registercustomer.php');
        $logout = route('auth/process/logout.php');
        $reserveLink = route('reservation.php');
        $appetizersLink = route('menu/appetizers.php');
        $mainCourseLink = route('menu/main-courses.php');
        $saladLink = route('menu/salads.php');
        $soupLink = route('menu/soups.php');
        $seaFood = route('menu/seafoods.php');
        $pastaLink = route('menu/pastas.php');
        $reservationsLink = route('my-reservations.php');
        $preOrdersLink = ('my-preorders.php');
        echo !$loggedIn ? <<<AUTH
                <a href="javascript:void(0)" class="nav-item toggle-modal" modal-target="login-modal">
                    Login
                </a>
                <a class="nav-item toggle-modal" href="javascript:void(0)" id="toggle-register" class="" modal-target="register-modal">
                    Register
                </a>
                AUTH : <<<ACCOUNT
                <div class="nav-item dropdown" style="position:relative">
                    <a style="color:white; height:100%" href="">My Account</a>
                    <div class="dropdown-content">
                        <a href="{$reservationsLink}">My Reservations</a>
                        <a href="{$preOrdersLink}">My Pre-orders</a>
                        <a href="$logout">Logout</a>
                    </div>
                </div>
                <div class="nav-item">
                    <a  href="{$reserveLink}">
                        Book a Reservation
                    </a>
                </div>
                ACCOUNT;
        ?>

        <div class="nav-item dropdown" style="position:relative">
            <a style="color:white; height:100%" href="<?php echo route('menu-categories.php'); ?>">Our Dishes</a>
            <div class="dropdown-content">
                <a href="<?php echo $appetizersLink; ?>">Appetizers</a>
                <a href="<?php echo $mainCourseLink; ?>">Main Course</a>
                <a href="<?php echo $saladLink; ?>">Salad</a>
                <a href="<?php echo $soupLink; ?>">Soup</a>
                <a href="<?php echo $pastaLink; ?>">Pasta</a>
                <a href="<?php echo $seaFood; ?>">Seafood</a>
            </div>
        </div>
        <div class="nav-item">
            <a class="active" href="homepage.php">
                About Us
            </a>
        </div>
        <div class="nav-group" id="nav-group">
            <i class="fa-solid fa-bars"></i>
        </div>
    </div>
</nav>
<?php
include("login-modal.php");
include("register-modal.php");
include("success-modal.php");
?>