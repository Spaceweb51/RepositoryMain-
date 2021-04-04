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
		<title>Acteur</title>
	</head>
	<body>
	<?php include("../includes/header.php"); ?>
	<div class="content acteur_content">
		<?php
		if(isset($_GET['actorid']) AND isset($_SESSION['username'])) // si connecté et si on a l'id de l'acteur
		{
			$username = htmlspecialchars($_SESSION['username']);
			$actor = htmlspecialchars($_GET['actorid']);
			try
			{
			$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', 'root');
			}
			catch (Exception $e)
			{
			    die('Erreur : ' . $e->getMessage());
			}
			$result = $db->prepare('SELECT * FROM actor WHERE id_actor = :actor');
			$result->execute(array('actor' => $actor));
			$data = $result->fetch();
			$result->closeCursor();
			if(!$data)// Si l'id_actor ne renvoie pas à un acteur existant, retour à l'accueil
			{
				header('location: accueil.php');	
			}
			else//l'id_actor renvoie à un acteur existant on affiche son contenu
			{
			?>
				<section class="acteur_full">
			    	<div class="acteur_full_logo"><img src="logos/<?= $data['logo']; ?>" alt="logo <?= $data['actor']; ?>">
			    	</div>
			    	<div class="acteur_full_description">
				    	<h3><?php echo $data['actor']; ?></h3>
				    	<p><?php echo ($data['description']); ?></p>
				    	<p><a class="acteur_linkweb" href="#"><?php echo "Aller sur le site de " . $data['actor']?></a></p>			    		
				    </div>
				</section>
					
			<?php		
			}	
		}
		else
		{
			// utilisateur non connecté renvoyé page accueil (connexion)
			header('Location: connexion.php');
		}
		?>
	</div>
	<?php include("../includes/footer.php"); ?>
	</body>
</html>