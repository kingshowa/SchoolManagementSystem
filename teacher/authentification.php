<?php

session_start();

include '../database.php';

$login = $_POST['login'];
$mdp = $_POST['mdp'];

try{
    $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
    $req = "SELECT * FROM enseignants where num_enseignant = '".$login."'";
    $res = $connexion->query($req);

    if($res->rowCount() == 0){
        $msg = "Numero eseignant n`existe pas!";
        header("Location:index.php?msg=".$msg."");
    }
    else{
         if(!(password_verify($mdp, $res->fetch(PDO::FETCH_ASSOC)['mdp']))){
            $msg = "Wrong password, try again!";
            header("Location:index.php?msg=".$msg."");
        }

        else{
         $req1 = "SELECT * FROM enseignants where num_enseignant = '".$login."'";
         $res1 = $connexion->query($req1);

         $id = $res1->fetch(PDO::FETCH_ASSOC)['num_enseignant'];

         $_SESSION['id'] = $id;

         header("Location:teacher.php");
     }
 }

$connexion = null;
}catch (PDOException $e) {
    echo "Erreur ! " . $e->getMessage() . "<br/>";
}

?>