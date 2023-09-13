<?php session_start();
include '../database.php';

$mark = $_POST['mark'];
$num = $_POST['num_etudiant'];
$modulee = $_GET['module'];
$evaluation = $_GET['evaluation'];



try{
  $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
  $requete_sql = "SELECT * from modules where code_module = '".$modulee."'";
  $result = $connexion->query($requete_sql);

  $modules = $result->fetch(PDO::FETCH_ASSOC);
  $coeff = $modules['coef'];
  $credit = $modules['credit'];

      $req1 = "INSERT INTO notes (numero_etudiant, code_module, coeff, credit, ".$evaluation.") VALUES ('".$num."', '".$modulee."', ".$coeff.", ".$credit.", ".$mark.")";
          $connexion->exec($req1);
      $msg = "Mark for ".$num." updated";
      header("Location:ajouter_notes1.php?module=".$modulee."&evaluation=".$evaluation."&msg=".$msg."");
      $connexion = null;
  } catch (PDOException $e) {
      echo "Erreur ! " . $e->getMessage() . "<br/>";
  }

?>