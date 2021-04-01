<?php
if(isset($_POST) AND !empty($_POST['username']) AND !empty($_POST['password']))
{	//connect Db
	try
	{
	$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', 'root');
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	}
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);
	$result = $db->prepare('SELECT nom, prenom, username, password FROM main WHERE username = :username');
	$result->execute(array('username' => $username));
	$content = $result->fetch();
	$testpass = password_verify($password,$content['password']);
	if($content AND $testpass)
	{
		session_start();
		$_SESSION['last_name'] = $content['nom'];
		$_SESSION['first_name'] = $content['prenom'];
		$_SESSION['username'] = $content['username'];
		header('Location: ../public/accueil.php');
	}
	else // bad username or password
	{
		session_start();
		$_SESSION['wrong'] = true ;
		header('Location: ../public/accueil.php');
	}
}
else
{
	header('Location: ../public/accueil.php');
}
?>
