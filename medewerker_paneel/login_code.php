<?php
include "classes/db.class.php";
$connection = new DB("localhost", "vissen", "root", "", "utf8");
if(isset($_GET['login']))
{
	$gebruikersnaam = $_GET['gebruikersnaam'];
	$wachtwoord = $_GET['wachtwoord'];
	$connection->login($gebruikersnaam, $wachtwoord);
}

?>