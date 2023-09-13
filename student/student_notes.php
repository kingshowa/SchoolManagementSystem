<?php session_start();

include '../database.php';

if(!(isset($_SESSION['et_id']))){
    header("Location:../index.php");
}
else{

  try{
      $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
      $requete_sql = "SELECT * from etudiants where numero_etudiant = '".$_SESSION['et_id']."'";
      $result = $connexion->query($requete_sql);
      $student = $result->fetch(PDO::FETCH_ASSOC);
      $pic = $student['profile_picture'];
      $specialite = $student['specialite'];
      $current_level = $student['niveau'];

      if(date('m')>=2 && date('m')<=6)
        $current_sem = intval($current_level[1])*2;
    else
        $current_sem = (intval($current_level[1])*2)-1;


    $connexion = null;
} catch (PDOException $e) {
  echo "Erreur ! " . $e->getMessage() . "<br/>";
}
}

if(!(isset($_GET['sem'])) && !(isset($_GET['level']))){
    $sem = $current_sem;
    $level = $current_level;
}
else{
    $sem = $_GET['sem'];
    $level = $_GET['level'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Results</title>
    <link rel="stylesheet" href="CSS/student_notes.css">


</head>

<?php 
$l=strtolower($level)[0];
$n=$sem;

echo '
<style type="text/css">
    #'.$l.'sem'.$n.'{
        background-color: white;
        color: darkblue;
    } </style>


';
?>


<body>

    <header class="tete">
        <div class="logo">
            <img src="../images/logo-en 1.svg" alt=""  height="80px" id="logo">
        </div>
        <div class="uni-name">
            <h1>UNIVERSITY OF TLEMCEN</h1>
            <h3>FACULTY OF SCIENCES</h3>
            <h2>DEPARTMENT OF COMPUTER SCIENCE</h2>
        </div>
        <div class="profile-icon">
            <?php  
            echo '<img src="../images/'.$pic.'" alt="" width="70px" height="70px" id="prof-pic">';
            ?>
            <p id="profile"><a href="studinfo.php">PROFILE</a></p>
        </div>

    </header>

    <!---------the main part showing semseters and modules-->
    <div class="main-side">

        <!-----table showing the semesters of every level-->
        <div class="niveau">
         <div class="license deg">
             <h4>License</h4>
         </div>
         <div class="semestre-license sem">
             <a href="student_notes.php?sem=1&level=L1"><div id="lsem1"><p>Semestre 1</p></div></a>
             <a href="student_notes.php?sem=2&level=L1"><div id="lsem2"><p>Semestre 2</p></div></a>
             <a href="student_notes.php?sem=3&level=L2"><div id="lsem3"><p>Semestre 3</p></div></a>
             <a href="student_notes.php?sem=4&level=L2"><div id="lsem4"><p>Semestre 4</p></div></a>
             <a href="student_notes.php?sem=5&level=L3"><div id="lsem5"><p>Semestre 5</p></div></a>
             <a href="student_notes.php?sem=6&level=L3"><div id="lsem6"><p>Semestre 6</p></div></a>
         </div>
         <div class="master deg">
             <h4>Masters</h4>
         </div>
         <div class="semestre-master sem">
            <a href="student_notes.php?sem=1&level=M1"><div id="msem1"><p>Semestre 1</p></div></a>
            <a href="student_notes.php?sem=2&level=M1"><div id="msem2"><p>Semestre 2</p></div></a>
            <a href="student_notes.php?sem=3&level=M2"><div id="msem3"><p>Semestre 3</p></div></a>
            <a href="student_notes.php?sem=4&level=M2"><div id="msem4"><p>Semestre 4</p></div></a>
        </div>
    </div>


    <div class="table">
     <table>
         <thead>
             <th>Module</th>
             <th>Coefficient</th>
             <th>Credit</th>
             <th>TP</th>
             <th>Control</th>
             <th>Examen</th>
             <th>Ratrapage</th>
             <th>Moyenne</th>
         </thead>

         <?php 

         try{
          $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
          $requete_sql = "SELECT * from modules where niveau = '".$level."' and semester =".$sem." and specialite = '".$specialite."'";
          $result = $connexion->query($requete_sql);

          $fail = 0;
          $moyenneSem = 0;
          $sumCoeff = 0;

          while($tuple = $result->fetch(PDO::FETCH_ASSOC)){

            echo '<tr>
            <td>'.$tuple["nom_module"].'</td>
            <td>'.$tuple["coef"].'</td>
            <td>'.$tuple["credit"].'</td>';

            $sumCoeff += $tuple["coef"];

                    /*get TP*/

            $req1 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$_SESSION['et_id']."' and tp <> 'NULL'";
            $res1 = $connexion->query($req1);

            if($res1->rowCount()==0)
                $tp = NULL;
            else
                while($tps = $res1->fetch(PDO::FETCH_ASSOC))
                    $tp = $tps['tp'];
                echo '<td>'.$tp.'</td>';


                    /*get CC*/

                $req2 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$_SESSION['et_id']."' and cc <> 'NULL'";
                $res2 = $connexion->query($req2);

                if($res2->rowCount()==0)
                    $cc = NULL;
                else
                    while($ccs = $res2->fetch(PDO::FETCH_ASSOC))
                        $cc = $ccs['cc'];
                    echo '<td>'.$cc.'</td>';

                    /*get EXAM*/

                    $req3 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$_SESSION['et_id']."' and examen <> 'NULL'";
                    $res3 = $connexion->query($req3);
                    
                    if($res3->rowCount()==0)
                        $examen = NULL;
                    else
                        while($examens = $res3->fetch(PDO::FETCH_ASSOC))
                            $examen = $examens['examen'];
                        echo '<td>'.$examen.'</td>';

                    /*get ratrapage*/

                        $req4 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$_SESSION['et_id']."' and ratrapage <> 'NULL'";
                        $res4 = $connexion->query($req4);

                        if($res4->rowCount()==0)
                            $ratrapage = NULL;
                        else
                            while($ratrapages = $res4->fetch(PDO::FETCH_ASSOC))
                                $ratrapage = $ratrapages['ratrapage'];
                            echo '<td>'.$ratrapage.'</td>';

                    /*get moyenne*/

                            $req5 = "SELECT * from notes where code_module = '".$tuple['code_module']."' and numero_etudiant ='".$_SESSION['et_id']."' and moyenne <> 'NULL'";
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

                                echo '<td>'.number_format($moy, 2).'</td>';

                                if($moy < 10)
                                    $fail = $fail + $tuple["credit"];

                                $moyenneSem += $moy*$tuple["coef"];

                            }

                            if($result->rowCount())
                                $creditSem = 30-$fail;
                            else
                                $creditSem = 0;

                            if($sumCoeff != 0)
                                $moySemester = $moyenneSem/$sumCoeff;
                            else
                                $moySemester = 0;

                            $connexion = null;
                        } catch (PDOException $e) {
                          echo "Erreur ! " . $e->getMessage() . "<br/>";
                      }
                      if($moySemester >= 10)
                        $creditSem = 30;
                      ?>

                      <?php echo '           
                      <tr id="info">
                      <td colspan="4" id="credit"><b>Credit Du Semestre  '.$sem.': <span id="cred">'.$creditSem.'</span></b></td>
                      <td colspan="4" id="coeff"><b>Moyenne Du Semestre '.$sem.': <span id="moy">'.number_format($moySemester, 2).'</span> </b></td>
                      </tr>
                      '; ?>


                  </table>
              </div>



          </div>

          <!--------start of footer-->

          <div class="footer">
            <p id="one">Universite de Tlemcen 2022</p>
            <p id="two">admin@univ-tlemcen.dz</p>
        </div>

    </body>
    </html>