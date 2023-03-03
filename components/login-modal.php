<dialog class="modal" id="login-modal">
	<div class="card-content">
		<span class="close-modal" id="close-login-modal">
			<i class="fa-solid fa-xmark"></i>
		</span>
		<div class="card-header">
			<div>
				<h5 style="text-align: center;">Welcome back to</h5>
				<a href="<?php echo route('index.php') ?>" target="_blank" rel="noopener noreferrer">
					<img src="<?php echo assets('assets/imgs/logo-dark.png') ?>" style="max-width: 100%;" alt="Hub'z Bistro">
				</a>
			</div>
		</div>
		<ul id="login-errors">
		</ul>
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
		<!-- <div class="extra-links">
			<a href="webpage.php"> Forgot Password? </a>
			<a href="registercustomer.php"> Create a new account </a>
		</div> -->
	</div>
</dialog>
<script>
	const loginForm = document.getElementById("login-form");
	loginForm.addEventListener("submit", (e) => {
		const xhttp = new XMLHttpRequest();
		e.preventDefault();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4) {
				const response = JSON.parse(this.responseText);
				switch (xhttp.status) {
					case 200: {
						const successModal = document.getElementById("success-modal");
						document.getElementById("login-modal").close();
						successModal.showModal();
						successModal.querySelector("#success-msg").innerHTML = response["response"] + "<br>Please wait while we redirect you...";
						sleep(800, () => {
							window.location.reload();
						});
						break;
					}
					case 401: {
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
						break;
					}
					case 404: {
						alert("Page not found");
						break;
					}
					default: {
						console.log(`Nothing to do on Code ${xhttp.status} `);
						break;
					}
				}
			}
		};
		xhttp.open("POST", "<?php echo assets("auth/process/login.php"); ?>", true);
		xhttp.send(new FormData(e.target));
	});
</script>