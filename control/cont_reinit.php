<?php
	session_start();
	try
	{
		$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
		catch (Exception $e)
	{
	    die('Erreur : ' . $e->getMessage());
	}

	// l'utilisateur a entré son username
	if (isset($_POST['username'])) 
	{
		// récupération de la question secrète de l'utilisateur
		$username = htmlspecialchars($_POST['username']);
		$result = $db->prepare('SELECT username, question FROM main WHERE username = :username');
		$result->execute(array('username' => $username));
		$data = $result->fetch();
		$data['question'] = preg_replace("#(\?)#", " ", $data['question']);
		$result->closeCursor();
		if ($data)
		{
			//$_SESSION['exist'] = true;
			$_SESSION['usernamemdpc'] = $data['username'];
			$_SESSION['questionmdpc'] = $data['question'];
		}	
		if (!$data)
		{
			// if username don't exist
			$_SESSION['noexist'] = true;			
		}		
		header('Location: ../public/reinitialisation.php');
	}

	// the user has entered their answers
	if (isset($_POST['answer']) AND isset($_SESSION['usernamemdpc']) AND isset($_SESSION['questionmdpc']) AND isset($_POST['pass1']) AND isset($_POST['pass2'])) 
	{
		// vérification de la réponse
		$username = htmlspecialchars($_SESSION['usernamemdpc']);
		$answer = htmlspecialchars($_POST['answer']);
		$question = htmlspecialchars($_SESSION['questionmdpc']);
		$pass1 = htmlspecialchars($_POST['pass1']);
		$pass2 = htmlspecialchars($_POST['pass2']);	
		$result = $db->prepare('SELECT reponse, question FROM main WHERE username = :username');
		$result->execute(array('username' => $username));
		$data = $result->fetch();
		$result->closeCursor();
		//echo $answer;
		//echo $data['reponse'];
		$testanswer = password_verify($answer,$data['reponse']);
		//echo $testanswer;
		if ($testanswer == false)
			//($answer != $data['reponse'])
		{	//if the answer is not the same
			$error[] = 'novalidanswer';
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
			$pass= password_hash($_POST['pass1'], PASSWORD_DEFAULT);
			$query = $db->prepare('UPDATE main SET password = :pass WHERE username = :username');
			$query->execute(array('pass' => $pass,'username' => $username));
			$query->closeCursor();
			unset($_SESSION['usernamemdpc']);
			unset($_SESSION['questionmdpc']);
			// send a message confirming registration
			$_SESSION['passchanged'] = true;
			header('Location: ../public/connect.php');		
		}
		if(isset($error))
		{
			//session_start();
			foreach ($error as $key => $value) 
				{
					$_SESSION[$value] = true;
				}
		header('Location: ../public/reinitialisation.php');	
		}					
	}

?>