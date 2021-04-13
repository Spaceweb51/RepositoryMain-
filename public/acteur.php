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
		// si connecté et si on a l'id de l'acteur
		if(isset($_GET['actorid']) AND isset($_SESSION['username'])) 
		{
			$username = htmlspecialchars($_SESSION['username']);
			$actorid = htmlspecialchars($_GET['actorid']);
			require ("../includes/db.php");
			
			$result = $db->prepare('SELECT * FROM actor WHERE id_actor = :actorid');
			$result->execute(array('actorid' => $actorid));
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
				    	<p><?php echo nl2br($data['description']); ?></p><!--n12br Insère un retour à la ligne HTML à chaque nouvelle ligne pour mettre en forme la description de l'acteur-->
				    	<p><a class="acteur_linkweb" href="#"><?php echo "Aller sur le site de " . $data['actor']?></a></p>			    		
				    </div>
				</section>
				<div class="acteur_like_com">
				    	<?php // On vérifie si l'utilisateur a déjà posté un commentaire pour cet acteur
		    				$result = $db->prepare('SELECT main.id_user, post.id_actor
													FROM main
													INNER JOIN post
													ON main.id_user = post.id_user
													WHERE username = :username
													AND id_actor = :actorid');
							$result->execute(array('username' => $username, 'actorid' => $actorid));
							$data = $result->fetch();
							if(!$data)// pas de données -> pas encore de commentaire de l'utilisateur pour cet acteur -> on propose l'ajout de commentaire
							{ 
								?>
									<a href="acteur.php?actorid=<?php echo $actorid; ?>&amp;add=1#new_post">Ajouter un commentaire</a>
								<?php
							}
							else // cet utilisateur a déjà commenté cet acteur -> info + lien pour supprimer ou modifier le commentaire existant
							{
								?>
									<div class="case_commented">
										<div class="case_commented_sub">
											<p>Vous avez commenté ce partenaire</p>
											<p class="separateur"> | </p>
											<a href="../control/cont_commentaire.php?actorid=<?php echo $actorid; ?>&amp;delete=1">Supprimer votre commentaire</a>
											<p class="separateur"> | </p>
											<a href="acteur.php?actorid=<?php echo $actorid; ?>&amp;mod=1#mod_post"> Modifier votre commentaire</a>
										</div>
									</div>
							<?php
							}
							// Recuperation du nombre de likes 
                            $result = $db->prepare('SELECT * FROM vote WHERE id_actor = :actorid AND rates = 1');
                            $result->execute(array('actorid' => $_GET['actorid']));
                            $likes_number = $result->rowCount();

                            // Recuperation du nombre de dislikes 
                            $result = $db->prepare('SELECT * FROM vote WHERE id_actor = :actorid AND rates = 2');
                            $result->execute(array('actorid' => $_GET['actorid']));
                            $dislikes_number = $result->rowCount();

                            //on va chercher l'id_user du username
							$result = $db->prepare('SELECT id_user FROM main WHERE username = :username');
							$result->execute(array('username' => $username));
							$data = $result->fetch();
							$result->closeCursor();
							$id_user = htmlspecialchars($data['id_user']);	

							//recuperation des valeurs like/dislike
							$result = $db->prepare('SELECT * FROM vote WHERE id_actor = :actorid AND id_user = :id_user AND rates = 1');
							$result->execute(array('actorid' => $actorid,'id_user' => $id_user));
							$likes = $result->fetch();

							$result = $db->prepare('SELECT * FROM vote WHERE id_actor = :actorid AND id_user = :id_user AND rates = 2');
							$result->execute(array('actorid' => $actorid,'id_user' => $id_user));
							$dislikes = $result->fetch();
							//et renvoi des données pour l'affichage des likes,dislikes et leurs nombres
							?>
							<div class="acteur_like" id='likes'>
								<div class="acteur_like_sub">
									<?php
									if($likes)
									{
									?>
										Je recommande<p class="separateur"> | </p>  
					    				<a href="../control/cont_vote.php?actorid=<?php echo $actorid; ?>&vote=1#likes" title="like">( <?php echo $likes_number; ?> ) Likes<img src="logos/like_blue.png" class="like_button" alt="like_button"/></a>
					    			<?php
					    			}
					    			else
					    			{
					    			?>	
					    				<a href="../control/cont_vote.php?actorid=<?php echo $actorid; ?>&vote=1#likes" title="like">( <?php echo $likes_number; ?> ) Likes <img src="logos/like.png" class="like_button" alt="like_button"/></a>
					    			<?php
					    			}
					    			?>	
					    				<p class="separateur"> | </p>
					    			<?php		
					    			if($dislikes)
	                                {
	                                ?>
	                                	<a href="../control/cont_vote.php?actorid=<?php echo $actorid; ?>&vote=2#likes"	title="dislike">( <?php echo $dislikes_number; ?> ) Dislikes<img src="logos/dislike_red.png" class="dislike_button" alt="dislike_button"/></a>
					    				<p class="separateur"> | </p>Je déconseille	
					    			<?php
					    			}
					    			else
					    			{
					    			?>
					    				<a href="../control/cont_vote.php?actorid=<?php echo $actorid; ?>&vote=2#likes"	title="dislike">( <?php echo $dislikes_number; ?> ) Dislikes<img src="logos/dislike.png" class="dislike_button" alt="dislike_button"/></a>
					    			<?php
					    			}
					    			?>
				    			</div>
				    		</div>	
				    </div>
				 <section class="post_section">
				 	<h4>Commentaires :</h4>
				 	<?php 
				 	// Affichage des avertissement et erreurs
				 	if(isset($_SESSION['posted']))
					{
						    echo '<p style=color:red;>Votre commentaire a bien été ajouté.</p>';
						    unset($_SESSION['posted']);
					}
					if(isset($_SESSION['deleted_post']))
					{
						    echo '<p style=color:red;>Votre commentaire a bien été supprimé.</p>';
						    unset($_SESSION['deleted_post']);
					}
					if(isset($_SESSION['modified_post']))
					{
						    echo '<p style=color:red;>Votre commentaire a bien été modifié.</p>';
						    unset($_SESSION['modified_post']);
					}
					if(isset($_SESSION['existing_post']))
					{
						    echo '<p style=color:red;>Vous avez déjà commenté cet acteur, pour commenter à nouveau, supprimez votre précédent commentaire.</p>';
						    unset($_SESSION['existing_post']);
					}				
					if(isset($_SESSION['invalid_post']))
					{
						    echo '<p style=color:red;>Le commentaire saisi est invalide.</p>';
						    unset($_SESSION['invalid_post']);
					}									
				 	//on verifie l'existence de commentaire pour cet acteur
				 	$result = $db->prepare('SELECT id_actor FROM post WHERE id_actor = :actorid');
					$result->execute(array('actorid' => $actorid));
					$data = $result->fetch();
					$result->closeCursor();
					//si pas de commentaire:
					if(!$data)
					{
						?>
						<p> Pas encore de commentaire publié pour ce partenaire.</p>
						<?php
					}
					else//affichage des commentaires si il y en a
					{
					$result = $db->prepare('SELECT main.id_user, nom, prenom, post.id_user, id_actor, datepost, post 
											FROM post
											INNER JOIN main
											ON main.id_user = post.id_user
											WHERE id_actor = :actorid
											ORDER BY datepost DESC');
					$result->execute(array('actorid' => $actorid));
					while($data = $result->fetch())
					{
						$nom = htmlspecialchars($data['nom']);
						$prenom = htmlspecialchars($data['prenom']);
						//mise au format de la date pour affichage  (aaaa-mm-jj hh:mm:ss)->(Le jj/mm/aaaa)
						$date = preg_replace("#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}:[0-9]{2}:[0-9]{2})#","Le $3/$2/$1",$data['datepost']);
						$post = htmlspecialchars($data['post']);
						?>
				 			<div class="post">
				 				<div class="post_photo"><img src="logos/profil.png" alt="avatar"/></div>
				 				<p class="user_postref"><?php echo $date . " " . $prenom . " " . $nom . " a commenté :" ?></p>
				 				<p><?php echo nl2br($post); ?></p>
				 			</div>
			<?php
				 	}		
				 	$result->closeCursor();
				 }
			}
			?>	 	
				</section>
				<?php
				//affichage du textarea pour saisir le post ou le modifier 
				if(isset($_GET['add']) AND $_GET['add'] == 1)
				{
				?>	
					<form class="add_comment" action="../control/cont_commentaire.php?actorid=<?php echo $actorid; ?>" method="post">
						<label for="new_post">Saisir votre commentaire : </label><textarea name="new_post" id="new_post"></textarea>
						<input type="submit" name="new_post_submit" value="Publier"/>
					</form>	
				<?php		
				}
				if(isset($_GET['mod']) AND $_GET['mod'] == 1)
				{
					$result = $db->prepare('SELECT main.id_user, post.id_user, id_actor, post 
											FROM post
											INNER JOIN main
											ON main.id_user = post.id_user
											WHERE id_actor = :actorid
											ORDER BY datepost DESC');
					$result->execute(array('actorid' => $actorid));
					$data = $result->fetch();
					$post = htmlspecialchars($data['post']);
				?>	
					<form class="add_comment" action="../control/cont_commentaire.php?actorid=<?php echo $actorid; ?>" method="post">
						<label for="mod_post">Modifier votre commentaire : </label><textarea name="mod_post" id="mod_post"><?php echo nl2br($post); ?></textarea>
						<input type="submit" name="modif_post_submit" value="Publier"/>
					</form>	
				<?php		
				}	
		}
		else
		{
			// utilisateur non connecté renvoyé page accueil (connexion)
			header('Location: connect.php');
		}
		?>
	</div>
	<?php include("../includes/footer.php"); ?>
	</body>
</html>