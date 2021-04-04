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
		<title>Accueil GBAF</title>
	</head>
	<body>
	<?php include("../includes/header.php"); ?>
		<div class="content accueil_content">
			<?php
			if(isset($_SESSION['username']) AND !empty($_SESSION['username']))
			{
			?>
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
			<section class="acteur_section">
				<div class="acteur_txt">
					<h2>Les acteurs et partenaires</h2>
						<p>Vous trouverez ici un point d’entrée unique, répertoriant un grand nombre d’informations sur les partenaires et acteurs du groupe ainsi que sur les produits et services bancaires et financiers. Dans le but de mieux cerner les qualités et compétence de chacun, nous vous invitons à y laisser des commentaires et des apréciations constructives.</p>
				</div>
					<?php // Récupération des infos et extraits de tous les partenaires
						try
						{
							$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', 'root');
						}
						catch (Exception $e)
						{
						    	die('Erreur : ' . $e->getMessage());
						}
						$result = $db->query('SELECT * FROM actor');
						while($data = $result->fetch())
						{
							$description = htmlspecialchars($data['description']);
							//strtok prend le premier segment de la description jusqu'au point (donc la 1ere phrase de la description) 
							$phrase = strtok($description,".");
					?>								
							<div class="acteur">
								<div class="acteur_logo_desc">
								    <div class="acteur_logo"><img src="logos/<?= $data['logo']; ?>" alt="logo <?php echo $data['actor']; ?>"></div>
								    	<div class="acteur_description_phrase">
									    	<h3><?php echo $data['actor']; ?></h3>									    			
									    	<p>
									    	<?php
									    	//affiche la premiere phrase de la description 
									    	echo $phrase;
									    	?> ... </p><a class="acteur_linkweb" href="#"><?php echo 'Aller sur le site de ' . $data['actor']?></a></p>
									    </div>
									</div>
									<a class="acteur_suite" href="acteur.php?actorid=<?php echo $data['id_actor']; ?>">Lire la suite</a>
							</div>
					<?php
						}
						$result->closeCursor();
					?>
			</section>		
		<?php
			}
			else
			{
				header('Location: connect.php');
			}
		?>
		</div>
		<?php include("../includes/footer.php"); ?>
	</body>
</html>		