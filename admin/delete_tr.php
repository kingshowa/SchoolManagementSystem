<?php session_start();


include '../database.php';

$code_enseignant = $_POST['code_enseignant'];
$exist = 0;

if(!(isset($_SESSION['ad_id']))){
    header("Location:index.php?msg=");
}
else{
    try {
        $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);

        $req = "SELECT * FROM enseignants";
        $res = $connexion->query($req);
        while($lines = $res->fetch(PDO::FETCH_ASSOC))
        {
            if($lines['num_enseignant'] == $code_enseignant) $exist++;
        }
        if($exist == 0){
            $msg = "Code enseignant n`existe pas!";
            header("Location:delete.php?msg=".$msg."");
        }
        else{
            $requete_sql = "DELETE FROM enseignants where num_enseignant ='".$code_enseignant."'";
            $connexion->exec($requete_sql);

            header("Location:admin.php");
        }

        $connexion = null;
    } catch (PDOException $e) {
        echo "Erreur ! " . $e->getMessage() . "<br/>";
    }
}
?>