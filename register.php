<?php 
	require_once 'functions/functions.php';
	include 'includes/headerAuth.php'; 
?>
<div class="container">
	<h2 class="text-center">Register</h2>
	<hr>
	<?php 
		if (isset($_POST['sign'])) {
			$data = getUserByEmailAndPassword($_POST['email'], $_POST['password']);

			if($data) {
				echo '<h5 class="text-warning border-warning text-center">email used before !!</h5>';
			}else{
				if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === "") {
					echo '<h5 class="text-warning border-warning text-center">invalid email !!</h5>';
				}elseif ($_POST['password'] !== $_POST['re-password']) {
					echo '<h5 class="text-warning border-warning text-center">Please, enter the same passwords !!</h5>';
				}else{
					$result = setUser($_POST);

					if(!$result){
						echo '<h5 class="text-danger text-center">Erreur on inserting new user !!</h5>';
					}else{
						echo '<h5 class="text-success border-success text-center">Sign up successfully, go ahead on Log in</h5>';
					}
				}
			}
		}
	?>
	<form method="POST" style="margin: 40px 350px;">
		<div class="form-group">
			<label for="newEmail">Name :</label>
			<input type="text" class="form-control" id="newName" placeholder="Entrer name" name="name" value="">
		</div>
		<div class="form-group">
			<label for="newEmail">Email :</label>
			<input type="text" class="form-control" id="newEmail" placeholder="Entrer email" name="email" value="">
		</div>
		<div class="form-group">
			<label for="newPassword">Password :</label>
			<input type="password" class="form-control" id="newPassword" placeholder="Entrer password" name="password" value="">
		</div>
		<div class="form-group">
			<label for="newConfirmPassword">Confirm Password :</label>
			<input type="password" class="form-control" id="newConfirmPassword" placeholder="Confirm password" name="re-password" value="">
		</div>
		<button type="submit" name="sign" class="btn btn-primary form-control">Sign up</button>
	</form>
</div>

<?php include 'includes/footer.php'; ?>