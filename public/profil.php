<?php
session_start();
	if(isset($_SESSION['username'])) //Si session active 
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
				<div class ="content profil_content">
					<form class="profil_form" action="../control/cont_profil.php" method="post">
						<fieldset>
							<legend>Mon profil</legend>
								<div class="actual_profil">
									<div class="actual_profil_box1">								
										<p>Nom : <?php echo $nom ?></p>
										<p>Prénom : <?php echo $prenom ?></p>
										<p>Identifiant : <?php echo $username ?></p>									
									</div>
									<div class="actual_profil_box2">
										<div class="photo">
										<img src="logos/profil.png" alt="Avatar"/>
										</div>								
									</div>
								</div>
								<hr>
								<p><span class="titre_modif">Modifier les Paramètres</span></p>
								<?php
									//Affichage des erreurs et avertissements de mise à jour
									if(isset($_SESSION['usernamechanged']))
									{
									    echo '<p style=color:red;>La modification de l\'identifiant a bien été prise en compte.</p>';
									    unset($_SESSION['usernamechanged']);
									}
									if(isset($_SESSION['exist']))
									{
										echo '<p style=color:red;>Ce nom d\'utilisateur existe déjà, veuillez en saisir un autre.</p>';
										unset($_SESSION['exist']);
									}
									if(isset($_SESSION['short']))
									{
										echo '<p style=color:red;>Le nom d\'utilisateur saisi est trop court (minimum 3 caractères).</p>';
										unset($_SESSION['short']);
									}
									if(isset($_SESSION['passchanged']))
									{
									    echo '<p style=color:red;>La modification du mot de passe a bien été prise en compte.</p>';
									    unset($_SESSION['passchanged']);
									}
									if(isset($_SESSION['invalidpass']))
									{
										echo '<p style=color:red;>Le mot de passe saisi ne convient pas au format demandé.</p>';
										unset($_SESSION['invalidpass']);
									}
									if(isset($_SESSION['passnotmatch']))
									{
										echo '<p style=color:red;>Les deux mots de passe saisis ne correspondent pas.</p>';
										unset($_SESSION['passnotmatch']);
									}
									if(isset($_SESSION['secretchanged']))
									{
									    echo '<p style=color:red;>La modification de la question secrète a bien été prise en compte.</p>';
									    unset($_SESSION['secretchanged']);
									}
									if(isset($_SESSION['emptyfield']))
									{
									    echo '<p style=color:red;>Veuillez remplir tous les champs de la question secrète.</p>';
									    unset($_SESSION['emptyfield']);
									}		
									?>	
								<hr>
								<p><span class="titre2_modif">Modifier l'identifiant</span></p>
								<label for="username">Nouvel identifiant</label><input type="text" name="username" id="username"/>
								<hr>
								<p><span class="titre2_modif">Modifier le mot de passe</span></p>
								<label for="pass1">Nouveau mot de passe <span class="lower_italic">(8 caractères, une majuscule, un chiffre et un caractère spécial au minimum)</span> :</label><input type="password" name="pass1" id="pass1"/>
								<label for="pass2">Confirmation du nouveau mot de passe :</label><input type="password" name="pass2" id="pass2"/>
								<hr>
								<p><span class="titre2_modif">Modifier la question secrète</span></p>
								<label for="question">Question secrète <span class="lower_italic">(exemple : Quel est le nom de mon premier animal de compagnie ?)</span> :</label><input type="text" name="question" id="question"/>
								<label for="answer">Réponse à la question secrète :</label><input type="text" name="answer" id="answer"/>
								<hr>

								<input type="submit" name="submit" value="Valider">					
						</fieldset>
					</form>
				</div>
				<?php include("../includes/footer.php"); ?>
			</body>
		</html>
<?php
	}
	else // pas de connexion -> retour accueil
	{
		header('Location: accueil.php');
	}
?>
</html>
