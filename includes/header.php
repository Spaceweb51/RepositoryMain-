<header class="header_content">
	<div class="logo_gbaf">
		<a href="../public/accueil.php"><img src="../public/logos/gbaf.png" title="GBAF" alt="GBAF logo"/></a>
	</div>
	<?php
		if(isset($_GET['nom'])AND isset($_GET['prenom']))
			{
				if($_GET['nom'] == "Doe" AND $_GET['prenom'] == "Bob")
				{
				echo "	
				<div class=\"user_ref\">
				<div class=\"user_photo\">
				<a href=\"profil.php\"><img src=\"logos/profil.jpg\" alt=\"Ma photo de profil\" title=\"Voir mon profil\"/></a>
				</div>
				<div class=\"user_name\">
				<a href=\"profil.php\" title=\"Voir mon profil\"><p>Bob Doe</p></a>
				</div>
				<form class=\"deconnection_form\" action=\"../public/deconnect.php\" method=\"post\"><input type=\"submit\" value=\"deconnexion\"/></form>				
				</div>		
				";
				}
				else
				{
				echo "				
				<div class=\"inscription_link\">
				<a href=\"../public/inscription.php\">S'inscrire</a><p>/</p><a href=\"../public/accueil.php\">Se connecter</a>
				</div>
				";
				}
			}			
		else
			{
				echo "				
				<div class=\"inscription_link\">
				<a href=\"../public/inscription.php\">S'inscrire</a><p>/</p><a href=\"../public/accueil.php\">Se connecter</a>
				</div>
				";
			}
	?>				
</header>