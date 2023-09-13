<?php

    session_start();

    include '../database.php';

    $login = $_POST['login'];
    $mdp = $_POST['mdp'];
    $nmdp = $_POST['nmdp'];
    $nmdp1 = $_POST['nmdp1'];


if(!(isset($_SESSION['ad_id']))){
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
        $req = "SELECT * FROM admin where login = '".$login."'";
        $res = $connexion->query($req);
        
        if($res->rowCount() == 0){
            $msg = "This login does not have account!";
            header("Location:change-password.php?msg=".$msg."");
        }
        else{
             if($mdp != $res->fetch(PDO::FETCH_ASSOC)['mdp']){
                $msg = "Enter correct old password!";
                header("Location:change-password.php?msg=".$msg."");
             }

             else{
                $req1 = "UPDATE admin set mdp = '".$nmdp."' where login = '".$login."'";
                $connexion->exec($req1);

                session_destroy();
                header("Location:index.php?&msg=YOU CHANGED YOUR PASSWORD!");
                exit();

             }
        }
        

        $connexion = null;
        }catch (PDOException $e) {
        echo "Erreur ! " . $e->getMessage() . "<br/>";
        }
    }
}
     
?>