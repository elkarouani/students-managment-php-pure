<?php 
	require_once 'functions/functions.php';
	
	$users = getAllUsers();
	$modules = getALLModules();

	include 'includes/headerAdm.php'; 
?>
<div class="container">
	<?php 
		if (isset($_POST['updateUser'])) {
			$result = updateUser($_POST);
			if($result){
				sleep(1);
				echo '<script type="text/javascript">window.location.replace("adminInterface.php?page=1");</script>';
			}else {
				echo 'error';
			}
		}
		if (isset($_POST['deleteUser'])) {
			$result = deleteUser($_POST['id']);
			if($result){
				sleep(1);
				echo '<script type="text/javascript">window.location.replace("adminInterface.php?page=1");</script>';
			}else {
				echo 'error';
			}
		}
		if (isset($_POST['updateCourse'])) {
			$result = updateCourse($_POST);
			if($result){
				sleep(1);
				echo '<script type="text/javascript">window.location.replace("adminInterface.php?page=2");</script>';
			}else {
				echo 'error';
			}
		}
		if (isset($_POST['deleteCourse'])) {
			$result = deleteCourse($_POST['id']);
			if($result){
				sleep(1);
				echo '<script type="text/javascript">window.location.replace("adminInterface.php?page=2");</script>';
			}else {
				echo 'error';
			}
		}
		if (isset($_POST['create'])) {
			$result = createUser($_POST);
			if($result){
				sleep(1);
				echo '<script type="text/javascript">window.location.replace("adminInterface.php?page=1");</script>';
			}else {
				echo 'error';
			}
		}
		if (isset($_POST['createCourse'])) {
			$result = createCourse($_POST['name']);
			if($result){
				sleep(1);
				echo '<script type="text/javascript">window.location.replace("adminInterface.php?page=2");</script>';
			}else {
				echo 'error';
			}
		}
	?>
	<?php if ($_GET['page'] === '1'): ?>
		<h2>
			List des utilisateurs 
			<button class="btn btn-primary pull-right" data-toggle="modal" data-target="#createModal">Nouveau utilisateur</button>
		</h2>

		<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
			   	<div class="modal-content">
			      	<div class="modal-header">
			        	<h2 class="modal-title" id="exampleModalLabel">Add new article</h2>
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          		<span aria-hidden="true">&times;</span>
			        	</button>
			      	</div>
			      	<form method="POST">
			      		<div class="modal-body">
			    			<div class="form-group">
					    		<label for="newName">name :</label>
					    		<input type="text" class="form-control" id="newCin" placeholder="Entrer name" name="name" value="">
					    	</div>
					    	<div class="form-group">
					    		<label for="newEmail">email :</label>
					    		<input type="email" class="form-control" id="newNom" placeholder="Entrer email" name="email" value="">
					    	</div>
					    	<div class="form-group">
					    		<label for="newPassword">password :</label>
			    				<input type="text" class="form-control" id="newTel" placeholder="Entrer password" name="password" value="">
					    	</div>
					    	<div class="form-group">
					    		<label for="newSelectAdmin">is admin :</label>
					    		<select class="form-control" name="is_admin" id="newSelectAdmin">
      								<option></option>
      								<option>true</option>
      								<option>false</option>
    							</select>
					    	</div>
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				        	<button onclick="fun3()" type="submit" class="btn btn-primary" name="create">Save</button>
				      	</div>
			    	</form>
			    </div>
			</div>
		</div>
		
		<hr>
		<table class="table table-bordered table-striped">
			<tr>
				<th>id</th>
				<th>name</th>
				<th>email</th>
				<th>password</th>
				<th>created at</th>
				<th>is admin</th>
				<th>Action</th>
			</tr>
			<?php foreach ($users as $user): ?>
				<form method="POST">
					<tr>
						<td style="width: 80px;">
							<input readonly="readonly" class="form-control" type="text" name="id" value="<?= $user['id']  ?>">
						</td>
						<td style="width: 150px;">
							<input class="form-control" type="text" name="name" value="<?= $user['name']  ?>">
						</td>
						<td style="width: 200px;">
							<input class="form-control" type="email" name="email" value="<?= $user['email']  ?>">
						</td>
						<td style="width: 230px;">
							<input class="form-control" type="text" name="password" value="<?= $user['password']  ?>">
						</td>
						<td><input class="form-control" type="text" name="created_at" value="<?= $user['created_at']  ?>"></td>
						<td style="width: 90px;">
							<input class="form-control" type="text" name="is_admin" value="<?= $user['is_admin']  ?>">
						</td>
						<td>
							<input onclick="fun1()" class="btn btn-sm btn-success" type="submit" name="updateUser" value="Editer">
							<input onclick="fun2()" class="btn btn-sm btn-danger" type="submit" name="deleteUser" value="Supprimer">
						</td>
					</tr>
				</form>
			<?php endforeach ?>
		</table>
		<script type="text/javascript">
			function fun1(){
				swal({
					type: 'success',
  					title: 'user has been updated',
  					showConfirmButton: false,
  					timer: 1500
				})
			}
			function fun2(){
				swal({
					type: 'success',
  					title: 'user has been deleted',
  					showConfirmButton: false,
  					timer: 1500
				})
			}
			function fun3(){
				swal({
					type: 'success',
  					title: 'User has been created',
  					showConfirmButton: false,
  					timer: 1500
				})
			}
		</script>

	<?php endif ?>
	<?php if ($_GET['page'] === '2'): ?>
		<h2>
			List des modules 
			<!-- <a href="new-student.php" class="btn btn-primary pull-right">Nouveau module</a> -->
			<form method="POST" class="pull-right">
				<input type="text" name="name" value="" style="width: 200px;height: 30px;">
				<input onclick="fun31()" class="btn btn-sm btn-success" type="submit" name="createCourse" value="Nouveau module">
			</form>
		</h2>
		<hr>
		<table class="table table-bordered table-striped">
			<tr>
				<th>id</th>
				<th>nom</th>
				<th>Action</th>
			</tr>
			<?php foreach ($modules as $module): ?>
				<form method="POST">
					<tr>
						<td><input readonly="readonly" class="form-control" type="text" name="id" value="<?= $module['id']  ?>"></td>
						<td><input class="form-control" type="text" name="name" value="<?= $module['nom']  ?>"></td>
						<td>
							<input onclick="fun11()" class="btn btn-sm btn-success" type="submit" name="updateCourse" value="Editer">
							<input onclick="fun21()" class="btn btn-sm btn-danger" type="submit" name="deleteCourse" value="Supprimer">
						</td>
					</tr>
				</form>
			<?php endforeach ?>
		</table>
		<script type="text/javascript">
			function fun11(){
				swal({
					type: 'success',
  					title: 'Course has been updated',
  					showConfirmButton: false,
  					timer: 1500
				})
			}
			function fun21(){
				swal({
					type: 'success',
  					title: 'Course has been deleted',
  					showConfirmButton: false,
  					timer: 1500
				})
			}
			function fun31(){
				swal({
					type: 'success',
  					title: 'Course has been created',
  					showConfirmButton: false,
  					timer: 1500
				})
			}
		</script>
	<?php endif ?>	
</div>
<?php include 'includes/footer.php'; ?>