<?php session_start();


include '../database.php';

$pic = $_FILES["pic"]["name"];
$tempname = $_FILES["pic"]["tmp_name"];    
$folder = "../images/".$pic;

if(!(isset($_SESSION['id']))){
    header("Location:index.php");
}
else{


    try {
        $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);

        $req = "UPDATE enseignants SET profile_picture = '".$pic."' WHERE num_enseignant = '".$_SESSION['id']."'";
        $connexion->exec($req);
        
        if (move_uploaded_file($tempname, $folder))  {
            header("Location:tr_info.php");
        }
        $connexion = null;
    } catch (PDOException $e) {
        echo "Erreur ! " . $e->getMessage() . "<br/>";
    }
}
?>