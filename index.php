<?php 
	require_once 'functions/functions.php';
	
	if(isset($_GET['cin']) && !empty($_GET['cin'])) {
		deleteStudents($_GET['cin']);
		header('location: index.php');
	}
	
	// inital 
	$students = getALLStudents();
	$modules = getALLModules();

	include 'includes/header.php'; 
?>
<div class="container">
	<h2>List des tudiants</h2>
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
			<tr>
				<td>
					<img 	src="uploads/images/<?= $student['image']  ?>" 
							width="75" 
							heigth="75"
							style="margin: 0 auto">
				</td>
				<td><?= $student['cin']  ?></td>
				<td><?= $student['nom']  ?></td>
				<td><?= $student['prenom']  ?></td>
				<td><?= $student['date_naissance']  ?></td>
				<td>
					<button  type="button" data-toggle="modal" data-target="#modalNotes<?= $key  ?>" class="btn btn-success"><i class="fa fa-eye"></i> Voire les notes</button>
				</td>
				<td>
					<a href="index.php?cin=<?= $student['cin']  ?>" class="btn btn-danger">Supprimer</a>
				</td>
			</tr>
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
	                <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Fermer</button>
	            </div>
	        </div>
	    </div>
	</div>
<?php endforeach ?>

<?php include 'includes/footer.php'; ?>