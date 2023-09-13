<?php session_start(); 
include '../database.php'; 
$title = $_POST['title']; 
$code_module = $_POST['code_module']; 
$teacher = $_POST['teacher']; 
$credit = $_POST['credit']; 
$coeff = $_POST['coeff']; 
$specialite = $_POST['specialite']; 
$level = $_POST['level']; 
$semester = $_POST['semester']; 
if(isset($_POST['tp'])) 
	$tp = 1; 
else 
	$tp = 0; 
if(isset($_POST['control'])) 
	$control = 1; 
else 
	$control = 0; 
if(isset($_POST['exam'])) 
	$exam = 1; 
else 
	$exam = 0; 
$exist = 0; 
if(!(isset($_SESSION['ad_id']))){
	header("Location:index.php?msg="); 
} 
else{
	try {
		$connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password); 
		$req = "SELECT * FROM modules"; 
		$res = $connexion->query($req); 
		while($lines = $res->fetch(PDO::FETCH_ASSOC)) {
			if($lines['code_module'] == $code_module) 
				$exist++; 
		} 
		if($exist == 0){
			$msg = "Code module n`existe pas!"; 
			header("Location:gerer_module.php?msg=".$msg.""); 
		} 
		else{
			$requete_sql = "UPDATE modules SET nom_module = '".$title."', credit = ".$credit.", coef = ".$coeff.", num_enseignant = '".$teacher."', specialite = '".$specialite."', niveau = '".$level."', semester = ".$semester.", tp = ".$tp.", controle = ".$control.", exam = ".$exam." WHERE code_module = '".$code_module."'"; 
			$connexion->exec($requete_sql); 
			header("Location:admin.php"); 
		} 
		$connexion = null; 
	} catch (PDOException $e) {echo "Erreur ! " . $e->getMessage() . "<br/>"; } 
} 
?>