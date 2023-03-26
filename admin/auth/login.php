<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("../../components/links.php"); ?>
    <link rel="stylesheet" href="../assets/styles.css">
    <script src="../assets/scripts.js"></script>
    <title>Login</title>
</head>

<body>
    <main class="container">
        <div class="card-container">
            <div class="card-header">
                <div>
                    <h3 style="text-align: center;">Admin Panel</h3>
                    <a href="#" target="_blank" rel="noopener noreferrer">
                        <img src="../../assets/imgs/logo.jpg" style="max-width: 100%;" alt="Hub'z Bistro">
                    </a>
                </div>
            </div>
            <form action="" method="POST">
                <div class="txt_field">
                    <input type="text" name="user" required>
                    <span></span>
                    <label>Username: </label>
                </div>
                <div class="txt_field">
                    <input type="password" name="pass" required>
                    <span></span>
                    <label>Password: </label>
                </div>
                <input type="submit" value="Login" name="sub">
            </form>
        </div>
    </main>
</body>
<?php
$db = mysqli_connect('localhost', 'root', '', 'hubzbistro');

if (!$db) {
    echo 'Please check your database connection';
}

$valid = array();
$_SESSION["msg"] = array();
$response = array();

if (isset($_POST['user']) && isset($_POST['pass'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $sql = "Select * from admin where username = '$user' AND password = '$pass'";

    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    if (!$result) {
        http_response_code(401);
        $response = json_encode(["response" => "Invalid Email/Password."]);
    } else {
        $response = json_encode(["response" => "Login Successful"]);
        $_SESSION["admin"] = $row["username"];
        header("Location: " . "../manage/users.php");
    }
}

?>

</html>