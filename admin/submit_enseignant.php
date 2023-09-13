<?php session_start();


include '../database.php';

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$code_enseignant = $_POST['code_enseignant'];
$sex = $_POST['sex'];
$dob = $_POST['dob'];
$mdp = $_POST['mdp'];
$mdp1 = $_POST['mdp1'];

$timestamp = strtotime($dob);
$date = date("Y-m-d", $timestamp);


if(!(isset($_SESSION['ad_id']))){
    header("Location:index.php?msg=");
}
else{
    if($mdp != $mdp1){
        $msg = "Passwords are not matching, try again!";
        header("Location:Ajouter_Enseignant.php?&msg=".$msg."");
    }
    else{ 
        $pass = password_hash($mdp, PASSWORD_DEFAULT);
    try {
        $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);

        $requete_sql = "INSERT INTO enseignants values('".$code_enseignant."', '".$nom."', '".$prenom."', '".$sex."', '".$date."', '".$pass."', 'profile_pic.jpg')";
        $connexion->exec($requete_sql);

        $msg="You have successfully created the new teacher";

        header("Location:admin.php?msg=".$msg."");

        $connexion = null;
        } catch (PDOException $e) {
            echo "Erreur ! " . $e->getMessage() . "<br/>";
        }
    }}
?>