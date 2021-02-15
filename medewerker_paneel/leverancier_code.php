<?php
include "classes/db.class.php";

$connection = new DB("localhost", "vissen", "root", "", "utf8");

/*
*
	Nieuwe Medewerker aanmaken als de onderstaande waarde is geselecteerd
*
*/
if(isset($_GET['opslaan_leverancier']))
{
	$fieldnames = ["naam", "telefoon"];
	$error = false;
	foreach ($fieldnames as $fieldname) {
		if(!isset($_GET[$fieldname]) || empty($_GET[$fieldname]))
		{
			$error = true;
		}
		if(!$error)
		{
			$naam = $_GET['naam'];
			$telefoon = $_GET['telefoon'];
		}
	}
	try
	{
	$connection->maakLeverancier($naam, $telefoon);
	header("Location: leveranciers.php");
	}catch(PDOException $e)
	{
		return "er is iets fout gegaan: ".$e->getmessage();
	}
}

/*
*
	Medewerker Wijzigen als de onderstaande waarde is geselecteerd
*
*/

if(isset($_GET['wijzig_leverancier_btn']))
{
	$fieldnames = ["edit_naam", "edit_telefoon"];
	$error = false;
	foreach ($fieldnames as $fieldname) {
		if(!isset($_GET[$fieldname]) || empty($_GET[$fieldname]))
		{
			$error = true;
		}
		if(!$error)
		{
			$id = $_GET['id'];
			$naam = $_GET['edit_naam'];
			$telefoon = $_GET['edit_telefoon'];
			
		}
	}
	try
	{
		$connection->wijzigLeverancier($id, $naam, $telefoon);
		header("Location: leveranciers.php");
	}catch(PDOException $e)
	{
		return "er is iets fout gegaan: ".$e->getmessage();
	}
}

if(isset($_GET['leverancier_verwijderen']))
{
	$id = $_GET['leverancier_id_verwijderen'];
	$connection->verwijderLeverancier($id);
	header("Location: leveranciers.php");
}

?>