<?php session_start();  
include '../database.php';

if(!(isset($_SESSION['id']))){
    header("Location:index.php");
}
else{

if(isset($_POST['module']))
    $modulee = $_POST['module'];
else
    $modulee = $_GET['module'];
if(isset($_POST['evaluation']))
    $evaluation = $_POST['evaluation'];
else
    $evaluation = $_GET['evaluation'];

try{
  $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
  $requete_sql = "SELECT * from modules where code_module = '".$modulee."'";
  $result = $connexion->query($requete_sql);

  $modules = $result->fetch(PDO::FETCH_ASSOC);
  $level = $modules['niveau'];
  $module = $modules['nom_module'];

  $requete_sql1 = "SELECT * from enseignants where num_enseignant = '".$_SESSION['id']."'";
  $result1 = $connexion->query($requete_sql1);

  $pic = $result1->fetch(PDO::FETCH_ASSOC)['profile_picture'];

  $connexion = null;
} catch (PDOException $e) {
  echo "Erreur ! " . $e->getMessage() . "<br/>";
}

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Notes</title>
    <link rel="stylesheet" href="CSS/ajouter_notes1.css">


</head>
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
            <p id="profile"><a href="tr_info.php">PROFILE</a></p>
        </div>

    </header>

    <?php 
                 if(isset($_GET['msg']))
                    $msg = $_GET['msg'];
                else
                    $msg = "";

                 echo'<p style="margin-top: 30px; display: block; color: green; margin-top: 30px;">'.$msg.' </p>'
             ?>

    <!---------the main part showing semseters and modules-->
    <div class="main-side">

        <div   class="options">
            <a href="teacher.php"><div>DASHBOARD</div></a>
            <a href="#" id="active"><div>AJOUTER NOTES</div></a>
            <a href="Imprimer_Notes.php"><div>AFFICHER NOTES</div></a>
            <a href="tr_info.php"><div>MON PROFIL</div></a>
            <a href="change_password.php"><div>CHANGE MOT DE PASSE</div></a>
            <a href="logout.php"><div>LOGOUT</div></a>
        </div>

        <!-------table showing the details of every module-->

        <div class="table">
         <div class="top-section">
            <?php  
            echo '<h3 class="module">'.$module.' '.strtoupper($evaluation).' '.$level.'</h3>';
            ?>
            <div id="search-bar">
                <input type="text" name="" id="search-input" oninput="tableSearch();">
                <span id="search-button" onclick="tableSearch();">SEARCH</span>
            </div>
        </div>
        <table id="search-table">
         <thead> 
             <th>NOM</th>
             <th>PRENOM</th>
             <th>NUM ETUDIANT</th>
             <?php echo ' <th>NOTE '.strtoupper($evaluation).'</th>';?>
         </thead>

         <?php 

         try{
          $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
          $req = "SELECT * from etudiants where niveau = '".$level."'";
          $res = $connexion->query($req);

          while($tuple = $res->fetch(PDO::FETCH_ASSOC)){

            $requete_sql2 = "SELECT * from notes where code_module = '".$modulee."' and numero_etudiant = '".$tuple["numero_etudiant"]."' and ".$evaluation." <> 'NULL'";
            $result2 = $connexion->query($requete_sql2);

            if($result2->rowCount()==0)
                $value = NULL;
            else
            while($values = $result2->fetch(PDO::FETCH_ASSOC))
                $value = $values[$evaluation]; 
                

            echo '<tr>  
            <td>'.$tuple["nom_etudiant"].'</td>
            <td>'.$tuple["prenom_etudiant"].'</td>
            <form action="submit_note.php?module='.$modulee.'&evaluation='.$evaluation.'" method="POST">
            <td><input type="text" name="num_etudiant" value="'.$tuple["numero_etudiant"].'" readonly class="num"></td>
            <td>

            <input type="number" name="mark" class="mark" placeholder="" value="'.$value.'" step="any" min="0.00" max="20.00" required>
            <button type="submit" class="done">DONE</button>

            </td>
            </form>
            </tr>';
            $value = NULL;
        }

        $connexion = null;
    } catch (PDOException $e) {
      echo "Erreur ! " . $e->getMessage() . "<br/>";
  }
  ?>

</table>
</div>
</div>

<?php 
                 if(isset($_GET['msg']))
                    $msg = $_GET['msg'];
                else
                    $msg = "";

                 echo'<p style="margin-top: 30px; display: block; color: red; margin-top: 30px;">'.$msg.' </p>'
             ?>


<!--------start of footer-->

<div class="footer">
    <p id="one">Universite de Tlemcen 2022</p>
    <p id="two">admin@univ-tlemcen.dz</p>
</div>

</body>

<script type="text/javascript" src="search_student.js"></script>
</html>

