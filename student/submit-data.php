<?php 
session_start();

include '../database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$msg = "";

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$num_etudiant = $_POST['num_etudiant'];
$date_naiss = $_POST['date_naiss'];
$email = $_POST['email'];

$timestamp = strtotime($date_naiss);
$date = date("Y-m-d", $timestamp);


$error = 0;
$exist = 0;


try{
    $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
    $req = "SELECT * FROM etudiants";
    $res = $connexion->query($req);
    while($lines = $res->fetch(PDO::FETCH_ASSOC))
    {
        if($lines['email'] == $email) $error++;
        if($lines['numero_etudiant'] == $num_etudiant) $exist++;
    }
    if($error > 0){
        $msg = "This account already exist!";
        header("Location:inscription.php?msg=".$msg."");
    }
    else{
        if($exist == 0){
            $msg = "Votre numero etudiant n`est pas correcte!";
            header("Location:inscription.php?msg=".$msg."");
        }
        else{
            $req1 = "SELECT count(*) FROM etudiants where numero_etudiant = '".$num_etudiant."'  and date_naissance ='".$date."'";
            $res1 = $connexion->query($req1);
            $kip = $res1->fetch(PDO::FETCH_ASSOC)['count(*)'];
            if($kip != 1){
                $msg = "Data not matching, please fill correct data!";
                header("Location:inscription.php?msg=".$msg."");
            }

            else{

                require 'PHPMailer/src/Exception.php';
                require 'PHPMailer/src/PHPMailer.php';
                require 'PHPMailer/src/SMTP.php';

                $mail = new PHPMailer(true);
                $mail->CharSet = "utf-8";
                $mail->IsSMTP();

                $mail->SMTPAuth = true; 

                $mail->Username = "kingshowa12@gmail.com";
                $mail->Password = "studentsresults123";
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Host = "smtp.gmail.com";

                $mail->Port = 465;
                $mail->From='kingshowa12@gmail.com';
                $mail->FromName='UnivTlemcen';
                $mail->AddAddress($email, $prenom);
                $mail->Subject  =  'RESULTS DISTRIBUTION ACCOUNT CONFIRMATION';
                $mail->IsHTML(true);
                $mail->Body = '<p>You are almost done, click the button bellow to confirm your account or copy the url and paste in your browser</p> <br/> <a href="localhost/STUDENTS_RESULTS_DISTRIBUTOIN_SYSTEM/student/insert_password.php?email='.$email.'&id='.$num_etudiant.'"><button>CONFIRM</button></a> <br/> <p>localhost/STUDENTS_RESULTS_DISTRIBUTOIN_SYSTEM/student/insert_password.php?email='.$email.'&id='.$num_etudiant.'</p>';
                //$mail->Send();


                $msg = "We have sent you an email to confirm your account";
                header("Location:inscription.php?msg=".$msg."");


            }
        }
    }


    $connexion = null;
}catch (PDOException $e) {
    echo "Erreur ! " . $e->getMessage() . "<br/>";
}



?>