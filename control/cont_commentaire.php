<?php
	session_start();
if(isset($_GET['actorid']) AND isset($_SESSION['username'])) // on test la présence des variables
{
	$actorid = htmlspecialchars($_GET['actorid']);
	$username = htmlspecialchars($_SESSION['username']);	
	try
	{
	$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', 'root');
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	}
	// On vérifie que $_GET['actorid'] a une valeur existante
	$result = $db->prepare('SELECT id_actor FROM actor WHERE id_actor = :actorid');
	$result->execute(array(':actorid' => $actorid));
	$data = $result->fetch();
	//$result->closeCursor();
	if(!$data)// si $_GET['actorid'] inexistante dans la bdd retour à l'accueil
	{
		header('Location: ../public/accueil.php');
	}
	else //si $_GET['actorid'] existe (si l'acteur existe)
	{
		// On récupérer l'identifiant utilisateur via username
		$result = $db->prepare('SELECT id_user FROM main WHERE username = :username');
		$result->execute(array('username' => $username));
		$data = $result->fetch();
		$result->closeCursor();
		$id_user = htmlspecialchars($data['id_user']);
		if(isset($_GET['delete']) AND $_GET['delete'] == 1)// on controle la variable qui demande la suppression du commentaire
		{
			// Suppression du commentaire pour l'acteur souhaité
			$query = $db->prepare('DELETE FROM post WHERE id_user = :id_user AND id_actor = :actorid');
			$query->execute(array('id_user' => $id_user, 'actorid' => $actorid));
			$query->closeCursor();
			//envoi de la confirmation de suppression à la page acteur
			$_SESSION['deleted_post'] =  true ;
			header('Location: ../public/acteur.php?actorid=' . $actorid);			
		}
		if(isset($_POST['mod_post']) AND !empty($_POST['mod_post']) AND strlen($_POST['mod_post']) > 1) // on test la validité de la variable pour modifier commentaire
		{
			// modification du commentaire pour l'acteur souhaité
			$mod_post = htmlspecialchars($_POST['mod_post']);
			$result = $db->prepare('UPDATE post SET post = :post WHERE id_user = :id_user AND id_actor = :actorid');
			$result->execute(array('id_user' => $id_user, 'actorid' => $actorid, 'post' => $mod_post));
			$result->closeCursor();
			//envoi de la confirmation de modification à la page acteur
			$_SESSION['modified_post'] =  true ;
			header('Location: ../public/acteur.php?actorid=' . $actorid);	
		}
		if(isset($_POST['new_post']) AND !empty($_POST['new_post']) AND strlen($_POST['new_post']) > 1) // on test la validité de la variable qui envoie le nouveau commentaire
		{	
		// On verifie qu'un commentaire de cet acteur par cet utilisateur n'existe pas déjà
		$result = $db->prepare('SELECT id_post FROM post WHERE id_user = :id_user AND id_actor = :actorid');
		$result->execute(array('id_user' => $id_user, 'actorid' => $actorid));
		$data = $result->fetch();
		$result->closeCursor();
			if(!$data) //si il n'y a pas déjà de commentaires -> écriture dans la table des post
			{
				$new_post = htmlspecialchars($_POST['new_post']);			
				$result = $db->prepare('INSERT INTO post(id_user, id_actor, post) VALUES(:id_user, :id_actor, :post)');
				$result->execute(array('id_user' => $id_user, 'id_actor' => $actorid, 'post' => $new_post));
				$result->closeCursor();
				// Retour à la page de l'acteur pour confirmer l'enregistrement du post
				$_SESSION['posted'] =  true ;
				header('Location: ../public/acteur.php?actorid=' . $actorid);	
			}
			else//si un commentaire existe déjà -> envoie d'un message d'erreur dans la page acteur
			{
				$_SESSION['existing_post'] = true ;
				header('Location: ../public/acteur.php?actorid=' . $actorid);	
			}	
		}	
			
	}
}
else
{ 
	header('Location: ../pages/accueil.php');	
}
?>