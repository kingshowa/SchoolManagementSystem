<?php session_start();

if(!(isset($_SESSION['ad_id']))){
    header("Location:index.php");
    exit();
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Teacher</title>
    <link rel="stylesheet" href="CSS/delete.css">
</head>

<body>


<header class="tete">
    <div class="logo">
        <a href="admin.php"><img src="../images/logo-en 1.svg" alt=""  height="80px" id="logo"></a>
    </div>
    <div class="uni-name">
        <h1>UNIVERSITY OF TLEMCEN</h1>
        <h3>FACULTY OF SCIENCES</h3>
        <h2>DEPARTMENT OF COMPUTER SCIENCE</h2>
    </div>
    <div class="profile-icon">
            <img src="../images/th (1).jpg" alt="" width="70px" height="70px" id="prof-pic">
        
        <p id="profile">LOGOUT</p>
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
        <div   class="options">

            <div><a href="Creer_Module.php">CREER MODULES</a></div>
            <div><a href="gerer_module.php">GERER MODULES</a></div>
            <div><a href="Ajouter_Enseignant.php">AJUTER ENSEIGNANT</a></div>
            <div><a href="#" id="active">SUPPRIMER ENSEIGNANT</a></div>
            <div><a href="imprimer_releve.php">IMPRIMER RELEVE</a></div>
            <div><a href="change_password.php">CHANGE MOT DE PASSE</a></div>
         </div>


         <div class="delete-div">
             <div class="code"><p>CODE ENSEIGNANT :</p></div>
             <div class="diva">
                 <form action="delete_tr.php" method="post">
                     <input type="text" name="code_enseignant" required>
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