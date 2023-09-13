<?php session_start();
include "../database.php";
$title = $_POST["title"];
$code_module = $_POST["code_module"];
$teacher = $_POST["teacher"];
$credit = $_POST["credit"];
$coeff = $_POST["coeff"];
$specialite = $_POST["specialite"];
$level = $_POST["level"];
$semester = $_POST["semester"];
if (isset($_POST["tp"])) {
    $tp = 1;
} else {
    $tp = 0;
}
if (isset($_POST["control"])) {
    $control = 1;
} else {
    $control = 0;
}
if (isset($_POST["exam"])) {
    $exam = 1;
} else {
    $exam = 0;
}
if (!isset($_SESSION["ad_id"])) {
    header("Location:index.php?msg=");
} else {
    try {
        $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password );
        $requete_sql = "INSERT INTO modules values('" . $code_module . "', '" . $title . "', " . $credit . ", " . $coeff . ", '" . $teacher . "', '" . $specialite . "', '" . $level . "', " . $semester . ", " . $tp . ", " . $control . ", " . $exam . ")";
        $connexion->exec($requete_sql);
        header("Location:admin.php");
        $connexion = null;
    } catch (PDOException $e) {
        echo "Erreur ! " . $e->getMessage() . "<br/>";
    }
} ?>
