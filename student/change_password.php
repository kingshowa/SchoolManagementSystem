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
    <title>Change Password</title>
    <link rel="stylesheet" href="../admin/CSS/delete.css">
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

                 echo'<p style="margin-top: 30px; display: block; color: red; margin-top: 30px;">'.$msg.' </p>'
             ?>


    <div class="main-side">
        <div   class="options" name="">
            <!--<a href="teacher.php"><div>DASHBOARD</div></a>
            <a href="ajouter_Notes.php"><div>AJOUTER NOTES</div></a>
            <a href="Imprimer_Notes.php"><div>AFFICHER NOTES</div></a>
            <a href="tr_info.php"><div>MON PROFINE</div></a>
            <a href="#" id="active"><div>CHANGE MOT DE PASSE</div></a>
            <a href="logout.php"><div>LOGOUT</div></a>-->
        </div>


        <div class="delete-div">
           <div class="code">
            <p>MOT DE PASSE :</p>
            <p>NEW PASSWORD :</p>
            <p>CONFIRM PASSWORD :</p>
        </div>


        <div class="diva">
           <form action="new-password.php" method="post">
               <input type="password" name="mdp" required autocomplete="new-password">
               <input type="password" name="nmdp" required autocomplete="new-password"> 
               <input type="password" name="nmdp1" required autocomplete="new-password">
              <button type="submit">PROCEED</button>
          </form>
      </div>
  </div>

</div>




<div class="footer">
    <p id="one">Universite de Tlemcen 2022</p>
    <p id="two">admin@univ-tlemcen.dz</p>
</div>




</body>
</html>