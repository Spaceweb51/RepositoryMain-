<?php
session_start();
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
								<label for="last_name">Nom :</label><input type="text" name="last_name" id="last_name" required/>

								<label for="first_name">Prénom :</label><input type="text" name="first_name" id="first_name" required/>

								<label for="username">Indentifiant / nom d'utilisateur :</label>
								<input type="text" name="username" id="username" required/>

								<label for="pass1">Mot de passe <span class="lower_italic">(8 caractères, une majuscule, un chiffre et un caractère spécial au minimum)</span> :</label>
								<input type="password" name="pass1" id="pass1" required/>

								<label for="pass2">Confirmation du mot de passe :</label><input type="password" name="pass2" id="pass2" required/>

								<label for="question">Question secrète <span class="lower_italic">(exemple : Quel est le nom de mon premier animal de compagnie ?)</span> :</label>
								<input type="text" name="question" id="question" required/>

								<label for="answer">Réponse à la question secrète :</label>
								<input type="text" name="answer" id="answer" required/>

								<input type="submit" name="submit" value="Valider">					
						</fieldset>
					</form>
				</div>
				<?php include("../includes/footer.php"); ?>
			</body>
		</html>