<?php
	session_start();
	//on supprime la variable de session appelée lors de la demande de mot de pass perdu
	unset($_SESSION['usernamemdpc']);
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width" />
		<link rel="stylesheet" href="style.css" />
		<link rel="icon" type="image/png" href="logos/gbaf_ico.png" />
		<title>Connexion GBAF</title>
	</head>
	<body>
		<?php include("../includes/header.php"); ?>
			<div class="content accueil_content">
			<?php
			//si une session est ouverte on est dirigé vers l'accueil
			if(isset($_SESSION['username']) AND !empty($_SESSION['username']))
			{
			header('Location: accueil.php');
			}
			else//si il n'y a pas de session->formulaire de connection
			{
			?>	
			    <form class="connect_form" action="../control/cont_connect.php" method="post">
					<fieldset>
						<legend>Connexion</legend>
							<?php
							//affichage des erreurs et avertissements
							if(isset($_SESSION['passchanged']))
							{
								    echo '<p style=color:red;>La modification du mot de passe a bien été prise en compte.</p>';
								    unset($_SESSION['passchanged']);
							}									
							if(isset($_SESSION['wrong']))
							{
								    echo '<p style=color:red;>Le mot de passe ou l\'identifiant est incorrect.</p>';
								    unset($_SESSION['wrong']);
							}
							if(isset($_SESSION['success']))
							{
								    echo '<p style=color:red;>Inscription réussie ! Vous pouvez vous connecter !</p>';
								    unset($_SESSION['success']);
							}														
							?>							
							<label for="username">Indentifiant / nom d'utilisateur :</label><input type="text" name="username" id="username" required />

							<label for="password">Mot de passe :</label><input type="password" name="password" id="password" required/>
							
							<div class="connect_link"><a href="reinitialisation.php">Mot de passe oublié ?</a><p>  |  </p><a href="inscription.php">Inscrivez-vous !</a></div>

							<input type="submit" name="submit" value="Connexion">
				
					</fieldset>			
				</form>
			<?php
			}
			?>
			</div>	
		<?php include("../includes/footer.php"); ?>
	</body>
</html>