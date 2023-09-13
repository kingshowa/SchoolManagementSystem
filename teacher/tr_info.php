<?php session_start();  
      include '../database.php';

if(!isset($_SESSION['id'])){
    header("Location:index.php");
    exit();
}
else{
      try{
                  $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
                  $requete_sql = "SELECT * from enseignants where num_enseignant = '".$_SESSION['id']."'";
                  $result = $connexion->query($requete_sql);

                  $teacher = $result->fetch(PDO::FETCH_ASSOC);
                  $nom = $teacher['nom'];
                  $prenom = $teacher['prenom'];
                  $code = $teacher['num_enseignant'];
                  $dob = $teacher['date_naissance'];
                  $timestamp = strtotime($dob);
                  $date = date("d-m-Y", $timestamp);
                  $pic = $teacher['profile_picture'];

                  $connexion = null;
              } catch (PDOException $e) {
                  echo "Erreur ! " . $e->getMessage() . "<br/>";
              }
 }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Infomation</title>

    <link rel="stylesheet" href="../student/CSS/studinfo.css">
</head>


<body>


    <header class="tete">
        <div class="logo">
            <img src="../images/logo-en 1.svg" height="80px">
        </div>
        <div class="uni-name">
            <h1>UNIVERSITY OF TLEMCEN</h1>
            <h3>FACULTY OF SCIENCES</h3>
            <h2>DEPARTMENT OF COMPUTER SCIENCE</h2>
        </div>
        <div class="profile-icon">
        <?php  
            echo '<img src="../images/'.$pic.'" alt="" width="70px" height="70px" id="prof-pic">';
        ?>
            <p id="profile"><a href="logout.php">LOG OUT</a></p>
        </div>
        
    </header>

    <!---------end of tete-->

    <div class="main-side">
        <div class="profile">
            <div class="photo">
                <?php echo '<img src="../images/'.$pic.'" alt="" width="270px" height="270px">'; ?>
             
            </div>
            <div class="click">
                <a href="upload_photo.php"><div class="change-photo">CHANGE PHOTO</div></a>
                <a href="change_password.php"><div class="pass">CHANGE PASSWORD</div></a>
            </div>
        </div>


        <div class="personal-info">
            <table>
                <thead>
                    <th colspan="2">PERSONAL INFORMATION</th>
                </thead>
<?php echo '
                <tbody>
                    <tr>
                        <td>NOM DE FAMILLE</td>
                        <td>'.$nom.'</td>
                    </tr>

                    <tr>
                        <td>PRENOM</td>
                        <td>'.$prenom.'</td>
                    </tr>

                    <tr>
                        <td>DATE DE NAISANCE</td>
                        <td>'.$date.'</td>
                    </tr>

                    <tr>
                        <td>CODE ENSEIGNANT</td>
                        <td>'.$code.'</td>
                    </tr>
'; ?>
                </tbody>
            </table>
        </div>
    </div>









    <!--------start of footer-->

<div class="footer">
    <p id="one">Universite de Tlemcen 2022</p>
    <p id="two">admin@univ-tlemcen.dz</p>
</div>
    
    
</body>
</html>