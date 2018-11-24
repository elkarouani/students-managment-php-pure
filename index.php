<?php 
	require_once 'functions/functions.php';
	
	$i = 0;

	if(isset($_POST['deleteStudent'])) {
		deleteStudents($_POST['cin']);
		sleep(1);
		header('location: index.php');
	} 
	if(isset($_POST['updateStudent'])) {
		updateStudents($_POST);
		sleep(1);
		header('location: index.php');
	}
	
	// inital 
	$students = getALLStudents();
	$modules = getALLModules();

	include 'includes/header.php'; 
?>
<div class="container">
	<h2>List des etudiants <a href="new-student.php" class="btn btn-primary pull-right">Nouveau etudiant</a></h2>
	<hr>
	<table class="table table-bordered table-striped">
		<tr>
			<th>Image</th>
			<th>Cin</th>
			<th>Nom</th>
			<th>Prenom</th>
			<th>Date Naissance</th>
			<th>Notes</th>
			<th>Action</th>
		</tr>
		<?php foreach ($students as $key => $student): ?>
			<form method="POST">
				<tr>
					<td>
						<img 	src="uploads/images/<?= $student['image']  ?>" 
								width="75" 
								heigth="75"
								style="margin: 0 auto">
					</td>
					<td><input readonly="readonly" style="width: 100px;" class="form-control" type="text" name="cin" value="<?= $student['cin']  ?>"></td>
					<td><input style="width: 160px;" class="form-control" type="text" name="nom" value="<?= $student['nom']  ?>"></td>
					<td><input style="width: 170px;" class="form-control" type="text" name="prenom" value="<?= $student['prenom']  ?>"></td>
					<td>
						<input style="width: 110px;" class="form-control" type="text" name="date_naissance" value="<?= $student['date_naissance']  ?>">
					</td>
					<td align="center">
						<button  type="button" data-toggle="modal" data-target="#modalNotes<?= $key  ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Voire les notes</button>
						<a data-toggle="modal" data-target="#modalEditNotes<?= $key  ?>" class="btn btn-sm btn-success">Editer</a>
					</td>
					<td align="center">
						<input onclick="fun1()" type="submit" name="deleteStudent" value="Supprimer" class="btn btn-sm btn-danger">
						<input onclick="fun2()" type="submit" name="updateStudent" value="Editer" class="btn btn-sm btn-success">
					</td>
				</tr>
			</form>
			<script type="text/javascript">
			function fun1(){
				swal({
					type: 'success',
  					title: 'student has been deleted',
  					showConfirmButton: false,
  					timer: 1500
				})
			}
			function fun2(){
				swal({
					type: 'success',
  					title: 'student has been updated',
  					showConfirmButton: false,
  					timer: 1500
				})
			}
		</script>
		<?php endforeach ?>
	</table>
</div>
<?php foreach ($students as $key => $student): ?>
	<div class="modal fade" id="modalNotes<?= $key  ?>" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header bg-purple">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Notes d'etudiant </h4>
	            </div>
	            <div class="modal-body">
	            	<table class="table table-bordered">
	            		<tr> 
	            			<th>Module</th>
	            			<th>Note</th>
	            		</tr>
	            		<?php foreach (getNotStudent($student['cin']) as $notesStudent): ?>
		            		<tr>
		            			<td><?= $notesStudent["nom"] ?></td>
		            			<td><?= $notesStudent["note"] ?></td>
		            		</tr>
	            		<?php endforeach ?>
	            	</table>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal">Fermer</button>
	            </div>
	        </div>
	    </div>
	</div>
<?php endforeach ?>

<?php foreach ($students as $key => $student): ?>
	<div class="modal fade" id="modalEditNotes<?= $key  ?>" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header bg-purple">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Notes d'etudiant </h4>
	            </div>
		        <form method="POST">
	            	<div class="modal-body">
	            		<table class="table table-bordered">
	            			<tr> 
	            				<th>Module</th>
	            				<th>Note</th>
	            				<th>Status</th>
	            			</tr>
	            			<?php $i=0; ?>
	            			<?php foreach (getNotStudent($student['cin']) as $notesStudent): ?>
	            				<?php $i++; ?>
	            				<form method="POST">
			            			<input hidden="hidden" type="text" name="exactName<?= $i ?>" value="<?= $notesStudent["nom"] ?>">
			            			<input hidden="hidden" type="text" name="exactNote<?= $i ?>" id="ExactNote<?= $i ?>" value="">
			            			<input hidden="hidden" type="text" name="exactId<?= $i ?>" id="ExactId<?= $i ?>" value="<?= $notesStudent["module_id"] ?>">
			            			<tr>
			            				<td>
			            					<input class="form-control" readonly="readonly" type="text" name="name" value="<?= $notesStudent["nom"] ?>">
			            				</td>
			            				<td>
			            					<input onchange="changefun<?= $i ?>()" id="Note<?= $i ?>" class="form-control" type="number" name="note" value="<?= $notesStudent["note"] ?>">
			            				</td>
			            				<td>
			            					<button onclick="eresefun<?= $i ?>()" id="BI<?= $i ?>" class="btn btn-sm" type="button" name="note" style="background-color: #0069d9;border-radius: 100%;"><i class="glyphicon glyphicon-erase"></i></button>
			            					<button onclick="sweet();" id="BE<?= $i ?>" class="btn btn-sm" type="submit" name="saveNote<?= $i ?>" style="background-color: #05F70D;border-radius: 100%;"><i class="glyphicon glyphicon-ok"></i></button>
			            					<script type="text/javascript">
												document.getElementById('BE<?= $i ?>').style.visibility = 'hidden';
												function changefun<?= $i ?>(){
													document.getElementById('BE<?= $i ?>').style.visibility = 'visible';
													document.getElementById('ExactNote<?= $i ?>').value = document.getElementById('Note<?= $i ?>').value;
												}
												function eresefun<?= $i ?>(){
													document.getElementById('Note<?= $i ?>').value = 0;
												}
											</script>
			            				</td>
			            			</tr>
		            			</form>
	            			<?php endforeach ?>
	            		</table>
	            	</div>
	            	<div class="modal-footer">
	                	<button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal">Fermer</button>
	            	</div>
		        </form>
	        </div>
	    </div>
	</div>
<?php endforeach ?>

<?php foreach ($students as $key => $student): ?>
	<div class="modal fade" id="modalEditStudent<?= $student['cin']  ?>" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header bg-purple">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Editer les information de l'etudiant</h4>
	            </div>
	            <div class="modal-body">
	            	<form method="post" action="update">
	            		
	            	</form>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal">Fermer</button>
	            </div>
	        </div>
	    </div>
	</div>
<?php endforeach ?>
<?php $data = null; ?>
<?php foreach ($students as $student): ?>
	<?php foreach (getNotStudent($student['cin']) as $notesStudent): ?>
		<?php 
			
			for ($j = 1; $j <= $i; $j++) {
				if (isset($_POST['saveNote'.$j])) {
					$data = array(
						"student_id" => $student['cin'],
						"id_course" => $_POST["exactId".$j],
						"Note" => $_POST['exactNote'.$j]
					); 
				}		            				
			}
		?>
	<?php endforeach ?>	
<?php endforeach ?>
<?php include 'includes/footer.php'; ?>
<?php if(!is_null($data)){
	$result = setNote($data);
	if($result){
		echo '<script type="text/javascript">window.location.replace("index.php");</script>';
	}else {
		echo 'error';
	}
} ?>
