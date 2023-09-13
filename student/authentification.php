<?php

session_start();

include '../database.php';

$num_etudiant = $_POST['num_etudiant'];
$mdp = $_POST['mdp'];

try{
    $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
    $req = "SELECT * FROM etudiants where numero_etudiant = '".$num_etudiant."'";
    $res = $connexion->query($req);

    if($res->rowCount() == 0){
        $msg = "Numero etudiant n`existe pas!";
        header("Location:../index.php?msg=".$msg."");
    }
    else{
        $student = $res->fetch(PDO::FETCH_ASSOC);
        if($student['email']==""){
            $msg = "Compte n`existe pas! Creer un compte";
            header("Location:../index.php?msg=".$msg."");
        }
        else{
            if(!(password_verify($mdp, $student['mdp']))){
                $msg = "Wrong password, try again!";
                header("Location:../index.php?msg=".$msg."");
            }

            else{
               $req1 = "SELECT * FROM etudiants where numero_etudiant = '".$num_etudiant."'";
               $res1 = $connexion->query($req1);

               $id = $res1->fetch(PDO::FETCH_ASSOC)['numero_etudiant'];

               $_SESSION['et_id'] = $id;

               header("Location:../student/student_notes.php");
       }
   }
}
$connexion = null;
}catch (PDOException $e) {
    echo "Erreur ! " . $e->getMessage() . "<br/>";
}

?>