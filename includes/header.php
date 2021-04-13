<header class="header_content">
	<div class="logo_gbaf">
		<a href="../public/accueil.php"><img src="../public/logos/gbaf.png" title="GBAF" alt="GBAF logo"/></a>
	</div>
	<?php
		if(isset($_SESSION['username']) AND !empty($_SESSION['username'])) //si la variable de session est présente, on affiche le profil + bt deconnection 
		{
		$nom = htmlspecialchars($_SESSION['last_name']);
		$prenom = htmlspecialchars($_SESSION['first_name']);
		//$username = htmlspecialchars($_SESSION['username']);	
	?>
			<div class="user_ref">
				<div class="user_photo">
					<a href="profil.php"><img src="logos/profil.png" alt="profil" title="Voir mon profil"/></a>
				</div>
				<div class="user_name">
					<a href="profil.php" title="Voir mon profil"><p><?= $prenom . ' ' . $nom; ?></p></a>
				</div>
				<form class="deconnection_form" action="../control/cont_deconnect.php" method="post"><input type="submit" value="deconnexion"/></form>				
			</div>
	<?php
		}
		else // pas de session
		{
	?>
			
	<div class="inscription_link">
			<a href="../public/inscription.php">S'inscrire</a><p>/</p><a href="../public/accueil.php">Se connecter</a>
	</div>
	<?php
		}
	?>		
</header>