<?php
//test de la présence des variables
if(isset($_POST) AND !empty($_POST['last_name']) 
				AND !empty($_POST['first_name'])
				AND !empty($_POST['username'])
				AND !empty($_POST['pass1'])
				AND !empty($_POST['pass2'])
				AND !empty($_POST['question'])
				AND !empty($_POST['answer']))
{
	foreach($_POST as $key => $value) // htmlspecialchars pour tous
	{
		$_POST[$key] = htmlspecialchars($_POST[$key]);
	}
	//connection bdd
	require ("../includes/db.php");
	
	// Test username
	$result = $db->prepare('SELECT username FROM main WHERE username = :username');
	$result->execute(array('username' => $_POST['username']));
	$data = $result->fetch();
	$result->closeCursor();
	if($data)
	{
		// si le username existe déjà
		$error[] = 'exist';
	}
	if(strlen($_POST['username']) < 3)
	{
		// si le username est trop court
		$error[] = 'short';
	}
	//traitement de la chaine de caractère du password, pour vérifier son format et sa taille
	if(!preg_match("#(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\d)(?=.*[^A-Za-z\d])#",$_POST['pass1']) OR strlen($_POST['pass1']) < 8)
	{
		// si le format du password n'est pas bon
		$error[] = 'invalidpass';
	}
	if($_POST['pass1'] != $_POST['pass2'])
	{
		// si les deux password ne sont pas identiques
		$error[] = 'passnotmatch';
	}
	if(!isset($error))
	{
		// pas d'erreur, on insert les données dans la bdd + hashage (cryptage) du mdp et de la réponse
	$pass = password_hash($_POST['pass1'],PASSWORD_DEFAULT);
	$answer = password_hash($_POST['answer'],PASSWORD_DEFAULT);
	$query = $db->prepare('INSERT INTO main(nom, prenom, username, password, question, reponse) VALUES(:nom, :prenom, :username, :pass, :question, :answer)');
	$query->execute(array('nom' => $_POST['last_name'], 'prenom' => $_POST['first_name'], 'username' => $_POST['username'], 'pass' => $pass, 'question' => $_POST['question'], 'answer' => $answer));
	$query->closeCursor();
		// on envoie un message qui confirme l'inscription 
		session_start();
		$_SESSION['success'] = true;
		header('Location: ../public/accueil.php');
	}
}
else
{
	//si les champs de saisie sont vides
	$error[] = 'entrymissing';
}
		//si il y a des erreurs, on renvoie les différents messages
if(isset($error))
{
	session_start();
	foreach($error as $key => $value)
		{
			$_SESSION[$value] = true;
		}
	header('Location: ../public/inscription.php');
}
?>