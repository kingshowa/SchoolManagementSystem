<?php session_start(); 
if(!(isset($_SESSION['ad_id']))){
	header("Location:index.php"); 
	exit(); 
} 
?> 
<!DOCTYPE html> 
<html lang="en"> 
	<head> 
		<meta charset="UTF-8"> 
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Manage Module</title> 
		<link rel="stylesheet" href="CSS/Creer_Module.css"> 
	</head> 
	<body> 
		<header class="tete"> 
			<div class="logo"> 
				<a href="admin.php"><img src="../images/logo-en 1.svg" alt=""  height="80px" id="logo"></a> 
			</div> 
			<div class="uni-name"> 
				<h1>UNIVERSITY OF TLEMCEN</h1> 
				<h3>FACULTY OF SCIENCES</h3> 
				<h2>DEPARTMENT OF COMPUTER SCIENCE</h2> 
			</div> 
			<div class="profile-icon"> 
				<img src="../images/th (1).jpg" alt="" width="70px" height="70px" id="prof-pic"> 
				<p id="profile"><a href="logout.php">LOGOUT</a></p> 
			</div> 
		</header> <!---------end of tete--> 
		<?php 
		if(isset($_GET['msg'])) 
			$msg = $_GET['msg']; 
		else $msg = ""; 
		   echo'<p style="margin-top: 30px; display: block; color: red; margin-top: 30px;">'.$msg.' </p>'
	    ?> 
	    <div class="main-side"> 
	    	<div   class="options"> 
	    		<div><a href="Creer_Module.php">CREER MODULES</a></div> 
	    		<div><a href="#" id="active">GERER MODULES</a></div> 
	    		<div><a href="Ajouter_enseignant.php">AJUTER ENSEIGNANT</a></div> 
	    		<div><a href="delete.php">SUPPRIMER ENSEIGNANT</a></div> 
	    		<div><a href="imprimer_releve.php">IMPRIMER RELEVE</a></div> 
	    		<div><a href="change_password.php">CHANGE MOT DE PASSE</a></div> 
	    	</div> 
	    	<div class="personal-info"> 
	    		<form action="resubmit_module.php" method="post"> 
	    			<table> 
	    				<tbody> 
	    					<tr> 
	    						<td>TITRE MODULE:</td> 
	    						<td><input type="text" name="title" required placeholder="Algorithmique"></td> 
	    					</tr> 
	    					<tr> 
	    						<td>CODE MODULE:</td> 
	    						<td><input type="text" name="code_module" required placeholder="MO123"></td> 
	    					</tr> 
	    					<tr> 
	    						<td>CODE ENSEIGNANT:</td> 
	    						<td><input type="text" name="teacher" required placeholder="E123"></td> 
	    					</tr> 
	    					<tr> 
	    						<td>CREDIT:</td> 
	    						<td><input type="number" name="credit" required placeholder="1"></td> 
	    					</tr> 
	    					<tr> 
	    						<td>COEFFICIENT:</td> 
	    						<td><input type="number" name="coeff" required placeholder="1"></td> 
	    					</tr> 
	    					<tr> 
	    						<td>SPECIALITE:</td> 
	    						<td><input type="text" name="specialite" required placeholder="SYSTEME INFORMATION"></td> 
	    					</tr> 
	    					<tr> 
	    						<td>NIVEAU</td> 
	    						<td><input type="text" name="level" required placeholder="L1"></td> 
	    					</tr> 
	    					<tr> 
	    						<td>SEMESTRE:</td> 
	    						<td><input type="number" name="semester" required placeholder="1"></td> 
	    					</tr> 
	    					<tr> 
	    						<td></td> 
	    						<td id="checkboxes"> 
	    							<input type="checkbox" name="tp"> 
	    							<span>TP</span> 
	    							<input type="checkbox" name="control"> 
	    							<span>CONTROL</span> 
	    							<input type="checkbox" name="exam"> 
	    							<span>EXAMEN</span> 
	    						</td> 
	    					</tr> 
	    					<tr> 
	    						<td></td> 
	    						<td><input type="submit" value="PROCEED"></td> 
	    					</tr> 
	    				</tbody> 
	    			</table> 
	    		</form> 
	    	</div> 
	    </div> 
	    <!--------start of footer--> 
	    <div class="footer"> 
	    	<p id="one">Universite de Tlemcen 2022</p> 
	    	<p id="two">admin@univ-tlemcen.dz</p> 
	    </div> 
	</body> 
</html>