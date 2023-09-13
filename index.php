<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_INSC_LOGIN.css">
    <title>Student Results Distribution System</title>
</head>
<body>
    <header class="tete">
        <div class="logo">
            <img src="images/logo-en 1.svg" alt=""  height="80px" id="logo">
        </div>
        <div class="uni-name">
            <h1>UNIVERSITY OF TLEMCEN</h1>
            <h3>FACULTY OF SCIENCES</h3>
            <h2>DEPARTMENT OF COMPUTER SCIENCE</h2>
        </div>
        <div class="profile-icon">
                <img src="images/th (1).jpg" alt="" width="70px" height="70px" id="prof-pic">
            
            <p id="profile">SIGN UP</p>
        </div>  
    </header>  
    <section class="content">
        <div class="content-text">
            <p>SYSTÈME DE GESTION ET DE DISTRIBUTION DE NOTES</p>

            <?php 
                 if(isset($_GET['msg']))
                    $msg = $_GET['msg'];
                else
                    $msg = "";

                 echo'<p style="margin-top: 30px; display: block; color: red; margin-top: 30px;">'.$msg.' </p>'
             ?>
            
        </div>
        <div class="content-form">
            <form action="student/authentification.php" method="post">
                <div class="champ ">
                    <p style="font-weight:bold; font-size: 25px;">BIENVENUE</p>
                </div>
                <div class="champ">
                    <input type="text" name="num_etudiant" placeholder="Numero Etudiant" required>
                </div>
                <div class="champ">
                    <input type="password" name="mdp" placeholder="Mot de passe" autocomplete="new-password" required>
                </div>
                <div class="champ">
                    <input type="submit" value="CONNEXION">
                </div>
                <div class="champ">
                    <p>Mot de passe oublié ?| <a href="student/inscription.php">S'inscrire</a></p>
                </div>
            </form>
            
        </div>
    </section>
    <div class="footer">
        <p id="one">Universite de Tlemcen 2022</p>
        <p id="two">admin@univ-tlemcen.dz</p>
    </div>
</body>
</html>
