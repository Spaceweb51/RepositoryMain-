<?php 

    // paramètre db à modifier si besoin 
    $host       = "localhost";
    $dbname     = "gbaf";
    $user       = "root";
    $password   = "root";
//connection db + debug

    try 
{
    $db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

}
		catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
?>