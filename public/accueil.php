<!--<?php
	//session_start();
?>-->
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width" />
		<link rel="stylesheet" href="style.css" />
		<link rel="icon" type="image/png" href="logos/gbaf_ico.png" />
		<title>Accueil GBAF</title>
	</head>
	<body>
	<?php include("../includes/header.php"); ?>
		<div class="content accueil_content">
		<!--<?php/*
		if(isset($_SESSION['username']) AND !empty($_SESSION['username']))
		{
			*/?>-->
			<section class="presentation_section">
				<h1>GBAF: Groupement Banque Assurance Français</h1>
					<p>Le GBAF est une fédération représentant les 6 grands groupes Français : BNP Paribas, BPCE, Crédit Agricole, Crédit Mutuel-CIC, Société Générale, La Banque Postale.<br>Même s'il existe une forte concurrence entre ces entités, elles vont toutes travailler de la même façon pour gérer près de 80 milions de comptes sur le territoire national.<br>Le GBAF est le représentant de la profession Française. Sa mission est de promouvoir l'activité bancaire à l'échelle nationale. C'est aussi un interlocuteur privilégié des pouvoirs publics.</p>
						<div class="illustration">
							<div class="illustration_logos">
								<a href="#"><img src="logos/bank/BP.jpg" alt="banque_postale"/></a>
								<a href="#"><img src="logos/bank/CA.png" alt="credit_agricole"/></a>
								<a href="#"><img src="logos/bank/SG.png" alt="societe_generale"/></a>
								<a href="#"><img src="logos/bank/CIC.png" alt="cic"/></a>						
								<a href="#"><img src="logos/bank/BPCE.png" alt="bpce"/></a>
								<a href="#"><img src="logos/bank/CM.png" alt="credit_mutuel"/></a>						
								<a href="#"><img src="logos/bank/BNP.png" alt="bnp_paribas"/></a>
							</div>
						</div>
			</section>
			<section class="acteurs_section">
				<div class="acteurs_txt">
					<h2>Les acteurs et partenaires</h2>
						<p>Vous trouverez ici un point d’entrée unique, répertoriant un grand nombre d’informations sur les partenaires et acteurs du groupe ainsi que sur les produits et services bancaires et financiers. Dans le but de mieux cerner les qualités et compétence de chacun, nous vous invitons à y laisser des commentaires et des apréciations constructives.</p>
				</div>
				<div class="acteurs">
					<div class="acteurs_logo_desc">
						<div class="acteurs_logo"><img src="logos/formation_co.png" alt="logo formation_co"></div>
						<div class="acteurs_description">
							<h3>formation&co</h3>
							<P>Formation&co est une association française présente sur tout le territoire.</P>	
							<p>Aller sur le site de <a class="acteurs_linkweb" href="#">formation&co</a></P>
						</div>
					</div>
					<a class="acteurs_suite" href="nomacteurs.php">Lire la suite</a>
				</div>

				<div class="acteurs">
					<div class="acteurs_logo_desc">
						<div class="acteurs_logo"><img src="logos/protectpeople.png" alt="logo protectpeople"></div>
						<div class="acteurs_description">
							<h3>protectpeople</h3>
							<P>Protectpeople finance la solidarité nationale. Nous appliquons le principe édifié par la Sécurité sociale française en 1945</p>	
							<p>Aller sur le site de <a class="acteurs_linkweb" href="#">protectpeople</a></P>
						</div>
					</div>
					<a class="acteurs_suite" href="nomacteurs.php">Lire la suite</a>
				</div>

				<div class="acteurs">
					<div class="acteurs_logo_desc">
						<div class="acteurs_logo"><img src="logos/dsa_france.png" alt="logo dsa_france"></div>
						<div class="acteurs_description">
							<h3>Dsa</h3>
							<P>Dsa France accélère la croissance du territoire et s’engage avec les collectivités territoriales.</p>	
							<p>Aller sur le site de <a class="acteurs_linkweb" href="#">Dsa France</a></P>
						</div>
					</div>
					<a class="acteurs_suite" href="nomacteurs.php">Lire la suite</a>
				</div>

				<div class="acteurs">
					<div class="acteurs_logo_desc">
						<div class="acteurs_logo"><img src="logos/cde.png" alt="logo cde"></div>
						<div class="acteurs_description">
							<h3>CDE</h3>
							<P>La CDE (Chambre Des Entrepreneurs) accompagne les entreprises dans leurs démarches de formation.</p> 
							<p>Aller sur le site de <a class="acteurs_linkweb" href="#">La CDE</a></P>
						</div>
					</div>
					<a class="acteurs_suite" href="nomacteurs.php">Lire la suite</a>
				</div>
			</section>		
	<!--<?php/*
		}
		else
		{
			header('Location: connect.php');
		}
	*/?>-->
		</div>
		<?php include("../includes/footer.php"); ?>
	</body>
</html>		