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

                  $nom = $student['nom_etudiant'];
                  $prenom = $student['prenom_etudiant'];
                  $dob = $student['date_naissance'];
                  $nationalite = $student['nationalite'];
                  $sex = $student['sexe'];


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

    $current_year = date("Y");
                  $previous_year = $current_year - 1;
                  $next_year = $current_year + 1;
                  if(date("m") < 7)
                    $accademic_year = $previous_year." - ".$current_year;
                  else
                    $accademic_year = $current_year." - ".$next_year;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Infomation</title>

    <link rel="stylesheet" href="CSS/studinfo.css">
</head>


<body>


    <header class="tete">
        <div class="logo">
            <img src="../images/logo-en 1.svg" alt="" height="80px">
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
            <p id="profile"><a href="logout.php">LOG OUT</a></p>
        </div>
        
    </header>

    <!---------end of tete-->

    <div class="main-side">
        <div class="profile">
            <div class="photo" style="width: 270px; height: 270px;">
        <?php  
            echo '<img src="../images/'.$pic.'" alt="Your Image" width="270px" height="270px">';
        ?>
            </div>
            <div class="click">
                <a href="upload_photo.php"><div class="change-photo">CHANGE PHOTO</div></a>
                <a href="change_password.php"><div class="pass">CHANGE PASSWORD</div></a>
            </div>
        </div>


        <div class="personal-info">
            <table>
                <thead>
                    <th colspan="2">PERSONAL INFORMATION</th>
                </thead>
<?php   echo '
                <tbody>
                    <tr>
                        <td>NOM DE FAMILLE</td>
                        <td>'.$nom.'</td>
                    </tr>

                    <tr>
                        <td>PRENOM</td>
                        <td>'.$prenom.'</td>
                    </tr>

                    <tr>
                        <td>DATE DE NAISANCE</td>
                        <td>'.$dob.'</td>
                    </tr>

                    <tr>
                        <td>NATIONALITE</td>
                        <td>'.$nationalite.'</td>
                    </tr>

                    <tr>
                        <td>SPECIALITE</td>
                        <td>'.$specialite.'</td>
                    </tr>

                    <tr>
                        <td>DOMAINE</td>
                        <td>INFORMATIQUE</td>
                    </tr>

                    <tr>
                        <td>ANNEE ACADEMIQUE</td>
                        <td>'.$accademic_year.'</td>
                    </tr>

                    <tr>
                        <td>NIVEAU</td>
                        <td>'.$level.'</td>
                    </tr>

                    <tr>
                        <td>NUMERO D`INSCRIPTION</td>
                        <td>'.$_SESSION["et_id"].'</td>
                    </tr>

                </tbody>
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