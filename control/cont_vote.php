<?php
session_start();
if (isset($_GET['actorid'], $_GET['vote']) AND !empty($_GET['actorid']) AND !empty($_GET['vote']))
{
	try
		{
		$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', 'root');
		}
		catch (Exception $e)
		{
		        die('Erreur : ' . $e->getMessage());
		}

	$actorid = htmlspecialchars($_GET['actorid']);
	$vote = (int)$_GET['vote'];
	$username = htmlspecialchars($_SESSION['username']);
	// On vérifie que $_GET['actorid'] a une valeur existante
	$result = $db->prepare('SELECT id_actor FROM actor WHERE id_actor = :actorid');
	$result->execute(array(':actorid' => $actorid));
	$data = $result->fetch();
	//$result->closeCursor();
	if(!$data)// si $_GET['actorid'] inexistante dans la bdd retour à l'accueil
	{
		header('Location: ../public/accueil.php');
	}
	else
	{
		// Si la variable $vote est egale a 1 (likes), suppression de la valeur 2 (dislikes) 
		if ($vote == 1)
		{
			$delete_vote = $db->prepare('DELETE FROM vote WHERE id_user = :username AND id_actor = :actorid AND rates = 2');
			$delete_vote->execute(array('username' => $username, 'actorid' => $actorid));
			$delete_vote->closeCursor();

			//Si la variable $vote est egale a 1 (likes) et est déja existante dans la table, on supprime le like
			$check_vote = $db->prepare('SELECT * FROM vote WHERE id_user = :username AND id_actor = :actorid');
			$check_vote->execute(array('username' => $username, 'actorid' => $actorid));

			if ($check_vote->rowCount() == 1) //Si la ligne existe dans la bdd
			{				
				$delete_vote = $db->prepare('DELETE FROM vote WHERE id_user = :username AND id_actor = :actorid AND rates = 1');
				$delete_vote->execute(array('username' => $username, 'actorid' => $actorid));
			}
			// Si la variable $vote est egale a 1 (likes) et est inexistante dans la table, ajout du like
			else
			{
				$insert_vote = $db->prepare('INSERT INTO vote (id_user, id_actor, rates) VALUES (:username, :actorid, 1)');
				$insert_vote->execute(array('username' => $username, 'actorid' => $actorid));

			}

		}		
		// Si la variable $vote est egale a 2 (dislikes), suppression de la valeur 1 (likes) 
		elseif ($vote == 2)
		{
			$delete_vote = $db->prepare('DELETE FROM vote WHERE id_user = :username AND id_actor = :actorid AND rates = 1');
			$delete_vote->execute(array('username' => $username, 'actorid' => $actorid));
			$delete_vote->closeCursor();

			//Si la variable $vote est egale a 2 (dislikes) et est déja existante dans la table, on supprime le dislike 
			$check_vote = $db->prepare('SELECT * FROM vote WHERE id_user = :username AND id_actor = :actorid');
			$check_vote->execute(array('username' => $username, 'actorid' => $actorid));

			if ($check_vote->rowCount() == 1) //Si la ligne existe dans la bdd
			{				
				$delete_vote = $db->prepare('DELETE FROM vote WHERE id_user = :username AND id_actor = :actorid AND rates = 2');
				$delete_vote->execute(array('username' => $username, 'actorid' => $actorid));
			}
			// Si la variable $vote est egale a  2 (dislikes) et est inexistante dans la table, ajout du dislike
			else
			{
				$insert_vote = $db->prepare('INSERT INTO vote (id_user, id_actor, rates) VALUES (:username, :actorid, 2)');
				$insert_vote->execute(array('username' => $username, 'actorid' => $actorid));
			}
		}		
		header('Location: ../public/acteur.php?actorid=' . $actorid);
	}
}
else
{
	header('Location: ../pages/accueil.php');
}
?>