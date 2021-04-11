<?php//si on a le username et le password
if(isset($_POST) AND !empty($_POST['username']) AND !empty($_POST['password']))
{	//connection bdd
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
	//on verifie le username et le password dans la bdd
	$result = $db->prepare('SELECT nom, prenom, username, password FROM main WHERE username = :username');
	$result->execute(array('username' => $username));
	$content = $result->fetch();
	//on verifie que le password_hash de la bdd correspond au password envoyé
	$testpass = password_verify($password,$content['password']);
	if($content AND $testpass)//si c'est ok ouverture de la page accueil
	{
		session_start();
		$_SESSION['last_name'] = $content['nom'];
		$_SESSION['first_name'] = $content['prenom'];
		$_SESSION['username'] = $content['username'];
		header('Location: ../public/accueil.php');
	}
	else // mauvais username ou password
	{
		session_start();
		$_SESSION['wrong'] = true ;
		header('Location: ../public/accueil.php');
		//et retour de la page acceuil à la page de connection
	}
}
else
{
	header('Location: ../public/accueil.php');
	//et retour de la page acceuil à la page de connection
}
?>
