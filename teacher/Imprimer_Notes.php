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
    <title>Imprimer notes</title>

    <link rel="stylesheet" href="../admin/CSS/delete.css">
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
            <p id="profile"><a href="tr_info.php">PROFILE</a></p>
        </div>
        
    </header>

    <!---------end of tete-->

    <div class="main-side">
        <div   class="options">
            <a href="teacher.php"><div>DASHBOARD</div></a>
            <a href="ajouter_notes.php"><div>AJOUTER NOTES</div></a>
            <a href="#" id="active"><div>AFFICHER NOTES</div></a>
            <a href="tr_info.php"><div>MON PROFIL</div></a>
            <a href="change_password.php"><div>CHANGE MOT DE PASSE</div></a>
            <a href="logout.php"><div>LOGOUT</div></a>
        </div>


        <div class="delete-div">
            <div class="code">
                <p>CODE MODULE :</p>
                <p>NOTE :</p>
            </div>


            <div class="diva">
               <form action="imprimer_notes1.php" method="post">

                <select name="module" required>
                 <option value=""> SELECT MODULE</option>
                 <?php 


                 try{
                  $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
                  $requete_sql = "SELECT * from modules where num_enseignant = '".$_SESSION['id']."'";
                  $result = $connexion->query($requete_sql);

                  while($tuple = $result->fetch(PDO::FETCH_ASSOC)){

                    echo '<option value="'.$tuple["code_module"].'">'.$tuple["nom_module"].'</option>';

                }

                $connexion = null;
            } catch (PDOException $e) {
              echo "Erreur ! " . $e->getMessage() . "<br/>";
          }


          ?>

      </select>

      <select name="evaluation" required>
          <option value=""> -TP/CONTROL/EXAMEN-</option>
          <option value="tp"> TP</option>
          <option value="cc"> CONTROL</option>
          <option value="examen"> EXAMEN</option>
          <option value="ratrapage"> RATRAPAGE</option>
      </select>
      <button type="submit">PROCEED</button>
  </form>
</div>
</div>

</div>









<!--------start of footer-->

<div class="footer">
    <p id="one">Universite de Tlemcen 2022</p>
    <p id="two">admin@univ-tlemcen.dz</p>
</div>


</body>
</html>