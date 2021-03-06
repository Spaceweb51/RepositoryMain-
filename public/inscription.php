<?php
session_start();
//on supprime la variable de session appelée lors de la demande de mot de passe perdu
unset($_SESSION['usernamemdpc']);
	if(isset($_SESSION['username']))
	{
		header('Location: accueil.php');
	}
	else
	//Si il n'y a pas de session en cours	
	{
?>
	<!DOCTYPE html>
		<html lang="fr">
			<head>
				<meta charset="UTF-8" />
				<meta name="viewport" content="width=device-width" />
				<link rel="stylesheet" href="style.css" />
				<link rel="icon" type="image/png" href="logos/gbaf_ico.png" />
				<title>Inscription</title>
			</head>
			<body>
				<?php include("../includes/header.php"); ?>
				<div class ="content inscription_content">
					<form class="inscription_form" action="../control/cont_inscription.php" method="post">
						<fieldset>
							<legend>Inscription</legend>
								<?php
								//affichage des erreurs et avertissements en renvoi dans le formulaire
								if(isset($_SESSION['entrymissing']))								
								{
								    echo '<p style=color:red;>Un ou plusieurs champs sont manquants.</p>';
								    unset($_SESSION['entrymissing']);
								}
								?>
								<label for="last_name">Nom :</label><input type="text" name="last_name" id="last_name" required/>
								
								<label for="first_name">Prénom :</label><input type="text" name="first_name" id="first_name" required/>

								<label for="username">Indentifiant / nom d'utilisateur :</label><input type="text" name="username" id="username" required/>
								<?php
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
								?>
								<label for="pass1">Mot de passe <span class="lower_italic">(8 caractères, une majuscule, un chiffre et un caractère spécial au minimum)</span> :</label><input type="password" name="pass1" id="pass1" required/>
								<?php
								if(isset($_SESSION['invalidpass']))
								{
									    echo '<p style=color:red;>Le mot de passe saisi ne convient pas au format demandé.</p>';
									    unset($_SESSION['invalidpass']);
								}
								?>
								<label for="pass2">Confirmation du mot de passe :</label><input type="password" name="pass2" id="pass2" required/>
								<?php
								if(isset($_SESSION['passnotmatch']))
								{
									    echo '<p style=color:red;>Les deux mots de passe saisis ne correspondent pas.</p>';
									    unset($_SESSION['passnotmatch']);
								}					
								?>
								<label for="question">Question secrète <span class="lower_italic">(exemple : Quel est le nom de mon premier animal de compagnie ?)</span> :</label><input type="text" name="question" id="question" required/>

								<label for="answer">Réponse à la question secrète :</label><input type="text" name="answer" id="answer" required/>

								<input type="submit" name="submit" value="Valider">					
						</fieldset>
					</form>
				</div>
				<?php include("../includes/footer.php"); ?>
			</body>
		</html>
<?php
	}
?>	