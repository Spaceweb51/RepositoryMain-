<?php
session_start();
if (isset($_GET['actorid'], $_GET['vote']) AND !empty($_GET['actorid']) AND !empty($_GET['vote'])) //test la présence des variables
{
	$vote = htmlspecialchars($_GET['vote']);
	if($vote >= 1 AND $vote <= 2)// si la demande est valide
	{
		require ("../includes/db.php");
		
		$actorid = htmlspecialchars($_GET['actorid']);
		$username = htmlspecialchars($_SESSION['username']);
		// On vérifie que $_GET['actorid'] a une valeur existante
		$result = $db->prepare('SELECT id_actor FROM actor WHERE id_actor = :actorid');
		$result->execute(array(':actorid' => $actorid));
		$data1 = $result->fetch();
		$result->closeCursor();	

		//on va chercher l'id_user du username
		$result = $db->prepare('SELECT id_user FROM main WHERE username = :username');
		$result->execute(array('username' => $username));
		$data2 = $result->fetch();
		$result->closeCursor();
		$id_user = htmlspecialchars($data2['id_user']);

		if(!$data1 OR !$data2)// si $_GET['actorid'] inexistante dans la bdd retour à l'accueil
		{
			header('Location: ../public/accueil.php');
		}
		else
		{	
			//On verifie dans la bdd si il y a des votes de l'utilisateur pour cet acteur
			$result = $db->prepare('SELECT * FROM vote WHERE id_user = :id_user AND id_actor = :actorid');
			$result->execute(array('id_user' => $id_user, 'actorid' => $actorid)); 
			$data = $result->fetch();
			$result->closeCursor();
			if($data)//si c'est le cas
			{
				// Si $_GET['vote'] est egale a 1 (likes) 
				if ($vote == 1)
				{
					if($data['rates'] == 2)//si il y a déjà un dislike dans la bdd on change le dislike en like
					{
						$update_vote = $db->prepare('UPDATE vote SET rates = 1 WHERE id_user = :id_user AND id_actor = :actorid AND rates = 2');
						$update_vote->execute(array('id_user' => $id_user, 'actorid' => $actorid));
						$update_vote->closeCursor();
					}
					if($data['rates'] == 1)//si il y a déjà un like dans la bdd, on le supprime 
					{
						$delete_vote = $db->prepare('DELETE FROM vote WHERE id_user = :id_user AND id_actor = :actorid');
						$delete_vote->execute(array('id_user' => $id_user, 'actorid' => $actorid));
						$delete_vote->closeCursor();
					}	
				}
				// Si $_GET['vote'] est egale a 2 (dislikes) 
				if ($vote == 2)
				{
					if($data['rates'] == 1)//si il y a déjà un like dans la bdd on change le like en dislike
					{
						$update_vote = $db->prepare('UPDATE vote SET rates = 2 WHERE id_user = :id_user AND id_actor = :actorid AND rates = 1');
						$update_vote->execute(array('id_user' => $id_user, 'actorid' => $actorid));
						$update_vote->closeCursor();
					}
					if($data['rates'] == 2)//si il y a déjà un dislike dans la bdd, on le supprime 
					{	
						$delete_vote = $db->prepare('DELETE FROM vote WHERE id_user = :id_user AND id_actor = :actorid');
						$delete_vote->execute(array('id_user' => $id_user, 'actorid' => $actorid));
						$delete_vote->closeCursor();
					}	
				}	
			}
			else//pas de données, pas de like ou dislike 
			{
				// Si $_GET['vote'] est egale a 1 (likes) 
				if ($vote == 1)
				{
					$insert_vote = $db->prepare('INSERT INTO vote (id_user, id_actor, rates) VALUES (:id_user, :actorid, 1)');
					$insert_vote->execute(array('id_user' => $id_user, 'actorid' => $actorid));
					$insert_vote->closeCursor();	
				}
				if ($vote == 2)
				{
					$insert_vote = $db->prepare('INSERT INTO vote (id_user, id_actor, rates) VALUES (:id_user, :actorid, 2)');
					$insert_vote->execute(array('id_user' => $id_user, 'actorid' => $actorid));
					$insert_vote->closeCursor();
				}
			}
			header('Location: ../public/acteur.php?actorid=' . $actorid);
		}
	}
	else
	{
		header('Location: ../pages/accueil.php');
	}				
}
else
{
	header('Location: ../pages/accueil.php');
}
?>