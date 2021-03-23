<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width" />
		<link rel="stylesheet" href="style.css" />
		<title>Connexion GBAF</title>
	</head>
	<body>
		<?php include("../includes/header.php"); ?>
			<div class="content accueil_content">
				<form class="connection_form" action="traitement/trait_connexion.php" method="post">
					<fieldset>
						<legend>Connexion</legend>
							
							<label for="username">Indentifiant / nom d'utilisateur :</label><input type="text" name="username" id="username"/>

							<label for="password">Mot de passe :</label><input type="password" name="password" id="password"/>

							<div class="connection_link"><a href="reinitialisation.php">Mot de passe oublié ?</a><p>  |  </p><a href="inscription.php">Inscrivez-vous !</a></div>

							<input type="submit" name="submit" value="Se connecter">
				
					</fieldset>			
				</form>
			</div>	
		<?php include("../includes/footer.php"); ?>
	</body>
</html>