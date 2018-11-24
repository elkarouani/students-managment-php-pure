<?php 
	require_once 'functions/functions.php';
	include 'includes/headerAuth.php'; 
	session_start();
	if (isset($_SESSION['name'])) {
		if($_SESSION['type'] === "true"){
			header('location: adminInterface.php?page=1');
		}
		if($_SESSION['type'] === "false"){
			header('location: index.php');
		}
	}
?>
<div class="container">
	<h2 class="text-center">Login</h2>
	<hr>
	<?php
		if (isset($_POST['log'])) {
			$data = getUserByEmailAndPassword($_POST['email'], $_POST['password']);

			if(!$data) {
				echo '<h5 class="text-warning border-warning text-center">Email or password wrong, if you are new, go ahead and Sign up !!</h5>';
			}else{
				if($data[0]['is_admin'] === "true"){
					$_SESSION['name'] = $data[0]['name'];
					$_SESSION['type'] = $data[0]['is_admin'];
					header('location: adminInterface.php?page=1');
				}
				if($data[0]['is_admin'] === "false"){
					$_SESSION['name'] = $data[0]['name'];
					$_SESSION['type'] = $data[0]['is_admin'];
					header('location: index.php');
				}
			}
		}
	?>
	<form method="POST" style="margin: 40px 350px;">
		<div class="form-group">
			<label for="newEmail">Email :</label>
			<input type="text" class="form-control" id="newEmail" placeholder="Entrer email" name="email" value="">
		</div>
		<div class="form-group">
			<label for="newPassword">Password :</label>
			<input type="password" class="form-control" id="newPassword" placeholder="Entrer password" name="password" value="">
		</div>
		<button type="submit" name="log" class="btn btn-primary form-control">Login</button>
	</form>
</div>

<?php include 'includes/footer.php'; ?>