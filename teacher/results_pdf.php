<?php session_start();


include '../database.php';

$modulee = $_GET['module'];
$evaluation = $_GET['evaluation'];

if(!(isset($_SESSION['id']))){
    header("Location:index.php");
}
else{


try{
  $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
  $requete_sql = "SELECT * from modules where code_module = '".$modulee."'";
  $result = $connexion->query($requete_sql);

  $modules = $result->fetch(PDO::FETCH_ASSOC);
  $level = $modules['niveau'];
  $module = $modules['nom_module'];


  $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
  $req = "SELECT * from etudiants where niveau = '".$level."' ORDER BY nom_etudiant";
  $res = $connexion->query($req);


  require("FPDF/fpdf.php");
  $pdf = new FPDF();

  $pdf-> AddPage();
  $pdf->Image('../images/logo-en.png', 180, 5,15,22);
  $pdf->SetFont("Arial","B",15);
  $pdf->SetFillColor(230,230,230);

  $pdf->Cell(30,30,"",0,0);
  $pdf->Cell(100,30, $level." ".strtoupper($module)." ".strtoupper($evaluation)." NOTES",0,1);

  $pdf->SetFont("Arial","B",11);

  $pdf->Cell(47,5," NOM",1,0, "L", TRUE);
  $pdf->Cell(47,5," PRENOM",1,0, "L", TRUE);
  $pdf->Cell(47,5," NUMERO ETUDIANT",1,0, "L", TRUE);
  $pdf->Cell(47,5," NOTE ".strtoupper($evaluation),1,1, "L", TRUE);
  $pdf->SetFont("Arial","",11);

  $i = 0;

  while($tuple = $res->fetch(PDO::FETCH_ASSOC)){

    $requete_sql2 = "SELECT * from notes where code_module = '".$modulee."' and numero_etudiant = '".$tuple["numero_etudiant"]."' and ".$evaluation." <> 'NULL'";
    $result2 = $connexion->query($requete_sql2);

    while($values = $result2->fetch(PDO::FETCH_ASSOC))
        $value = $values[$evaluation];

    $pdf->Cell(47,5," ".$tuple["nom_etudiant"],1,0);
    $pdf->Cell(47,5," ".$tuple["prenom_etudiant"],1,0);
    $pdf->Cell(47,5," ".$tuple["numero_etudiant"],1,0);
    $pdf->Cell(47,5," ".$value,1,1);

    $value = NULL;
    $i++;
    if($i == 50)
      $pdf-> AddPage();
}


$pdf->Output("D",$level."_".$module."_".$evaluation."_notes.pdf");

$connexion = null;
} catch (PDOException $e) {
  echo "Erreur ! " . $e->getMessage() . "<br/>";
}

}

?>