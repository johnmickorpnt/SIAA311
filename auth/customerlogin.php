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

	<?php
	include("../components/links.php");
	?>
	<title>Hub'z Bistro Login</title>
</head>

<body>
	<div class="card-container">
		<div class="card-content" style="box-shadow: 0px 0px 22px 4px rgba(0,0,0,0.5);-webkit-box-shadow: 0px 0px 22px 4px rgba(0,0,0,0.5);-moz-box-shadow: 0px 0px 22px 4px rgba(0,0,0,0.5);">
			<div class="card-header">
				<div>
					<h5 style="text-align: center;">Welcome back to</h5>
					<a href="../index.php" target="_blank" rel="noopener noreferrer">
						<img src="../assets/imgs/logo-dark.png" style="max-width: 100%;" alt="Hub'z Bistro">
					</a>
				</div>
			</div>
			<ul id="login-errors">
			</ul>
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
			<form method="POST" id="login-form">
				<div class="txt_field">
					<input type="text" name="email" required>
					<span></span>
					<label>Email: </label>
				</div>
				<div class="txt_field">
					<input type="password" name="pass" required>
					<span></span>
					<label>Password: </label>
				</div>
				<input type="submit" value="Login" name="sub">
			</form>
			<div class="extra-links">
				<a href="webpage.php"> Forgot Password? </a>
				<a href="registercustomer.php"> Create a new account </a>
			</div>
		</div>
	</div>
</body>
<script>
	// process/login.php
	let form = document.getElementById("login-form");
	let status;
	form.addEventListener("submit", (e) => {
		e.preventDefault();
		let fd = new FormData(e.target);
		// alert("ha")
		fetch("process/login.php", {
				method: "POST",
				headers: {
					'Accept': 'application/json',
				},
				body: fd
			})
			.then((response) => response.json())
			.then((response) => {
				var loginErrors = document.getElementById("login-errors");
				loginErrors.innerText = "";
				let list = document.createElement("li");
				list.innerHTML = `${response["response"]}`;
				list.classList.add("invalid");
				const invalids = document.querySelectorAll(".invalid");
				invalids.forEach(item => {
					item.addEventListener("click", () => item.remove());
				});
				loginErrors.append(list);
			})
	});
</script>

</html>