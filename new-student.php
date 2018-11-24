<?php 
	require_once 'functions/functions.php';
	require_once 'functions/Etudiant.php';
	
	// inital 
	$modules = getALLModules();
	$submitErrors = array();

	if(isset($_POST['add_student'])) {
		$errors = array();
		$errors['cin'] = (!preg_match("#^[a-zA-Z]{1,2}[0-9]{4,6}$#", $_POST['cin'])) 
						 ? "Le format de cin est n'est pas valide " 
						 : '';
		if (!empty(getData("SELECT * FROM etudiants WHERE cin = ?", [$_POST['cin']]))) {
		 	$errors['cin'] = "Ce cin existe deja ";
		}
		$errors['nom'] = (!preg_match("#^[a-zA-Z\_\_s]{3,15}$#", $_POST['nom'])) 
						 ? "Le format de nom est n'est pas valide " 
						 : '';
		$errors['prenom'] = (!preg_match("#^[a-zA-Z\_\_s ]{3,15}$#", $_POST['prenom'])) 
						 ? "Le format de prenom est n'est pas valide " 
						 : '';
		if (!isset($_FILES['image']) || !in_array(strchr($_FILES['image']['name'], "."), ['.png', '.jpg', '.gif'])) {
			if (!isset($_FILES['image']['name']) || empty($_FILES['image']['name'])) {
				$image = 'defaul.jpg';
			} else {
				$errors['image'] = "Le format de l'image n'est pas valide ";
			}
		} else {
			$tmp = $_FILES['image']['tmp_name'];
			$image = $_POST['cin'] . '_' . $_FILES['image']['name'];
			move_uploaded_file($tmp, 'uploads/images/' . $image);
		}

		if(count(explode("/", $_POST['date_naissance'])) == 3 && !preg_match("#[a-zA-Z]#", $_POST['date_naissance'])) {
			list($day, $month, $year) = explode("/", $_POST['date_naissance']);
			$errors['date_naissance'] = (!is_numeric($day) || !is_numeric($month) || !is_numeric($year)) || 
										(!checkdate($month, $day, $year))
										? "Le format de la date de naissance est n'est pas valide " 
						 				: '';
		} else {
			$errors['date_naissance'] = "Le format de la date de naissance est n'est pas valide ";
		}

		foreach ($_POST['notes'] ?? [] as $key => $note) {
			$errors['notes'][$key] = !empty($note) && !is_numeric($note)
									 ? "Erreur" 
					 				 : '';
		}

		if (empty($errors['cin']) && empty($errors['nom']) && empty($errors['prenom']) && empty($errors['date_naissance']) && empty($errors['image'])) {
			$etudiant = new Etudiant($_POST['cin'], $_POST['nom'], $_POST['prenom'], date('Y-m-d', strtotime($_POST['date_naissance'])), $image);
			if ($etudiant->inserer()) {
				$params = array();
				$sql = "INSERT INTO notes (etudiant_cin, module_id, note) VALUES ";
				$i = 0;
				foreach ($_POST['notes'] as $key => $note) {
					$i++;
					if (!empty($note)) {
						$widthNotes = true;
						if (count($_POST['notes']) == $i) {
							$sql .= " ('" . $_POST['cin'] . "', " . str_replace("'", "", $key) . ", " . $note . ")";
						} else {
							$sql .= " ('" . $_POST['cin'] . "', " . str_replace("'", "", $key) . ", " . $note . "), ";
						}
					} else {
						$widthNotes = false;
					}
				}
				if (isset($widthNotes) && $widthNotes && setData($sql, $params)) {
					$_POST = [];
					$submitErrors['success'] = "success";
					header('location: index.php');
				} else {
					$submitErrors['errors'] = $sql;
				}
			} else {
				$submitErrors['errors'] = "errors 2";
			}
		} else {
			$submitErrors['errors'] = "errors 3";
		}
	} 

	function old($inputName, $collectionName=null)
	{
		if($collectionName) {
			return isset($_POST[$collectionName]["'" . $inputName . "'"]) ? $_POST[$collectionName]["'" . $inputName . "'"] : '';
		} else {
			return isset($_POST[$inputName]) ? $_POST[$inputName] : '';
		}
	}
	
	include 'includes/header.php';
 ?>


