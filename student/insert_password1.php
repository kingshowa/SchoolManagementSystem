<?php 
    session_start();

    include '../database.php';

    $mdp = $_POST['mdp'];
    $mdp1 = $_POST['mdp1'];
    
    $id = $_GET['id'];
    $email = $_GET['email'];
    
    $error = 0;
  
    if($mdp != $mdp1){
        $msg = "Passwords are not matching, try again!";
        header("Location:insert_password.php?email=".$email."&id=".$id."&msg=".$msg."");
    }
    else{

        $pass = password_hash($mdp, PASSWORD_DEFAULT);

        try{
            $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);

            $requete_sql = "UPDATE etudiants SET email='".$email."', mdp='".$pass."' WHERE numero_etudiant='".$id."'";
            $connexion->exec($requete_sql);

            $msg = "You have successfully created your account! ";
            header("Location:../index.php?msg=".$msg."");

        $connexion = null;
        }catch (PDOException $e) {
        echo "Erreur ! " . $e->getMessage() . "<br/>";
        }
    }

     
?>