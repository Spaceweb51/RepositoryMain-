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
		<title>Récupération du mot de passe</title>
	</head>
	<body>
	<?php include("../includes/header.php"); ?>
		<div class="content accueil_content">
		<?php
			if ((!isset($_SESSION['usernamemdpc']) AND !isset($_SESSION['answermdpc'])) OR (isset($_SESSION['noexist'])))
			{
		?>	
				<form class="connection_form" action="../control/cont_reinit.php" method="post">
					<fieldset>
						<legend class="long_legend">Réinitialiser le mot de passe :</legend>

						<label for="username">Veuillez saisir votre nom d'utilisateur :</label><input type="text" name="username" id="username" required />
						<?php
						if(isset($_SESSION['noexist']))
							{
									    echo '<p style=color:red;>Ce nom d\'utilisateur n\'existe pas, veuillez en saisir un nom d\'utilisateur valide.</p>';
									    unset($_SESSION['noexist']);
							}
						?>		
						<input type="submit" name="submit" value="Valider">						
					</fieldset>			
				</form>					
		<?php		
			}
			if ((isset($_SESSION['usernamemdpc']) AND !isset($_SESSION['answermdpc']) AND !isset($_SESSION['noexist'])) OR (isset($_SESSION['novalidanswer']) AND isset($_SESSION['invalidpass']) AND isset($_SESSION['passnomatch']))) 
			{
		?>		
				<form class="connection_form" action="../control/cont_reinit.php" method="post">
					<fieldset>
						<legend class="long_legend">Réinitialiser le mot de passe :</legend>
							<label for="answer">Bonjour<?php echo ' ' . $_SESSION['usernamemdpc'] . ', votre question secrète est : ' . $_SESSION['questionmdpc'] . ' ? Quelle est votre réponse ?'; ?> </label><input type="text" name="answer" id="answer" required />
							<?php
							if(isset($_SESSION['novalidanswer']))
							{
								echo '<p style=color:red;>La réponse à la question secrète est incorrecte.</p>';
								unset($_SESSION['novalidanswer']);
							}
							?>		

							<label for="pass1">Nouveau mot de passe <span class="lower_italic">(8 caractères, une majuscule, un chiffre et un caractère spécial au minimum)</span> :</label><input type="password" name="pass1" id="pass1" required />
							<?php
							if(isset($_SESSION['invalidpass']))
							{
							    echo '<p style=color:red;>Le mot de passe saisi ne convient pas au format demandé.</p>';
							    unset($_SESSION['invalidpass']);
							}
							?>
							<label for="pass2">Confirmation du mot de passe :</label><input type="password" name="pass2" id="pass2" required />
							<?php
							if(isset($_SESSION['passnotmatch']))
							{
							    echo '<p style=color:red;>Les deux mots de passe saisis ne correspondent pas.</p>';
							    unset($_SESSION['passnotmatch']);
							}					
							?>
							<input type="submit" name="submit" value="Valider">
					</fieldset>			
				</form>	
		<?php						
			}		
		?>
		</div>
		<?php include("../includes/footer.php"); ?>
	</body>
</html>			