<div class="container">
	<h2>Nouveau etudiant</h2>
	<?php if (isset($submitErrors['success'])): ?>
		<hr>
		 <div class="alert alert-success">
		 	<p><strong>Succes</strong> L'etudiant été ajouter avec succès </p>
		 </div>
	<?php endif ?>

	<?php if (isset($submitErrors['errors'])): ?>
		<hr>
		 <div class="alert alert-danger">
		 	<p><strong>Erreurs</strong> Verifier la validation du formulaire !</p>
		 </div>
	<?php endif ?>
	<hr>
	<form method="post" enctype="multipart/form-data">
		<input type="hidden" name="add_student">
		<div class="row">
			<div class="col-md-9">
				<div class="form-group <?= isset($errors['cin']) && !empty($errors['cin']) ? 'has-error' : '' ?>">
					<label class="control-label">Cin</label>
					<input 	type="text" 
							name="cin" 
							class="form-control" 
							placeholder="Code identite de nationnal"
							value="<?= old('cin') ?>">
					<span class="help-block">
						<?= isset($errors['cin']) && !empty($errors['cin']) ? $errors['cin'] : '' ?>
					</span>
				</div>
				<div class="form-group <?= isset($errors['nom']) && !empty($errors['nom']) ? 'has-error' : '' ?>">
					<label class="control-label">Nom</label>
					<input 	type="text" 
							name="nom" 
							class="form-control" 
							placeholder="Nom"
							value="<?= old('nom') ?>">
					<span class="help-block">
						<?= isset($errors['nom']) && !empty($errors['nom']) ? $errors['nom'] : '' ?>
					</span>
				</div>
				<div class="form-group <?= isset($errors['prenom']) && !empty($errors['prenom']) ? 'has-error' : '' ?>">
					<label class="control-label">Prenom</label>
					<input 	type="text" 
							name="prenom" 
							class="form-control" 
							placeholder="Prenom"
							value="<?= old('prenom') ?>">
					<span class="help-block">
						<?= isset($errors['prenom']) && !empty($errors['prenom']) ? $errors['prenom'] : '' ?>
					</span>
				</div>
				<div class="form-group <?= isset($errors['date_naissance']) && !empty($errors['date_naissance']) ? 'has-error' : '' ?>">
					<label class="control-label">Date naissance</label>
					<input 	type="text" 
							name="date_naissance" 
							class="form-control"
							placeholder="Date naissance"
							value="<?= old('date_naissance') ?>">
					<span class="help-block">
						<?= isset($errors['date_naissance']) && !empty($errors['date_naissance']) ? $errors['date_naissance'] : '' ?>
					</span>
				</div>
				<hr>
				<button type="button" data-toggle="modal" data-target="#modalAddNotes" class="btn btn-warning"> <i class="fa fa-user-plus"></i>&nbsp; Ajouter les notes</button>
				<hr>
				<button class="btn btn-primary"><i class="fa fa-save"></i> Ajouter</button>
				<button class="btn btn-danger"><i class="fa fa-remove"></i> Annuler</button>
			</div>
			<div class="col-md-3 text-right">
				<div class="thumbnail pull-right  <?= isset($errors['image']) && !empty($errors['image']) ? 'border-danger' : '' ?>" style="width: 235px;">
			      <img style="width: 100%; height: 200px; display: block;" class="img-responsive" id="image" src="asset/img/default.png">
			      <div class="caption">
			      	<input type="file" id="fileImage" name="image" onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])" style='display:none' >
                    <button type="button" id="btnChangeImage" class="btn btn-primary btn-sm btn-block"> 
                    	<i class="fa fa-upload"></i> &nbsp; Choisie une image
                    </button>
                    <?php if (isset($errors['image']) && !empty($errors['image'])): ?>
                    	<br>
                    	<p class="text-danger text-center">
							<?= $errors['image'] ?>
						</p>
                    <?php endif ?>
			      </div>
			    </div>
			</div>
		</div>

		<div class="modal fade" id="modalAddNotes" tabindex="-1" role="dialog">
		    <div class="modal-dialog modal-lg">
		        <div class="modal-content">
		            <div class="modal-header bg-purple">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Ajouter les notes </h4>
		            </div>
		            <div class="modal-body">
		            	<table class="table table-bordered">
		            		<tr>
		            			<th>Module</th>
		            			<th>Note</th>
		            		</tr>
		            		<?php foreach ($modules as $key => $module): ?>
			            		<tr>
			            			<td><?= $module["nom"] ?></td>
			            			<td>
			            				<div class="<?= isset($errors['notes'][$module["id"]]) && !empty($errors['notes'][$module["id"]]) ? 'has-error' : '' ?>">
			            					<input 	type="text" 
			            							name="notes['<?= $module["id"] ?>']" 
			            							class="form-control" 
			            							placeholder="Note..."
			            							value="<?= old($module["id"], 'notes') ?>">
			            				</div>
			            			</td>
			            		</tr>
		            		<?php endforeach ?>
		            	</table>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
		            </div>
		        </div>
		    </div>
		</div>
	</form>
	<br>
	<br>
	<br>
</div>
<?php include 'includes/footer.php'; ?>