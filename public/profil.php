<?php
session_start();
	if(isset($_SESSION['username'])) //If session exist 
	{
	$nom = htmlspecialchars($_SESSION['last_name']);
	$prenom = htmlspecialchars($_SESSION['first_name']);
	$username = htmlspecialchars($_SESSION['username']);	
?>
	
	<!DOCTYPE html>
		<html lang="fr">
			<head>
				<meta charset="UTF-8" />
				<meta name="viewport" content="width=device-width" />
				<link rel="stylesheet" href="style.css" />
				<link rel="icon" type="image/png" href="logos/gbaf_ico.png" />
				<title>Mon profil</title>
			</head>
			<body>
			<?php include("../includes/header.php"); ?>
				<div class="content accueil_content">
					<section class="profil_section">
						<h1>Mon profil</h1>
								<div class="user_profil">
									<div class=user_profil_avatar>
										<p><img src="logos/profil.jpg"/></p>	
									</div>
									<div  class=user_profil_info>
										<p>Nom : <?php echo $nom ?></p>
										<p>Prénom : <?php echo $prenom ?></p>
										<p>Identifiant : <?php echo $username ?></p>							
									</div>
								</div>
								<div class="modifprofil_link"><a href="profil.php?page=idchange">Modifier son identifiant</a><p>  |  </p><a href="profil.php?page=mdpchange">Modifier son mot de passe</a>
								</div>
					</section>
				</div>	
				<?php include("../includes/footer.php"); ?>
			</body>
<?php
}
else // pas de connexion -> retour accueil
{
	header('Location: accueil.php');
}
?>
		</html>			