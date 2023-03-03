<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">

	<title>Hub'z Bistro Registration</title>
</head>

<body>
	<div class="card-container">
		<div class="card-content" style="box-shadow: 0px 0px 22px 4px rgba(0,0,0,0.5);-webkit-box-shadow: 0px 0px 22px 4px rgba(0,0,0,0.5);-moz-box-shadow: 0px 0px 22px 4px rgba(0,0,0,0.5);">
			<div class="card-header">
				<div>
					<h5 style="text-align: center;">Welcome to</h5>
					<a href="../" target="_blank" rel="noopener noreferrer">
						<img src="../assets/imgs/logo-dark.png" style="max-width: 100%;" alt="Hub'z Bistro">
					</a>
				</div>
			</div>
			<?php
			if (!empty($_SESSION["msg"])) {
				echo "<ul>";
				foreach ($_SESSION["msg"] as $msg) {
					echo "<li class='invalid'>$msg</li>";
				}
				echo "</ul>";
				unset($_SESSION["msg"]);
			}
			?>

			<form action="process/register.php" method="POST" enctype="application/x-www-form-urlencoded">
				<div class="form-row">
					<div class="txt_field">
						<input type="text" name="fname" required>
						<span></span>
						<label>First Name </label>
					</div>
					<div class="txt_field">
						<input type="text" name="lname" required>
						<span></span>
						<label>Last Name </label>
					</div>
				</div>

				<div class="txt_field">
					<input type="text" name="email" required>
					<span></span>
					<label>Email </label>
				</div>
				<div class="txt_field">
					<input type="text" name="number" required>
					<span></span>
					<label>Number </label>
				</div>

				<div class="txt_field">
					<input type="password" name="pass" required>
					<span></span>
					<label>Password </label>
				</div>

				<div class="txt_field">
					<input type="password" name="conpass" required>
					<span></span>
					<label>Confirm Password </label>
				</div>
				<div>
					<input id="cb" type="checkbox" name="remember" required>
					<label for="cb" style="font-size: smaller;">
						I am 18 years of age or older and agree to the terms of the Hub'Z Bistro Agreement and the Hub'Z Bistro Privacy Policy.
					</label>
				</div>

				<input type="submit" value="Create an Account" class="btn" name="btn-save" style="margin-top: 2rem;">
				<div style="width: 100%; padding:1rem; text-align:center">
					<a href="customerlogin.php" class="link">
						Already have an account? Log in here
					</a>
				</div>
			</form>
		</div>
	</div>
</body>

</html>