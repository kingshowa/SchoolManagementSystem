<?php session_start();


include '../database.php';

$num_etudiant = $_POST['num_etudiant'];
//$level = $_POST['level'];

if(!(isset($_SESSION['ad_id']))){
  header("Location:index.php");
}
else{

  try{
    $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
    $requete_sql = "SELECT * from etudiants where numero_etudiant = '".$num_etudiant."'";
    $result = $connexion->query($requete_sql);
    if($result->rowCount()==0)
       header("Location:imprimer_releve.php?msg=NUMERO ETUDIANT N`EXISTE PAS!");

    $student = $result->fetch(PDO::FETCH_ASSOC);
    $specialite = $student['specialite'];
    $nom = $student['nom_etudiant'];
    $prenom = $student['prenom_etudiant'];
    $dob = $student['date_naissance'];
    $current_level = $student['niveau'];

    $current_sem1 = (intval($current_level[1])*2)-1;
    $current_sem2 = intval($current_level[1])*2;
    


    $connexion = null;
  } catch (PDOException $e) {
    echo "Erreur ! " . $e->getMessage() . "<br/>";
  }




  require("../teacher/FPDF/fpdf.php");
  $pdf = new FPDF();

  $pdf-> AddPage('L');
  $pdf->Image('../images/logo-en.png', 273, 7,15,22);
  $pdf->SetFont("Arial","B",9);

  $pdf->Cell(80,4,"Republique Algerienne Democratique et Populaire",0,1);
  $pdf->Cell(80,4,"Ministere de l`enseignant Superieur et de la Rechercher Scientifique",0,1);
  $pdf->Cell(80,4,"Universite de Tlemcen",0,1);
  $pdf->Cell(80,4,"Faculte des Sciences",0,1);
  $pdf->Cell(80,4,"Department d`Informatique",0,1);

  $pdf->Cell(278,0,"",1,1);

  $pdf->SetFont("Arial","B",15);

  $pdf->Cell(120,10,"",0,0);
  $pdf->Cell(100,10," RELEVE DE NOTES",0,1);

  $pdf->SetFont("Arial","",10);

  $pdf->Cell(100,5,"Anee Academique: 2021/2022",0,1);
  $pdf->Cell(100,5,"Nom: ".$nom,0,0);
  $pdf->Cell(100,5,"Prenom: ".$prenom,0,0);
  $pdf->Cell(100,5,"Ne le: ".$dob,0,1);
  $pdf->Cell(100,5,"No d`Inscription: ".$num_etudiant,0,0);
  $pdf->Cell(100,5,"Niveau: Licence 3eme Annee",0,1);
  $pdf->Cell(100,5,"Domaine: Mathematique et Informatique",0,0);
  $pdf->Cell(100,5,"Filiere: Informatique",0,1);
  $pdf->Cell(100,5,"Specialite: Systemes Informatiques",0,1);
  $pdf->Cell(100,5,"Diplome prepare: Licence",0,1);

  $pdf->SetFont("Arial","",9);

  $pdf->Cell(278,5,"                                                                                                          Matiere(s)",1,1);
  $pdf->Cell(58,5,"Code Module",1,0);
  $pdf->Cell(120,5,"Intitule(s)",1,0);
  $pdf->Cell(20,5,"Credits",1,0);
  $pdf->Cell(20,5,"Coeff.",1,0);
  $pdf->Cell(20,5,"Moyenne",1,0);
  $pdf->Cell(20,5,"Credits",1,0);
  $pdf->Cell(20,5,"Sess.",1,1);
  
  $moyTotal = 0;
  $credTotal = 0;
  
  $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
  $requete_sql = "SELECT * from modules where niveau = '".$current_level."' and semester =".$current_sem1." and specialite = '".$specialite."'";
  $result = $connexion->query($requete_sql);

  $fail = 0;
  $moyenneSem = 0;
  $sumCoeff = 0;

  while($tuple = $result->fetch(PDO::FETCH_ASSOC)){

    

    $pdf->Cell(58,5,"".strtoupper($tuple["code_module"]),1,0);
    $pdf->Cell(120,5,"".$tuple["nom_module"],1,0);
    $pdf->Cell(20,5,"".$tuple["credit"],1,0);
    $pdf->Cell(20,5,"".$tuple["coef"],1,0);

    $cred = $tuple['credit'];
    $session = "N";

    

    $sumCoeff += $tuple["coef"];

    /*get TP*/

    $req1 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$num_etudiant."' and tp <> 'NULL'";
    $res1 = $connexion->query($req1);

    if($res1->rowCount()==0)
      $tp = NULL;
    else
      while($tps = $res1->fetch(PDO::FETCH_ASSOC))
        $tp = $tps['tp'];


      /*get CC*/

      $req2 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$num_etudiant."' and cc <> 'NULL'";
      $res2 = $connexion->query($req2);

      if($res2->rowCount()==0)
        $cc = NULL;
      else
        while($ccs = $res2->fetch(PDO::FETCH_ASSOC))
          $cc = $ccs['cc'];

        /*get EXAM*/

        $req3 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$num_etudiant."' and examen <> 'NULL'";
        $res3 = $connexion->query($req3);
        
        if($res3->rowCount()==0)
          $examen = NULL;
        else
          while($examens = $res3->fetch(PDO::FETCH_ASSOC))
            $examen = $examens['examen'];

          /*get ratrapage*/

          $req4 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$num_etudiant."' and ratrapage <> 'NULL'";
          $res4 = $connexion->query($req4);

          if($res4->rowCount()==0)
            $ratrapage = NULL;
          else{
            while($ratrapages = $res4->fetch(PDO::FETCH_ASSOC))
              $ratrapage = $ratrapages['ratrapage'];
            $session = "R";
          }

          /*get moyenne*/

          $req5 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$num_etudiant."' and moyenne <> 'NULL'";
          $res5 = $connexion->query($req5);

          if($res5->rowCount()==0)
            $moyenne = NULL;
          else
            while($moyennes = $res5->fetch(PDO::FETCH_ASSOC))
              $moyenne = $moyennes['moyenne'];


            $moy = 0;
            if($tp != NULL && $cc != NULL && $ratrapage != NULL)
              $moy = $tp*0.2 + $cc*0.2 + $ratrapage*0.6;
            else if($tp != NULL && $cc != NULL && $examen != NULL)
              $moy = $tp*0.2 + $cc*0.2 + $examen*0.6;
            else if($tp != NULL && $ratrapage != NULL)
              $moy = $tp*0.4 + $ratrapage*0.6;
            else if($tp != NULL && $examen != NULL)
              $moy = $tp*0.4 + $examen*0.6;
            else if($cc != NULL && $ratrapage != NULL)
              $moy = $cc*0.4 + $ratrapage*0.6;
            else if($cc != NULL && $examen != NULL)
              $moy = $cc*0.4 + $examen*0.6;
            else if($ratrapage != NULL)
              $moy = $ratrapage;
            else if($examen != NULL)
              $moy = $examen;
            else if($tp != NULL)
              $moy = $tp;
            else if($cc != NULL)
              $moy = $cc;

            $pdf->Cell(20,5,"".number_format($moy, 2),1,0);

            if($moy < 10){
              $fail = $fail + $tuple["credit"];
              $cred = 0;
            }

            $pdf->Cell(20,5,"".$cred,1,0);
            $pdf->Cell(20,5,"".$session,1,1);

            $moyenneSem += $moy*$tuple["coef"];
            $moyTotal = number_format($moy,2);


          }

          if($result->rowCount())
            $creditSem = 30-$fail;
          else
            $creditSem = 0;
          $credTotal += $creditSem;

          if($sumCoeff != 0)
            $moySemester = $moyenneSem/$sumCoeff;
          else
            $moySemester = 0;

          
          
          
          
          $pdf->Cell(278,5,"                                                  Moyenne de semestre ".$current_sem1.": ".number_format($moySemester,2)."                                            Credit de semestre ".$current_sem1.": ".$creditSem."                                                  Session: ".$session,1,1);


// Second semester code



          $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
          $requete_sql = "SELECT * from modules where niveau = '".$current_level."' and semester =".$current_sem2." and specialite = '".$specialite."'";
          $result = $connexion->query($requete_sql);

          $fail = 0;
          $moyenneSem = 0;
          $sumCoeff = 0;

          while($tuple = $result->fetch(PDO::FETCH_ASSOC)){

            

            $pdf->Cell(58,5,"".strtoupper($tuple["code_module"]),1,0);
            $pdf->Cell(120,5,"".$tuple["nom_module"],1,0);
            $pdf->Cell(20,5,"".$tuple["credit"],1,0);
            $pdf->Cell(20,5,"".$tuple["coef"],1,0);

            $cred = $tuple['credit'];
            $session = "N";

            

            $sumCoeff += $tuple["coef"];

            /*get TP*/

            $req1 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$num_etudiant."' and tp <> 'NULL'";
            $res1 = $connexion->query($req1);

            if($res1->rowCount()==0)
              $tp = NULL;
            else
              while($tps = $res1->fetch(PDO::FETCH_ASSOC))
                $tp = $tps['tp'];


              /*get CC*/

              $req2 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$num_etudiant."' and cc <> 'NULL'";
              $res2 = $connexion->query($req2);

              if($res2->rowCount()==0)
                $cc = NULL;
              else
                while($ccs = $res2->fetch(PDO::FETCH_ASSOC))
                  $cc = $ccs['cc'];

                /*get EXAM*/

                $req3 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$num_etudiant."' and examen <> 'NULL'";
                $res3 = $connexion->query($req3);
                
                if($res3->rowCount()==0)
                  $examen = NULL;
                else
                  while($examens = $res3->fetch(PDO::FETCH_ASSOC))
                    $examen = $examens['examen'];

                  /*get ratrapage*/

                  $req4 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$num_etudiant."' and ratrapage <> 'NULL'";
                  $res4 = $connexion->query($req4);

                  if($res4->rowCount()==0)
                    $ratrapage = NULL;
                  else{
                    while($ratrapages = $res4->fetch(PDO::FETCH_ASSOC))
                      $ratrapage = $ratrapages['ratrapage'];
                    $session = "R";
                  }

                  /*get moyenne*/

                  $req5 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$num_etudiant."' and moyenne <> 'NULL'";
                  $res5 = $connexion->query($req5);

                  if($res5->rowCount()==0)
                    $moyenne = NULL;
                  else
                    while($moyennes = $res5->fetch(PDO::FETCH_ASSOC))
                      $moyenne = $moyennes['moyenne'];


                    $moy = 0;
                    if($tp != NULL && $cc != NULL && $ratrapage != NULL)
                      $moy = $tp*0.2 + $cc*0.2 + $ratrapage*0.6;
                    else if($tp != NULL && $cc != NULL && $examen != NULL)
                      $moy = $tp*0.2 + $cc*0.2 + $examen*0.6;
                    else if($tp != NULL && $ratrapage != NULL)
                      $moy = $tp*0.4 + $ratrapage*0.6;
                    else if($tp != NULL && $examen != NULL)
                      $moy = $tp*0.4 + $examen*0.6;
                    else if($cc != NULL && $ratrapage != NULL)
                      $moy = $cc*0.4 + $ratrapage*0.6;
                    else if($cc != NULL && $examen != NULL)
                      $moy = $cc*0.4 + $examen*0.6;
                    else if($ratrapage != NULL)
                      $moy = $ratrapage;
                    else if($examen != NULL)
                      $moy = $examen;
                    else if($tp != NULL)
                      $moy = $tp;
                    else if($cc != NULL)
                      $moy = $cc;

                    $pdf->Cell(20,5,"".number_format($moy, 2),1,0);

                    if($moy < 10){
                      $fail = $fail + $tuple["credit"];
                      $cred = 0;
                    }

                    $pdf->Cell(20,5,"".$cred,1,0);
                    $pdf->Cell(20,5,"".$session,1,1);

                    $moyenneSem += $moy*$tuple["coef"];
                    $moyTotal += number_format($moy,2);
                    $moyTotal /= 2;

                  }

                  if($result->rowCount())
                    $creditSem = 30-$fail;
                  else
                    $creditSem = 0;
                  $credTotal += $creditSem;

                  if($sumCoeff != 0)
                    $moySemester = $moyenneSem/$sumCoeff;
                  else
                    $moySemester = 0;

                  
                  
                  
                  
                  $pdf->Cell(278,5,"                                                  Moyenne de semestre ".$current_sem2.": ".number_format($moySemester,2)."                                            Credit de semestre ".$current_sem2.": ".$creditSem."                                                  Session: ".$session,1,1);

//validation of the yr

    if($moyTotal>=10 || $credTotal>=30){
      if($current_level == "L1")
         $current_level = "L2";
      else if($current_level == "L2")
         $current_level = "L3";
      else if($current_level == "L3")
         $current_level = "M1";
      else if($current_level == "M1")
         $current_level = "M2";
      $reqq="UPDATE etudiants SET niveau = '".$current_level."' WHERE numero_etudiant = '".$num_etudiant."'";
      $ress=$connexion->exec($reqq);
    }
                  

                  $pdf->Cell(100,5,"",0,1);
                  $pdf->Cell(100,5,"N: Session Normale     R: Session Rattrapage",0,1);
                  $pdf->Cell(100,5,"Moyene:    ".number_format($moyTotal,2),0,0);
                  $pdf->Cell(100,5,"Totale des credits cumulee pour annee:  ".$credTotal,0,0);
  //$pdf->Cell(100,5,"Totale des credits cumulee dans le cursus:  120",0,1);
                  $pdf->Cell(100,5,"Decision: Admis(e) session normale",0,1);
                  $pdf->Cell(100,5,"",0,0);
                  $pdf->Cell(100,5,"Chef de department",0,0);
                  $pdf->Cell(100,5,"Le: ".date('d-m-Y'),0,1);


                  $pdf->Output("","releve_notes.pdf");

                }

?>