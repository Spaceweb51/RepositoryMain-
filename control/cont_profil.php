<?php
session_start(); 
if(isset($_SESSION['username'])) // si session active
{
	foreach($_POST as $key => $value)
	{
		$_POST[$key] = htmlspecialchars($_POST[$key]);
	}
	$username = htmlspecialchars($_SESSION['username']); //htmlspecialchars pour tous
	//connexion db
	try
	{
	$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', 'root');
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	}

	// On récupère l'id user pour la suite
	$result = $db->prepare('SELECT id_user FROM main WHERE username = :username');
	$result->execute(array('username' => $username));
	$data = $result->fetch();
	$result->closeCursor();
	$id_user = htmlspecialchars($data['id_user']);


	// Gestion du changement d'identifiant
	if(isset($_POST['username']) AND !empty($_POST['username']))
	{
		// Test si username disponnible
		$result = $db->prepare('SELECT username FROM main WHERE username = :username');
		$result->execute(array('username' => $_POST['username']));
		$data = $result->fetch();
		$result->closeCursor();			
		if(strlen($_POST['username']) < 3)
		{
			// trop court invalide
			$error[] = 'short';			
		}
		elseif($data)
		{
			// username existant
			$error[] = 'exist';
		}
		else
		{
			// si tout se passe bien
			$new_username = $_POST['username'];
			$req = $db->prepare('UPDATE main SET username = :new_username WHERE id_user = :id_user');
			$req->execute(array('new_username' => $new_username, 'id_user' => $id_user));
			$req->closeCursor();			
			$_SESSION['username'] = $new_username;
			$_SESSION['usernamechanged'] = true;		
		}			
	}
	// Gestion de changement mot de passe
	if(!empty($_POST['pass1']) AND !empty($_POST['pass2']))
	{
		if(!preg_match("#(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\d)(?=.*[^A-Za-z\d])#",$_POST['pass1']) OR strlen($_POST['pass1']) < 8)
		{
		// format mot de passe invalide
		$error[] = 'invalidpass';
		}
		if($_POST['pass1'] != $_POST['pass2'])
		{
		// les mots de passe ne correspondent pas
		$error[] = 'passnotmatch';
		}
		if(!isset($error))//si c'est ok on update
		{
			$new_password = password_hash($_POST['pass1'], PASSWORD_DEFAULT);
			$req = $db->prepare('UPDATE main SET password = :new_password WHERE id_user = :id_user');
			$req->execute(array('new_password' => $new_password, 'id_user' => $id_user));
			$req->closeCursor();
			$_SESSION['passchanged'] = true;
		}
			
	}
	//Gestion du changement de question secrète
	//On teste si si l'utilisateur a bien rempli la question et la réponse   
	if((!empty($_POST['question']) AND empty($_POST['answer'])) OR (empty($_POST['question']) AND !empty($_POST['answer'])))
	{
		$error[] = 'emptyfield';
	}
	if(!empty($_POST['question']) AND !empty($_POST['answer']))// Ok, on update 
	{
		$new_answer = password_hash($_POST['answer'],PASSWORD_DEFAULT);
		$new_question = $_POST['question'];
		$req = $db->prepare('UPDATE main SET question = :new_question, reponse = :new_answer  WHERE id_user = :id_user');
		$req->execute(array('new_question' => $new_question, 'new_answer' => $new_answer, 'id_user' => $id_user));
		$req->closeCursor();
		$_SESSION['secretchanged'] = true;
	}	
	// retour à la page de profil
	header('Location: ../public/profil.php');
	//renvoi des erreurs
	if(isset($error))
	{
		foreach($error as $value => $key)
		{
			$_SESSION[$key] = true;
		}
	}
}
else // pas de connexion -> retour accueil
{
	header('Location: ../public/profil.php');
}
?>