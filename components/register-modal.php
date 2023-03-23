<dialog class="modal" id="register-modal">
	<div class="card-content">
		<span class="close-modal" id="close-login-modal">
			<i class="fa-solid fa-xmark"></i>
		</span>
		<div class="card-header">
			<div>
				<h5 style="text-align: center;">Welcome to</h5>
				<a href="../" target="_blank" rel="noopener noreferrer">
					<img src="<?php echo assets('assets/imgs/logo-dark.png') ?>" style="max-width: 100%;" alt="Hub'z Bistro">
				</a>
			</div>
		</div>
		<ul id="register-errors"></ul>
		<form method="POST" enctype="application/x-www-form-urlencoded" id="register-form">
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
</dialog>
<dialog id="create-loading" class="modal">
	<h1>Creating your account...</h1>
</dialog>
<script>
	const registerForm = document.getElementById("register-form");
	const loading = document.getElementById("create-loading");
	registerForm.addEventListener("submit", (e) => {
		const xhttp = new XMLHttpRequest();
		e.preventDefault();
		loading.showModal();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4) {
				const response = JSON.parse(this.responseText);
				switch (xhttp.status) {
					case 200: {
						const successModal = document.getElementById("success-modal");
						document.getElementById("register-modal").close();
						loading.close();
						successModal.showModal();
						successModal.querySelector("#success-msg").innerHTML = response["response"] + "<br>Please wait while we redirect you...";
						sleep(800, () => {
							successModal.close();
							const Toast = Swal.mixin({
								toast: true,
								position: 'bottom-end',
								showConfirmButton: false,
								timer: 3000,
								timerProgressBar: true,
								didOpen: (toast) => {
									toast.addEventListener('mouseenter', Swal.stopTimer)
									toast.addEventListener('mouseleave', Swal.resumeTimer)
								}
							})
							Toast.fire({
								icon: 'success',
								title: 'Created an account successfully.'
							})
						});
						break;
					}
					case 422: {
						var registerErrors = document.getElementById("register-errors");
						sleep(800, () => {
							loading.close();
							registerErrors.innerText = "";
							for (let x of response) {
								if (typeof x !== "object") {
									var list = document.createElement("li");
									list.innerHTML = x;
									list.classList.add("invalid");
									registerErrors.append(list);
								}
							}
							const invalids = document.querySelectorAll(".invalid");
							invalids.forEach(item => {
								item.addEventListener("click", () => item.remove());
							});
						});

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
		xhttp.open("POST", "<?php echo assets("auth/process/register.php"); ?>", true);
		xhttp.send(new FormData(e.target));
	});
</script>