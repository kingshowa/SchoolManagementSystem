<?php

session_start();

include '../database.php';

$code = $_POST['code'];
$mdp = $_POST['mdp'];


try{
    $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
    $req = "SELECT * FROM admin where login = '".$code."'";
    $res = $connexion->query($req);

    if($res->rowCount() == 0){
        $msg = "Login n`est pas correcte!";
        header("Location:index.php?msg=".$msg."");
    }
    else{
        
        if($mdp != $res->fetch(PDO::FETCH_ASSOC)['mdp']){
            $msg = "Wrong password, try again!";
            header("Location:index.php?msg=".$msg."");
        }

        else{

         $_SESSION['ad_id'] = $code;

         header("Location:admin.php");
     }
 }
$connexion = null;
}catch (PDOException $e) {
    echo "Erreur ! " . $e->getMessage() . "<br/>";
}

?>