<?php
if(isset($_POST) AND !empty($_POST['last_name']) 
				AND !empty($_POST['first_name'])
				AND !empty($_POST['username'])
				AND !empty($_POST['pass1'])
				AND !empty($_POST['pass2'])
				AND !empty($_POST['question'])
				AND !empty($_POST['answer']))
{
	foreach($_POST as $key => $value) // htmlspecialchars for all
	{
		$_POST[$key] = htmlspecialchars($_POST[$key]);
	}
	try
	{
	$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', 'root');
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	}
	// Test username
	$result = $db->prepare('SELECT username FROM main WHERE username = :username');
	$result->execute(array('username' => $_POST['username']));
	$data = $result->fetch();
	$result->closeCursor();
	if($data)
	{
		// if username exist
		$error[] = 'exist';
	}
	if(strlen($_POST['username']) < 3)
	{
		// if username too short
		$error[] = 'short';
	}
	if(!preg_match("#(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\d)(?=.*[^A-Za-z\d])#",$_POST['pass1']) OR strlen($_POST['pass1']) < 8)
	{
		// if invalid password format
		$error[] = 'invalidpass';
	}
	if($_POST['pass1'] != $_POST['pass2'])
	{
		// if password do not match
		$error[] = 'passnotmatch';
	}
	if(!isset($error))
	{
		// no error = write the data in db
	$pass = password_hash($_POST['pass1'],PASSWORD_DEFAULT);
	$answer = password_hash($_POST['answer'],PASSWORD_DEFAULT);
	$query = $db->prepare('INSERT INTO main(nom, prenom, username, password, question, reponse) VALUES(:nom, :prenom, :username, :pass, :question, :answer)');
	$query->execute(array('nom' => $_POST['last_name'], 'prenom' => $_POST['first_name'], 'username' => $_POST['username'], 'pass' => $pass, 'question' => $_POST['question'], 'answer' => $answer));
	$query->closeCursor();
		// send a message confirming registration
		session_start();
		$_SESSION['success'] = true;
		header('Location: ../public/accueil.php');
	}
}
else
{
	//if text fields are missing
	$error[] = 'entrymissing';
}
		//return errors
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