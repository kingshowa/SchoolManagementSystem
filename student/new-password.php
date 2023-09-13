<?php

    session_start();

    include '../database.php';

    $mdp = $_POST['mdp'];
    $nmdp = $_POST['nmdp'];
    $nmdp1 = $_POST['nmdp1'];


if(!(isset($_SESSION['et_id']))){
    header("Location:index.php");
}
else{
    if($nmdp != $nmdp1){
        $msg = "New password is not matching!";
        header("Location:change_password.php?msg=".$msg."");
    }
    else{

    try{
        $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
        $req = "SELECT * FROM etudiants where numero_etudiant = '".$_SESSION['et_id']."'";
        $res = $connexion->query($req);
        
        
             if(!(password_verify($mdp, $res->fetch(PDO::FETCH_ASSOC)['mdp']))){
                $msg = "Enter correct old password!";
                header("Location:change_password.php?msg=".$msg."");
             }

             else{
                $req1 = "UPDATE etudiants SET mdp = '".$nmdp."' numero_etudiant = '".$_SESSION['et_id']."'";
                $connexion->exec($req1);

                session_destroy();
                header("Location:../index.php?&msg=YOU CHANGED YOUR PASSWORD!");
                exit();

             }
        

        $connexion = null;
        }catch (PDOException $e) {
        echo "Erreur ! " . $e->getMessage() . "<br/>";
        }
    }
}
     
?>