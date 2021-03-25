<?php
if(isset($_POST) AND !empty($_POST['last_name']) 
				AND !empty($_POST['first_name'])
				AND !empty($_POST['username'])
				AND !empty($_POST['pass1'])
				AND !empty($_POST['pass2'])
				AND !empty($_POST['pass2'])
				AND !empty($_POST['question'])
				AND !empty($_POST['answer']))
{
	foreach($_POST as $key => $value) 
	{
		echo $key . ' vaut ' . $value . '<br/>';
	}
}	
?>		