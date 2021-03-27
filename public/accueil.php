<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width" />
		<link rel="stylesheet" href="style.css" />
		<link rel="icon" type="image/png" href="logos/gbaf_ico.png" />
		<title>Accueil GBAF</title>
	</head>
	<body>
	<?php include("../includes/header.php"); ?>
		<div class="content accueil_content">
		<?php
		if(isset($_SESSION['username']) AND !empty($_SESSION['username']))
		{
			?>






	<?php
		}
		else
		{
			header('Location: connect.php');
		}
	?>
		</div>
		<?php include("../includes/footer.php"); ?>
	</body>
</html>		