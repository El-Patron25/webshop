<?php
include "classes/db.class.php";

$connection = new DB("localhost", "vissen", "root", "", "utf8");

/*
*
	Nieuwe Medewerker aanmaken als de onderstaande waarde is geselecteerd
*
*/
if(isset($_GET['opslaan_medewerker']))
{
	$fieldnames = ["voorletters", "voorvoegsel", "achternaam", "gebruikersnaam", "wachtwoord", "filiaal"];
	$error = false;
	foreach ($fieldnames as $fieldname) {
		if(!isset($_GET[$fieldname]) || empty($_GET[$fieldname]))
		{
			$error = true;
		}
		if(!$error)
		{
			$voorletters = $_GET['voorletters'];
			$voorvoegsel = $_GET['voorvoegsel'];
			$achternaam = $_GET['achternaam'];
			$gebruikersnaam = $_GET['gebruikersnaam'];
			$wachtwoord = $_GET['wachtwoord'];
			$filiaal = $_GET['filiaal'];
		}
	}
	try
	{
	$connection->maakMedewerkerAan($voorletters, $voorvoegsel, $achternaam, $gebruikersnaam, $wachtwoord, $filiaal);
	header("Location: medewerker.php");
	}catch(PDOException $e)
	{
		return "er is iets fout gegaan: ".$e->getmessage();
	}
}

if(isset($_GET['zoeken']))
{

	$connection->searchMedewerkers($_GET['zoeken']);
}

/*
*
	Medewerker Wijzigen als de onderstaande waarde is geselecteerd
*
*/

if(isset($_GET['wijzig_medewerker_btn']))
{
	$fieldnames = ["edit_voorletters", "edit_voorvoegsel", "edit_achternaam", "edit_gebruikersnaam", "edit_wachtwoord", "edit_locatiecode"];
	$error = false;
	foreach ($fieldnames as $fieldname) {
		if(!isset($_GET[$fieldname]) || empty($_GET[$fieldname]))
		{
			$error = true;
		}
		if(!$error)
		{
			$id = $_GET['id'];
			$voorletters = $_GET['edit_voorletters'];
			$voorvoegsel = $_GET['edit_voorvoegsel'];
			$achternaam = $_GET['edit_achternaam'];
			$gebruikersnaam = $_GET['edit_gebruikersnaam'];
			$wachtwoord = $_GET['edit_wachtwoord'];
			$locatie = $_GET['edit_locatiecode'];
		}
	}
	try
	{
		$connection->MedewerkerAanpassen($id, $voorletters, $voorvoegsel, $achternaam, $gebruikersnaam, $wachtwoord, $locatie);
		header("Location: medewerker.php");
	}catch(PDOException $e)
	{
		return "er is iets fout gegaan: ".$e->getmessage();
	}
}

if(isset($_GET['medewerker_verwijderen']))
{
	$id = $_GET['medewerker_id_verwijderen'];
	$deleteMedewerker = $connection->medewerkerVerwijderen($id);
	header("Location: medewerker.php");
}

?>