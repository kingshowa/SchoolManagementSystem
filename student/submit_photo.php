<?php session_start();


include '../database.php';

$pic = $_FILES["pic"]["name"];
$tempname = $_FILES["pic"]["tmp_name"];    
$folder = "../images/".$pic;

if(!(isset($_SESSION['et_id']))){
    header("Location:../index.php");
}
else{


    try {
        $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);

        $req = "UPDATE etudiants SET profile_picture = '".$pic."' WHERE numero_etudiant = '".$_SESSION['et_id']."'";
        $connexion->exec($req);
        
        if (move_uploaded_file($tempname, $folder))  {
            header("Location:studinfo.php");
        }
        $connexion = null;
    } catch (PDOException $e) {
        echo "Erreur ! " . $e->getMessage() . "<br/>";
    }
}
?>