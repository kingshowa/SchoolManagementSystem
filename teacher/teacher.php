<?php session_start();  
      include '../database.php';

    if(!(isset($_SESSION['id']))){
    header("Location:index.php");
    }
    else{

      try{
                  $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
                  $requete_sql = "SELECT * from enseignants where num_enseignant = '".$_SESSION['id']."'";
                  $result = $connexion->query($requete_sql);

                  $pic = $result->fetch(PDO::FETCH_ASSOC)['profile_picture'];

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
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="CSS/teacher.css">
</head>
<body>


<header class="tete">
    <div class="logo">
        <img src="../images/logo-en 1.svg"  height="80px" id="logo">
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



<div class="main-side">
        <div   class="options">
            <a href="#" id="active"><div>DASHBOARD</div></a>
            <a href="ajouter_notes.php"><div>AJOUTER NOTES</div></a>
            <a href="Imprimer_Notes.php"><div>AFFICHER NOTES</div></a>
            <a href="tr_info.php"><div>MON PROFIL</div></a>
            <a href="change_password.php"><div>CHANGE MOT DE PASSE</div></a>
            <a href="logout.php"><div>LOGOUT</div></a>
        </div>

        <div  class="modules"> 

                <?php 


                try{
                  $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
                  $requete_sql = "SELECT * from modules where num_enseignant = '".$_SESSION['id']."' ORDER BY coef DESC";
                  $result = $connexion->query($requete_sql);

                  if($result->rowCount()==0) echo '<h2>No modules you are teaching so far!</h2>';

                  $current_year = date("Y");
                  $previous_year = $current_year - 1;
                  $next_year = $current_year + 1;
                  if(date("m") < 7)
                    $accademic_year = $previous_year." - ".$current_year;
                  else
                    $accademic_year = $current_year." - ".$next_year;


                  while($tuple = $result->fetch(PDO::FETCH_ASSOC)){

                      echo '<div class="div">
                                <H2>'.$tuple["nom_module"].'</H2>
                                <p>'.strtoupper($tuple["niveau"]).'-'.$accademic_year.'</p>
                            </div>';

                  }

                  $connexion = null;
              } catch (PDOException $e) {
                  echo "Erreur ! " . $e->getMessage() . "<br/>";
              }


              ?>

          
    </div>

</div>




<div class="footer">
    <p id="one">Universite de Tlemcen 2022</p>
    <p id="two">admin@univ-tlemcen.dz</p>
</div>


    

</body>
</html>