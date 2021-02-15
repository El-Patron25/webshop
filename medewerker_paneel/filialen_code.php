<?php
include "classes/db.class.php";

$connection = new DB("localhost", "vissen", "root", "", "utf8");

/*
*
	Nieuwe Medewerker aanmaken als de onderstaande waarde is geselecteerd
*
*/
if(isset($_GET['opslaan_filiaal']))
{
	$fieldnames = ["plaats"];
	$error = false;
	foreach ($fieldnames as $fieldname) {
		if(!isset($_GET[$fieldname]) || empty($_GET[$fieldname]))
		{
			$error = true;
		}
		if(!$error)
		{
			$plaats = $_GET['plaats'];
		}
	}
	try
	{
	$connection->maakFiliaal($plaats);
	header("Location: filialen.php");
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

if(isset($_GET['wijzig_filiaal_btn']))
{
	$fieldnames = ["edit_plaats"];
	$error = false;
	foreach ($fieldnames as $fieldname) {
		if(!isset($_GET[$fieldname]) || empty($_GET[$fieldname]))
		{
			$error = true;
		}
		if(!$error)
		{
			$id = $_GET['id'];
			$filiaal = $_GET['edit_plaats'];
			
		}
	}
	try
	{
		$connection->filiaalWijzigen($id, $filiaal);
		header("Location: filialen.php");
	}catch(PDOException $e)
	{
		return "er is iets fout gegaan: ".$e->getmessage();
	}
}

if(isset($_GET['filiaal_verwijderen']))
{
	$id = $_GET['filiaal_id_verwijderen'];
	$deletefiliaal = $connection->filiaalVerwijderen($id);
	header("Location: filialen.php");
}

?>