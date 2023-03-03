<?php

if(isset($_POST['btn-save'])){
	$name = $_POST['name'];
	$password = $_POST['password'];
	$conpass = $_POST['conpass'];
	$email = $_POST['email'];
	$number = $_POST['number'];
	
	$db = mysqli_connect('localhost','root','','hubzbistro');

	if($password == $conpass)
	{
		$check_query = mysqli_query($con, "SELECT * FROM cus_inf where EMAIL ='$email'");
		$rowCount = mysqli_num_rows($check_query);

		if(!empty($email) && !empty($password))
		{
			if($rowCount > 0)
			{
				?>
					<script>
						alert("User with email already exist!");
					</script>
				<?php
			}
			else
			{

	$query = "insert into cus_inf (name,password,conpass,email,number)
	values ('$name','$password','$conpass','$email','$number')";
	mysqli_query($db,$query);

	echo "<script> alert('Registration Successful'); </script>";

}
?>