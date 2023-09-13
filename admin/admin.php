<?php session_start();

include '../database.php';

if(!(isset($_SESSION['ad_id']))){
    header("Location:index.php");
    exit();
}
else{

try{
    $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
    $req = "SELECT count(*) FROM etudiants where email <> ''";
    $res = $connexion->query($req);
    $users = $res->fetch(PDO::FETCH_ASSOC)['count(*)'];

    $req1 = "SELECT count(*) FROM modules where 1";
    $res1 = $connexion->query($req1);
    $modules = $res1->fetch(PDO::FETCH_ASSOC)['count(*)'];

    $req2 = "SELECT count(*) FROM enseignants where 1";
    $res2 = $connexion->query($req2);
    $teachers = $res2->fetch(PDO::FETCH_ASSOC)['count(*)'];

    $req3 = "SELECT count(*) FROM admin where 1";
    $res3 = $connexion->query($req3);
    $admin = $res3->fetch(PDO::FETCH_ASSOC)['count(*)'];
$connexion = null;
}catch (PDOException $e) {
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
    <title>Admin Deshboard</title>
    <link rel="stylesheet" href="CSS/admin.css">
</head>

<body>


<header class="tete">
    <div class="logo">
        <a href="#"><img src="../images/logo-en 1.svg" alt=""  height="80px" id="logo"></a>
    </div>
    <div class="uni-name">
        <h1>UNIVERSITY OF TLEMCEN</h1>
        <h3>FACULTY OF SCIENCES</h3>
        <h2>DEPARTMENT OF COMPUTER SCIENCE</h2>
    </div>
    <div class="profile-icon">
            <img src="../images/th (1).jpg" alt="" width="70px" height="70px" id="prof-pic">
        
        <p id="profile"><a href="logout.php">LOGOUT</a></p>
    </div>
    
</header>

<?php 
                 if(isset($_GET['msg']))
                    $msg = $_GET['msg'];
                else
                    $msg = "";

                 echo'<p style="margin-top: 30px; display: block; color: green; margin-top: 30px;">'.$msg.' </p>'
             ?>

<div class="main-side">

        <div   class="options">

            <div><a href="Creer_Module.php">CREER MODULES</a></div>
            <div><a href="gerer_module.php">GERER MODULES</a></div>
            <div><a href="Ajouter_Enseignant.php">AJUTER ENSEIGNANT</a></div>
            <div><a href="delete.php">SUPPRIMER ENSEIGNANT</a></div>
            <div><a href="imprimer_releve.php">IMPRIMER RELEVE</a></div>
            <div><a href="change_password.php">CHANGE MOT DE PASSE</a></div>
         </div>

    <div  class="modules"> 
        <div class="div">
            <H2><?php echo $users; ?></H2>
            <p>Registered Students</p>
        </div>

        <div class="div">
            <H2><?php echo $modules; ?></H2>
            <p>Listed Modules</p>
        </div>

        <div class="div">
            <H2><?php echo $teachers; ?></H2>
            <p>Registered Teachers</p>

        </div>

        <div class="div">
            <H2><?php echo $admin; ?></H2>
            <p>Admin Users</p>

        </div>

       
   </div>

</div>




<div class="footer">
    <p id="one">Universite de Tlemcen 2022</p>
    <p id="two">admin@univ-tlemcen.dz</p>
</div>


    

</body>
</html>