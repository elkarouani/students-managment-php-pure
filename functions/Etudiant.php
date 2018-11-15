<?php 

require_once 'dao.php';

class Etudiant {
	private $cne;
	private $nom;
	private $prenom;
	private $date_naissance;
	private $photo;

	public function __construct($cne, $nom, $prenom, $date_naissance, $photo) {
		$this->cne = $cne;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->date_naissance = $date_naissance;
		$this->photo = $photo;
	}

	public function inserer() {
		$sql = "INSERT INTO etudiants VALUES(?, ?, ?, ?, ?)";
		$params = [$this->cne, $this->nom, $this->prenom, $this->date_naissance, $this->photo];
  		die(var_dump(setData($sql, $params)));
  		return 1;
	}
}